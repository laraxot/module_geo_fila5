<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\ProgressioniResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Modules\Activity\Filament\Actions\ListLogActivitiesAction;
use Modules\Progressioni\Actions\ShowMailSendedAt;
use Modules\Progressioni\Filament\Actions\Bulk\SendMailBulkAction;
use Modules\Progressioni\Filament\Actions\Header\ImportCedDiffAction;
use Modules\Progressioni\Filament\Actions\Header\RicalcolaAction;
use Modules\Progressioni\Filament\Resources\ProgressioniResource;
use Modules\Progressioni\Models\Progressioni;
use Modules\Ptv\Actions\Filament\Actions\PopulateYearButton;
use Modules\Ptv\Actions\Filament\Actions\TrovaEsclusiButton;
use Modules\Ptv\Actions\GetValutatoriOptions;
// use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Ptv\Actions\PopulateByYearAction;
use Modules\Ptv\Filament\Actions\Bulk\ZipSchedeBulkAction;
use Modules\Ptv\Filament\Actions\Header\MergeDoubleRowCatecoYearAction;
use Modules\Ptv\Filament\Actions\Header\PopulateYearAction;
use Modules\Ptv\Filament\Actions\Header\ZipSchedeAction;
use Modules\Ptv\Filament\Columns\QuaColumn;
use Modules\Ptv\Filament\Columns\RepartoColumn;
use Modules\Ptv\Filament\Columns\WorkerColumn;
use Modules\UI\Filament\Tables\Columns\GroupColumn;
use Modules\Xot\Actions\Filament\Actions\CopyFromLastYearButton;
use Modules\Xot\Filament\Actions\Header\ExportXlsAction;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListProgressionis extends XotBaseListRecords
{
    protected static string $resource = ProgressioniResource::class;

    /**
     * @return array<string, Action>
     */
    #[\Override]
    protected function getHeaderActions(): array
    {
        // app(PopulateByYearAction::class)->execute(Progressioni::class,'anno','2023');

        $tableFilters = $this->tableFilters ?? [];
        $anno = Arr::get((array) $tableFilters, 'anno.value', null);
        if ($anno === null) {
            $anno = Arr::get((array) $tableFilters, 'anno/valutatore.anno');
        }
        if ($anno != null) {
            $rows = Progressioni::where('anno', $anno)
                ->where('ha_diritto', null)
                ->where('motivo', null)
                ->update(['ha_diritto' => 1]);
            // ->get();
            /*
            $rows=Progressioni::where('anno',$anno)
            ->where('gg_cateco_posfun',0)
            ->update(['gg_cateco_posfun'=>null]);
            */
        }

        return [
            /*
            // Actions\CreateAction::make(),
            app(CopyFromLastYearButton::class)
                ->execute(Progressioni::class, 'anno', $anno),
            app(PopulateYearButton::class)
                ->execute(Progressioni::class, 'anno', $anno),
            app(TrovaEsclusiButton::class)
                ->execute(Progressioni::class, 'anno', $anno),
            */
            'populate' => PopulateYearAction::make(),
            'merge' => MergeDoubleRowCatecoYearAction::make(),
            'export' => ExportXlsAction::make(),
            'ricalcola' => RicalcolaAction::make(),
            // ImportCedDiffAction::make(),
            // ZipSchedeAction::make(),
        ];
    }

    /**
     * @return array<string, TextColumn|IconColumn|WorkerColumn|QuaColumn|RepartoColumn|GroupColumn>
     */
    #[\Override]
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id'),
            'cognome' => TextColumn::make('cognome')->toggleable(isToggledHiddenByDefault: true)->searchable(),
            'matr' => TextColumn::make('matr')->toggleable(isToggledHiddenByDefault: true)->searchable(),

            'ha_diritto' => IconColumn::make('ha_diritto')
                ->default(false)
                ->boolean(),

            'motivo' => TextColumn::make('motivo')
                // ->searchable() //diventa troppo lento
                ->wrap(),
            /* --------------------------- TROPPE QUERY ---------------------------- */
            /*
            Tables\Columns\TextColumn::make('mail_sended_at')
                ->html()
                ->default(fn ($record) => app(ShowMailSendedAt::class)->execute($record)),
            // */
            // ->formatStateUsing(fn (string $state) => dddx($state)),

            /*
                'diritto' => GroupColumn::make('diritto')->schema([
                    //Tables\Columns\TextColumn::make('ha_diritto'),
                    'ha_diritto' => IconColumn::make('ha_diritto')
                        ->default(false)
                        ->boolean(),
                    Tables\Columns\TextColumn::make('motivo')
                        ->wrap()
                        //->formatStateUsing(fn (string $state) => dddx($state))
                        //->listWithLineBreaks()
                        //->badge()
                        //->separator(','),
                ]),
                */
            'lavoratore' => WorkerColumn::make('lavoratore'),
            'criteri' => GroupColumn::make('criteri')->schema([
                'gg' => TextColumn::make('gg'),
                'gg_no_asz' => TextColumn::make('gg_no_asz'),
                'gg_asz' => TextColumn::make('gg_asz'),
                'gg_cateco_no_posfun_no_asz' => TextColumn::make('gg_cateco_no_posfun_no_asz'),
                'eta' => TextColumn::make('eta'),
            ]),
            'qualifica' => QuaColumn::make('qualifica'),
            'reparto' => RepartoColumn::make('reparto'),
            'periodo' => GroupColumn::make('periodo')->schema([
                'dal' => TextColumn::make('dal'),
                'al' => TextColumn::make('al'),
                'anno' => TextColumn::make('anno'),
            ]),
        ];
    }

    #[\Override]
    public function getTableFilters(): array
    {
        return [
            SelectFilter::make('anno/valutatore')
                ->label('anno/valutatore')
                ->schema([
                    Select::make('anno')
                        ->options([
                            // '2022' => '2022',
                            '2023' => '2023',
                            '2024' => '2024',
                            '2025' => '2025',
                        ])
                        ->reactive(),
                    Select::make('valutatore_id')
                        ->label('valutatore')
                        ->options(function (\Filament\Schemas\Components\Utilities\Get $get, \Filament\Schemas\Components\Utilities\Set $set): array {
                            /** @var int|string|null $anno */
                            $anno = $get('anno');

                            return app(GetValutatoriOptions::class)->execute('Progressioni', $anno);
                        }),
                    // TernaryFilter::make('ha_diritto'),
                    // *
                    Select::make('ha_diritto')->options([
                        null => '-',
                        true => 'Sì',
                        false => 'No',
                    ]),
                    // */
                    // Forms\Components\View::make('indennitacondizionilavoro::filament.tables.columns.button'),
                ])
                ->query(static function (Builder $query, array $data) {
                    if ($data['anno'] == null /* || null == $data['valutatore_id'] */) {
                        return $query->where('id', 0);
                    }

                    // unset($data['quadrimestre']);
                    if ($data['valutatore_id'] == null) {
                        unset($data['valutatore_id']);
                    }

                    if ($data['ha_diritto'] == null) {
                        unset($data['ha_diritto']);
                    }

                    $query = $query->where($data);

                    return $query;
                })->columns(4),
            // TernaryFilter::make('ha_diritto'),
        ];
    }

    /**
     * @return array<string, Action|ActionGroup>
     */
    #[\Override]
    public function getTableActions(): array
    {
        // Types are inferred by Filament v4
        return [
            'edit' => EditAction::make()->label('')->tooltip('Modifica'),
            'view' => ViewAction::make()->label('')->tooltip('Vedi'),
            'activity-log' => ListLogActivitiesAction::make(),
        ];
    }

    /**
     * @return array<string, BulkAction>
     */
    #[\Override]
    public function getTableBulkActions(): array
    {
        // Types are inferred by Filament v4
        return [
            // Tables\Actions\BulkActionGroup::make([
            // Tables\Actions\DeleteBulkAction::make(),
            'send-mail' => SendMailBulkAction::make('send-mail'),
            'zip-schede' => ZipSchedeBulkAction::make('zip-schede'),
            // ]),
        ];
    }
}
