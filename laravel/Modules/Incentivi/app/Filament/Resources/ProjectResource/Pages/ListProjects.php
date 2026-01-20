<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ProjectResource\Pages;

use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Activity\Filament\Actions\ListLogActivitiesAction;
use Modules\Incentivi\Filament\Resources\ProjectResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListProjects extends XotBaseListRecords
{
    protected static string $resource = ProjectResource::class;

    #[Override]
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            TextColumn::make('nome')
                ->searchable()
                ->limit(50)
                ->wrap(),
            TextColumn::make('tipo')
                ->searchable(),
            TextColumn::make('stabiDirigente.nome_stabi')
                ->sortable(),
            TextColumn::make('stato')
                ->badge()
                ->sortable(),
            TextColumn::make('data_aggiudicazione')
                ->dateTime('D, d M Y')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('data_inizio_esecuzione')
                ->dateTime('D, d M Y')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('data_fine_esecuzione')
                ->dateTime('D, d M Y')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            // Tables\Columns\TextColumn::make('oggetto')
            //     ->searchable()
            //     ->limit(30),
            TextColumn::make('determina di aggiudicazione')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('percentuale_fondo')
                ->searchable()
                ->suffix(' %'),
            TextColumn::make('importo_totale')
                ->money('EUR')
                ->searchable(),
            TextColumn::make('importo_effettivo_fondo')
                ->money('EUR')
                ->searchable(),
            TextColumn::make('componente_incentivante')
                ->money('EUR')
                ->searchable(),
            TextColumn::make('componente_innovazione')
                ->money('EUR')
                ->searchable(),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    #[Override]
    public function getTableActions(): array
    {
        return [
            'edit' => EditAction::make(),
            // 'log' => ListLogActivitiesAction::make(),
        ];
    }
}
