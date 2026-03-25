<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\SchedaResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Tables;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Modules\Performance\Actions\ShowMailSendedAt;
use Modules\Performance\Models\StabiDirigente;
use Modules\Ptv\Actions\FixValutatoreIdByAnno;
use Modules\Ptv\Actions\GetValutatoriOptions;
use Modules\Ptv\Actions\Populate;
use Modules\Ptv\Enums\WorkerType;
use Modules\Ptv\Filament\Actions\Bulk\SendMailBulkAction;
use Modules\Ptv\Filament\Actions\Bulk\SendSchedaBulkAction;
use Modules\Ptv\Filament\Actions\Bulk\ZipSchedaBulkAction;
use Modules\Ptv\Filament\Actions\Header\CopyFromLastYearAction;
use Modules\Ptv\Filament\Actions\Header\PopulateYearAction;
use Modules\Ptv\Filament\Actions\Header\TrovaEsclusiAction;
use Modules\Ptv\Filament\Actions\Scheda\CompilaAction;
use Modules\Ptv\Filament\Columns\LavoratoreColumn;
use Modules\Ptv\Filament\Columns\PeriodoColumn;
use Modules\Ptv\Filament\Columns\QualificaColumn;
use Modules\Ptv\Filament\Columns\RepartoColumn;
use Modules\Ptv\Filament\Filters\AnnoValutatoreFilter;
use Modules\Ptv\Filament\Resources\ReportResource\Widgets\FirmaValutatoreWidget;
use Modules\Ptv\Filament\Resources\SchedaResource;
use Modules\Ptv\Filament\Resources\SchedaResource\Actions\Header\MakePdfAction;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Modules\Ptv\Models\Scheda;
use Modules\UI\Filament\Tables\Columns\GroupColumn;
use Modules\Xot\Actions\Filament\Actions\CopyFromLastYearButton;
use Modules\Xot\Filament\Actions\Header\ExportXlsAction;
use Modules\Xot\Filament\Actions\Table\PdfAction;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;
use Parental\HasChildren;
use Parental\HasParent;



class ListScheda extends XotBaseListRecords
{
    protected static string $resource = SchedaResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        $anno = Arr::get($this->tableFilters ?? [], 'anno.value');

        return [
            ...parent::getHeaderActions(),
            'copy_from_last_year' => CopyFromLastYearAction::make(),
            'populate_year' => PopulateYearAction::make(),
            'trova_esclusi' => TrovaEsclusiAction::make(),
            'export_xls' => ExportXlsAction::make(),
            'pdf' => MakePdfAction::make(),
            // 'export' => ExportXlsAction::make(), // da togliere campi etc etc
        ];
    }

    
    /**
     * @return array<string, Column>
     */
    #[Override]
    public function getTableColumns(): array
    {
        return [
            'id'=>TextColumn::make('id'),
            'ha_diritto' => IconColumn::make('ha_diritto')->boolean(),
            'motivo_invio_email' => GroupColumn::make('motivo/invio_email')->schema([
                'motivo' => TextColumn::make('motivo')->searchable(),
                'mail_sended_at' => TextColumn::make('mail_sended_at')
                    ->html()
                    ->default(app(ShowMailSendedAt::class)->execute(...)),
            ]),
            'lavoratore' => LavoratoreColumn::make('lavoratore')->appendColumns([
                'totale_punteggio' => TextColumn::make('totale_punteggio'),
                'propro' => TextColumn::make('propro'),
            ]),
            'qualifica' => QualificaColumn::make('qualifica'),
            'reparto' => RepartoColumn::make('reparto'),
            'periodo' => PeriodoColumn::make('periodo'),
            'valutatore_id' => SelectColumn::make('valutatore_id')
                ->label('valutatore')
                ->options(function (mixed $record): array {
                    if (! is_object($record) || ! isset($record->anno)) {
                        return [];
                    }
                    /** @var int $anno */
                    $anno = $record->anno;

                    return StabiDirigente::where('anno', $anno)->whereRaw('id=valutatore_id')->pluck('nome_diri', 'id')->toArray();
                })
                ->visible(auth()->user()?->isSuperAdmin() ?? false),
        ];
    }

    
    #[Override]
    public function getTableFilters(): array
    {
        return [
            'anno_valutatore' => AnnoValutatoreFilter::make('anno_valutatore'),
            'ha_diritto' => TernaryFilter::make('ha_diritto'),
            'type' => SelectFilter::make('type')
                ->options(WorkerType::class)
                ->visible(fn () => !in_array(HasParent::class, class_uses_recursive(static::getModel()))),
    
                
            
        ];
    }

    /**
     * @return array<string, Action|ActionGroup>
     */
    #[Override]
    public function getTableActions(): array
    {
        return [
            // Tables\Actions\ViewAction::make(),

            'compila' => CompilaAction::make()
                ->visible(function (SchedaContract $record): bool {
                    // @var bool|null $haDiritto
                    return (int) $record->ha_diritto > 0;
                }),
            'pdf' => PdfAction::make('pdf')
                ->visible(function (SchedaContract $record): bool {
                    /* @var bool|null $haDiritto */
                    return (int) $record->ha_diritto > 0;
                }),

            // EditAction::make(),
            // Tables\Actions\EditAction::make(),
        ];
    }

    /**
     * @return array<string, BulkAction>
     */
    #[Override]
    public function getTableBulkActions(): array
    {
        return [
            'send_mail' => SendMailBulkAction::make('send_mail'),
            'zip_schede' => ZipSchedaBulkAction::make('zip_schede'),
        ];
    }

    /**
     * @return array<string, WidgetConfiguration>
     */
    public function getHeaderWidgets(): array
    {
        // $filters = Arr::get($this->tableFilters ?? [], 'stabi_repar_anno');
        $filters = Arr::get($this->tableFilters ?? [], 'anno_valutatore');

        return [
            'firma_valutatore' => FirmaValutatoreWidget::make(['resource' => static::$resource, 'filters' => $filters]),
        ];
    }
}
