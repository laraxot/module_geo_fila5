<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\OrganizzativaResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Modules\Performance\Filament\Actions\Header\CopyValutatoreIdFromIndividualeAction;
use Modules\Performance\Filament\Resources\OrganizzativaResource;
use Modules\Performance\Models\StabiDirigente;
use Modules\Ptv\Enums\WorkerType;
use Modules\Ptv\Filament\Actions\Header\CopyFromLastYearAction;
use Modules\Ptv\Filament\Actions\Header\PopulateYearAction;
use Modules\Ptv\Filament\Actions\Header\TrovaEsclusiAction;
use Modules\Ptv\Filament\Columns\LavoratoreColumn;
use Modules\Ptv\Filament\Columns\PeriodoColumn;
use Modules\Ptv\Filament\Columns\QualificaColumn;
use Modules\Ptv\Filament\Columns\RepartoColumn;
use Modules\UI\Filament\Tables\Columns\GroupColumn;
use Modules\Xot\Actions\Filament\Filter\GetYearFilter;
use Modules\Xot\Filament\Actions\Header\ExportXlsAction;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

use function Safe\date;

/**
 * ---.
 */
class ListOrganizzativas extends XotBaseListRecords
{
    protected static string $resource = OrganizzativaResource::class;

    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'type' => TextColumn::make('type')
                ->searchable(),
            'valutatore_id' => SelectColumn::make('valutatore_id')
                ->options(function ($record) {
                    // Type narrowing: ensure record is Model and has anno property
                    if (! is_object($record) || ! isset($record->anno)) {
                        return [];
                    }
                    $anno = is_int($record->anno) ? $record->anno : (int) $record->anno;

                    return StabiDirigente::where('anno', $anno)->whereRaw('id=valutatore_id')->pluck('nome_diri', 'id');
                })
                ->visible(auth()->user()?->isSuperAdmin() ?? false),

            'ha_diritto' => ToggleColumn::make('ha_diritto')
                ->searchable(),
            'motivo' => TextColumn::make('motivo')
                ->searchable(),
            'soldi_group' => GroupColumn::make('soldi')->schema([
                TextColumn::make('importo_totale'),
                TextColumn::make('resti'),
                TextColumn::make('resti_pond'),
                TextColumn::make('budget_assegnato'),
                TextColumn::make('quota_effettiva'),
            ]),

            'lavoratore' => LavoratoreColumn::make('lavoratore'),
            'info_group' => GroupColumn::make('info')->schema([
                TextColumn::make('perc_parttimepond_dalal'),
                TextColumn::make('gg_presenza_dalal'),
                TextColumn::make('gg_assenza_dalal'),
                TextColumn::make('hh_assenza_dalal'),
                TextColumn::make('quota_teorica'),
                TextColumn::make('budget_assegnato'),
                TextColumn::make('quota_effettiva'),
            ]),

            'qualifica' => QualificaColumn::make('qualifica'),
            'reparto' => RepartoColumn::make('reparto'),
            'periodo' => PeriodoColumn::make('periodo'),
        ];
    }

    public function getTableFilters(): array
    {
        return [
            'anno' => app(GetYearFilter::class)->execute('anno', intval(date('Y')) - 3, intval(date('Y'))),
            'ha_diritto' => TernaryFilter::make('ha_diritto'),
            'type' => SelectFilter::make('type')
                ->options(WorkerType::class),
        ];
    }

    /**
     * @return array<string, Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            'create' => CreateAction::make(),
            'copy_from_last_year' => CopyFromLastYearAction::make(),
            'populate_year' => PopulateYearAction::make(),
            'trova_esclusi' => TrovaEsclusiAction::make(),
            'export_xls' => ExportXlsAction::make(),
            // Azione custom per copia valutatore_id da Individuale a Organizzativa (nome unico obbligatorio)
            'copy_valutatore_id_from_individuale' => CopyValutatoreIdFromIndividualeAction::make('copy_valutatore_id_from_individuale'),
        ];
    }
}
