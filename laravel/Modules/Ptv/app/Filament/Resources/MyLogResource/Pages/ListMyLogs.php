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
    public static string $resource = MyLogResource::class;

    /**
     * Get the table columns definition.
     *
     * @return array<string, Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable(),

            'tbl' => TextColumn::make('tbl')
                ->searchable()
                ->sortable(),

            'id_tbl' => TextColumn::make('id_tbl')
                ->numeric()
                ->sortable(),

            'note' => TextColumn::make('note')
                ->searchable()
                ->limit(50),

            'obj' => TextColumn::make('obj')
                ->searchable()
                ->limit(30),

            'act' => TextColumn::make('act')
                ->searchable()
                ->sortable(),

            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),

            'created_by' => TextColumn::make('created_by')
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
