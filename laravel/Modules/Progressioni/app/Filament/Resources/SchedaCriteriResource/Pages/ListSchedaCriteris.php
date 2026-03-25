<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\SchedaCriteriResource\Pages;

use Filament\Tables\Columns\TextColumn;
use Modules\Progressioni\Filament\Resources\SchedaCriteriResource;
use Modules\Ptv\Filament\Resources\Pages\PtvBaseYearListRecords;
use Override;

class ListSchedaCriteris extends PtvBaseYearListRecords
{
    public static string $resource = SchedaCriteriResource::class;

    #[Override]
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable(),
            'name' => TextColumn::make('name')
                ->searchable()
                ->sortable(),
            'descr' => TextColumn::make('descr')
                ->searchable()
                ->sortable(),
            'anno' => TextColumn::make('anno')
                ->numeric()
                ->sortable(),
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
