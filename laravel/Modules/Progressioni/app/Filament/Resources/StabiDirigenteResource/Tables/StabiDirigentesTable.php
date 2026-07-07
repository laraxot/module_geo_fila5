<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\StabiDirigenteResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class StabiDirigentesTable extends XotBaseResourceTable
{
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array<string, Column>
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable(),
            'stabi' => TextColumn::make('stabi')
                ->searchable()
                ->sortable(),
            'dirigente' => TextColumn::make('dirigente')
                ->searchable()
                ->sortable(),
            'anno' => TextColumn::make('anno')
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
