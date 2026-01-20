<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\SettlementResource\Pages;

use Filament\Tables;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Incentivi\Filament\Resources\SettlementResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListSettlements extends XotBaseListRecords
{
    protected static string $resource = SettlementResource::class;

    #[Override]
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            TextColumn::make('denominazione')
                // ->label('Denominazione')
                ->searchable(),
            TextColumn::make('project.nome')
                // ->label('Progetto')
                ->sortable(),
            // Tables\Columns\TextColumn::make('tipologia')
            //     ->label('Tipo di liquidazione')
            //     ->searchable(),
            TextColumn::make('created_at')
                // ->label('Creata')
                ->dateTime()
                ->sortable(),
            TextColumn::make('updated_at')
            // ->label('Aggiornata')
                ->dateTime()
                ->sortable(),
        ];
    }
}
