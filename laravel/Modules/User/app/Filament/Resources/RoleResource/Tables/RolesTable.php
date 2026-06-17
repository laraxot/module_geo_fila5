<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\RoleResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class RolesTable extends XotBaseResourceTable
{
    public function getTableFilters(): array
    {
        return [
            'guard_name' => SelectFilter::make('guard_name')
                ->options([
                    'web' => 'Web',
                    'api' => 'API',
                    'sanctum' => 'Sanctum',
                ])
                ->multiple(),
        ];
    }

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'name' => TextColumn::make('name')->searchable(),
            'guard_name' => TextColumn::make('guard_name'),
            'display_name' => TextColumn::make('display_name'),
            'description' => TextColumn::make('description'),
            'team_id' => TextColumn::make('team_id'),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(),
        ];
    }
}
