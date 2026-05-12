<?php

declare(strict_types=1);

namespace Modules\Job\app\Filament\Resources\JobsWaitingResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class JobsWaitingsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
    {
    /**
     * @return array<int\|string, \Filament\Tables\Columns\Column>
     */
        return [
            'id' => TextColumn::make('id')->sortable(),
            'name' => TextColumn::make('name')->searchable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
        ];
    }
}