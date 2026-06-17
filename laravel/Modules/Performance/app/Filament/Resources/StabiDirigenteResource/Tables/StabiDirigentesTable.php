<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\StabiDirigenteResource\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Modules\Performance\Models\Individuale;
use Modules\Performance\Models\StabiDirigente;
use Modules\Ptv\Filament\Actions\Header\ImportValutatoriAction;
use Modules\UI\Filament\Tables\Columns\GroupColumn;
use Modules\Xot\Actions\Filament\Filter\GetYearFilter;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

use function Safe\date;

class StabiDirigentesTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Action|ActionGroup>
     */
    public function getTableHeaderActions(): array
    {
        $actions = parent::getTableHeaderActions();
        $actions['import_valutatori'] = ImportValutatoriAction::make('import_valutatori')
            ->addFields([
                'anno' => TextInput::make('anno'),
            ])->setStabiDirigenteModel(StabiDirigente::class)
            ->setSchedaModel(Individuale::class);

        return $actions;
    }

    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable(),

            'valutatore_id' => TextColumn::make('valutatore_id')
                ->numeric()
                ->sortable(),
            'rep' => GroupColumn::make('rep')->schema([
                'stabi' => TextColumn::make('stabi')
                    ->searchable()
                    ->sortable(),

                'repar' => TextColumn::make('repar')
                    ->searchable()
                    ->sortable(),

                'nome_stabi' => TextColumn::make('nome_stabi')
                    ->searchable()
                    ->sortable(),
            ]),
            'diri' => GroupColumn::make('diri')->schema([
                'matr' => TextColumn::make('matr')
                    ->searchable()
                    ->sortable(),

                'nome_diri' => TextColumn::make('nome_diri')
                    ->searchable()
                    ->sortable(),

                'email' => TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
            ])->searchable(['matr', 'nome_diri', 'email']),
            'anno' => TextColumn::make('anno')
                ->numeric()
                ->sortable(),
        ];
    }

    public function getTableFilters(): array
    {
        return [
            'anno' => app(GetYearFilter::class)
                ->execute('anno', intval(date('Y')) - 3, intval(date('Y'))),
        ];
    }
}
