<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\CacheResource\Tables;

use Filament\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Actions\Header\ArtisanHeaderAction;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class CachesTable extends XotBaseResourceTable
{
    public function getTableColumns(): array
    {
        /*
         * @return array<int|string, \Filament\Tables\Columns\Column>
         */
        return [
            'id' => TextColumn::make('id')->searchable()->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime(),
            'updated_at' => TextColumn::make('updated_at')->dateTime(),
        ];
    }

    public function getTableHeaderActions(): array
    {
        return [
            'create' => CreateAction::make(),
            'route_list' => ArtisanHeaderAction::make('route:list'),
            'icons_cache' => ArtisanHeaderAction::make('icons:cache'),
            'filament_cache_components' => ArtisanHeaderAction::make('filament:cache-components'),
            'filament_clear_cached_components' => ArtisanHeaderAction::make('filament:clear-cached-components'),
        ];
    }
}
