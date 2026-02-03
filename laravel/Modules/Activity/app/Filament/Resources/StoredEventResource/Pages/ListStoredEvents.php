<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\StoredEventResource\Pages;

use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Modules\Activity\Filament\Resources\StoredEventResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListStoredEvents extends XotBaseListRecords
{
    protected static string $resource = StoredEventResource::class;

    /**
     * @return array<Tables\Columns\Column>
     */
    public function getTableColumns(): array
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ...array_map(
                    fn($col) => is_object($col) ? $col : TextColumn::make($col),
                    $this->getTableColumns()
                )
            ]);
    }
    {
        return [
            TextColumn::make('id'),
            TextColumn::make('event_class'),
            ViewColumn::make('event_properties')->view('activity::filament.tables.columns.event-properties'),
        ];
    }
}
