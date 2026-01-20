<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\MyLogResource\Pages;

use Filament\Actions;
use Filament\Actions\ViewAction;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Modules\Ptv\Filament\Resources\MyLogResource;
use Modules\Ptv\Models\MyLog;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListMyLogs extends XotBaseListRecords
{
    protected static string $resource = MyLogResource::class;

    /**
     * Get the table columns definition.
     *
     * @return array<int, Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            TextColumn::make('id')
                ->sortable(),

            TextColumn::make('tbl')
                ->searchable()
                ->sortable(),

            TextColumn::make('id_tbl')
                ->numeric()
                ->sortable(),

            TextColumn::make('note')
                ->searchable()
                ->limit(50),

            TextColumn::make('obj')
                ->searchable()
                ->limit(30),

            TextColumn::make('act')
                ->searchable()
                ->sortable(),

            TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),

            TextColumn::make('created_by')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * Get the table filters definition.
     *
     * @return array<int, Tables\Filters\BaseFilter>
     */
    public function getTableFilters(): array
    {
        return [
            SelectFilter::make('tbl')
                ->options(function (): array {
                    /** @var array<string, string> $tables */
                    $tables = MyLog::distinct('tbl')
                        ->whereNotNull('tbl')
                        ->orderBy('tbl')
                        ->pluck('tbl', 'tbl')
                        ->toArray();

                    return $tables;
                }),

            SelectFilter::make('note')
                ->options([
                    'sendMailLettF' => 'Invio Mail Lettera F',
                    'sendMailLettI' => 'Invio Mail Lettera I',
                ]),
        ];
    }

    /**
     * Get the table actions definition.
     *
     * @return array<string, Actions\Action>
     */
    public function getTableActions(): array
    {
        return [
            'view' => ViewAction::make(),
        ];
    }

    /**
     * Get the table bulk actions definition.
     *
     * @return array<string, Actions\BulkAction>
     */
    public function getTableBulkActions(): array
    {
        return [];
    }
}
