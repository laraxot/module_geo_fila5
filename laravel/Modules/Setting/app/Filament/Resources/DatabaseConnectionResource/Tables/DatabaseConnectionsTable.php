<?php

declare(strict_types=1);

namespace Modules\Setting\Filament\Resources\DatabaseConnectionResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class DatabaseConnectionsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')
                ->searchable(),
            'driver' => TextColumn::make('driver')
                ->searchable(),
            'host' => TextColumn::make('host')
                ->searchable(),
            'port' => TextColumn::make('port')
                ->numeric()
                ->sortable(),
            'database' => TextColumn::make('database')
                ->searchable(),
            'username' => TextColumn::make('username')
                ->searchable(),
            'charset' => TextColumn::make('charset')
                ->searchable(),
            'collation' => TextColumn::make('collation')
                ->searchable(),
            'prefix' => TextColumn::make('prefix')
                ->searchable(),
            'strict' => IconColumn::make('strict')
                ->boolean(),
            'engine' => TextColumn::make('engine')
                ->searchable(),
            'status' => TextColumn::make('status')
                ->searchable(),
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
