<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class UsersTable extends XotBaseResourceTable
{
    /**
     * @return array<string, \Filament\Tables\Columns\Column>
     */
    public static function getTableColumns(): array
    {
        /*
         * @return array<int\|string, \Filament\Tables\Columns\Column>
         */
        return [
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'email' => TextColumn::make('email')->searchable()->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
        ];
    }
}
