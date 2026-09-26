<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Widgets;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
<<<<<<< .merge_file_6s6bX8
use Illuminate\Database\Eloquent\Builder;
=======
>>>>>>> .merge_file_hyO2yK
use Modules\Geo\Models\Location;
use Modules\Xot\Filament\Widgets\XotBaseTableWidget as BaseWidget;

class LocationMapTableWidget extends BaseWidget
{
    protected static ?string $heading = 'Location Map';

    protected static ?int $sort = 1;

    protected static ?string $pollingInterval = null;

    public function table(Table $table): Table
    {
        return $table
<<<<<<< .merge_file_6s6bX8
            ->query(fn (): Builder => Location::query()->latest())
=======
            ->query(Location::query()->latest())
>>>>>>> .merge_file_hyO2yK
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('city')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('state')
                    ->searchable()
                    ->sortable(),
            ]);
    }
}
