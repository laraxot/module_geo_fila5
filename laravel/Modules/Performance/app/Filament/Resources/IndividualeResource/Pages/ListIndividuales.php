<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Widgets\WidgetConfiguration;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Performance\Actions\ShowMailSendedAt;
use Modules\Performance\Filament\Actions\Bulk\SendMailBulkAction;
use Modules\Performance\Filament\Resources\IndividualeResource;
use Modules\Performance\Models\Individuale;
use Modules\Performance\Models\Organizzativa;
use Modules\Performance\Models\StabiDirigente;
use Modules\Ptv\Filament\Actions\Bulk\ZipSchedaBulkAction;
use Modules\Ptv\Filament\Actions\Header\CopyFromLastYearAction;
use Modules\Ptv\Filament\Actions\Header\PopulateYearAction;
use Modules\Ptv\Filament\Columns\LavoratoreColumn;
use Modules\Ptv\Filament\Columns\PeriodoColumn;
use Modules\Ptv\Filament\Columns\QualificaColumn;
use Modules\Ptv\Filament\Columns\RepartoColumn;
use Modules\Ptv\Filament\Filters\AnnoValutatoreFilter;
use Modules\Ptv\Filament\Resources\ReportResource\Widgets\FirmaValutatoreWidget;
use Modules\UI\Filament\Tables\Columns\GroupColumn;
use Modules\Xot\Filament\Actions\Header\ExportXlsAction;
use Modules\Xot\Filament\Actions\Table\PdfAction;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

use function Safe\date;

/**
 * ---.
 */
class ListIndividuales extends XotBaseListRecords
{
    protected static string $resource = IndividualeResource::class;

    /** @var array<string, mixed> */
    protected array $data = [];

    /**
     * @return array<string, \Filament\Actions\Action|\Filament\Actions\ActionGroup>
     */
    public function getTableActions(): array
    {
        $myclass = (static::class);

        $fill_class = Str::of($myclass)
            ->before('\\Pages\\')
            ->append('\\Pages\\FillOutTheForm')
            ->toString();

        $actions = parent::getTableActions();
        $actions['pdf'] = PdfAction::make('pdf')
            ->visible(function (mixed $record): bool {
                if (! is_object($record) || ! isset($record->ha_diritto)) {
                    return false;
                }

                return $record->ha_diritto == 1;
            });
        $actions['fill'] = Action::make('fill')
            ->label('Compila')
            ->icon('heroicon-o-pencil-square')
            ->url(fn (mixed $record) => $fill_class::getUrl(['record' => $record]))
            ->visible(function (mixed $record): bool {
                if (! is_object($record) || ! isset($record->ha_diritto)) {
                    return false;
                }

                return $record->ha_diritto == 1;
            });

        /** @var array<string, \Filament\Actions\Action|\Filament\Actions\ActionGroup> $actions */
        return $actions;
    }

    /**
     * @return array<string, Actions\CreateAction|CopyFromLastYearAction|PopulateYearAction|ExportXlsAction|Actions\Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            'parent' => CreateAction::make('create'),
            'copy_from_last_year' => CopyFromLastYearAction::make(),
            'populate_year' => PopulateYearAction::make(),
            'copy_from_organizzativa' => Action::make('copy_from_organizzativa')->action(
                function () {
                    $tableFilters = [];
                    if (is_array($this->tableFilters)) {
                        $tableFilters = $this->tableFilters;
                    }
                    $anno = Arr::get($tableFilters, 'anno.value');
                    if ($anno < 2023) {
                        dddx('non si puo');
                    }
                    $rows = Organizzativa::where('anno', $anno)->get();
                    foreach ($rows as $row) {
                        $data = $row->toArray();
                        $where = Arr::only($data, ['ente', 'matr', 'dal', 'al']);
                        $up = Individuale::where($where)->get();
                        if ($up->count() > 1) {
                            dddx('noo');
                        }
                        if ($up->count() == 0) {
                            /** @var array<string, mixed> $data */
                            $up = Individuale::create($data);
                        }
                        if ($up->count() == 1) {
                            /** @var array<string, mixed> $data */
                            $up->first()?->update($data);
                        }
                    }
                    Notification::make()
                        ->title('Saved successfully')
                        ->success()
                        ->send();
                }
            )->visible(fn ($livewire): bool => true),
        ];
    }

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
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

    /**
     * @return array<string, Filter>
     */
    public function getTableFilters(): array
    {
        return [
            'anno_valutatore' => AnnoValutatoreFilter::make('anno_valutatore'),
            /*
            'anno' => app(\Modules\Xot\Actions\Filament\Filter\GetYearFilter::class)
                ->execute('anno', intval(date('Y')) - 3, intval(date('Y')))
                ->default(intval(date('Y'))-1),
            */
        ];
    }

    /*
    protected function getTableQuery(): Builder
    {
        $query = parent::getTableQuery();

        $tableFilters = $this->tableFilters ?? [];
        $anno = Arr::get($tableFilters, 'anno.value');

        if (empty($anno)) {
            return $query->whereRaw('1 = 0'); // Non mostra nessun record se non è selezionato l'anno
        }

        return $query->where('anno', $anno);
    }
    */
    /**
     * @return array<string, BulkAction>
     */
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
