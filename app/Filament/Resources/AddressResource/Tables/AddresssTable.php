<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\AddressResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\Geo\Models\Address;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class AddresssTable extends XotBaseResourceTable
{
    /**
     * @var class-string<Address>
     */
    protected static string $model = Address::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'route' => TextColumn::make('route')->searchable()->wrap()->sortable(),
            'street_number' => TextColumn::make('street_number')->searchable()->sortable(),
            'locality' => TextColumn::make('locality')->searchable()->sortable(),
            'administrative_area_level_3' => TextColumn::make('administrative_area_level_3')->searchable()->sortable(),
            'administrative_area_level_2' => TextColumn::make('administrative_area_level_2')->searchable()->sortable()->toggleable(isToggledHiddenByDefault: true),
            'postal_code' => TextColumn::make('postal_code')->searchable()->sortable(),
            'type' => TextColumn::make('type')->badge(),
            'is_primary' => IconColumn::make('is_primary')->boolean()->sortable(),
        ];
    }
}
