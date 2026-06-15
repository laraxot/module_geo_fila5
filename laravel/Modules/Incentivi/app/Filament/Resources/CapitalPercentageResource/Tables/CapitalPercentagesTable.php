<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\CapitalPercentageResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class CapitalPercentagesTable extends XotBaseResourceTable
{
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'nome' => TextColumn::make('nome')
                ->searchable(),
            'descrizione' => TextColumn::make('descrizione')
                ->searchable(),
            'tipologia' => TextColumn::make('tipologia')
                ->searchable(),
            'da' => TextColumn::make('da')
                ->money('EUR'),
            'a' => TextColumn::make('a')
                ->money('EUR'),
            'valore' => TextColumn::make('valore')
                ->numeric()
                ->sortable(),
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
