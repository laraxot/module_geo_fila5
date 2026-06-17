<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\LogResource\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class LogsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        /*
         * @return array<int|string, \Filament\Tables\Columns\Column>
         */
        return [
            'id' => TextColumn::make('id')->sortable(),
            'name' => TextColumn::make('name')->searchable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
        ];
    }

    public function getTableFilters(): array
    {
        return [
            'level_name' => SelectFilter::make('level_name')->options([
                'emergency' => 'Emergency',
                'alert' => 'Alert',
                'critical' => 'Critical',
                'error' => 'Error',
                'warning' => 'Warning',
                'notice' => 'Notice',
                'info' => 'Info',
                'debug' => 'Debug',
            ]),
        ];
    }

    public function getTableActions(): array
    {
        return [
            'view' => ViewAction::make(),
            'delete' => DeleteAction::make(),
        ];
    }

    public function getTableBulkActions(): array
    {
        return [
            'delete' => DeleteBulkAction::make(),
        ];
    }
}
