<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\LocationResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\Geo\Models\Location;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class LocationsTable extends XotBaseResourceTable
{
    /**
     * @var class-string<Location>
     */
    protected static string $model = Location::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'street' => TextColumn::make('street')->searchable()->wrap()->sortable(),
            'city' => TextColumn::make('city')->searchable()->sortable(),
            'zip' => TextColumn::make('zip')->searchable()->sortable(),
            'processed' => IconColumn::make('processed')->boolean()->sortable(),
            'lat' => TextColumn::make('lat')->numeric(decimalPlaces: 6)->toggleable(isToggledHiddenByDefault: true),
            'lng' => TextColumn::make('lng')->numeric(decimalPlaces: 6)->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
