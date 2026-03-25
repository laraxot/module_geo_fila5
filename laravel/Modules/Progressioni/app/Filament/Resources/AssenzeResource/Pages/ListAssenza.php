<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\AssenzeResource\Pages;

use Filament\Tables\Columns\TextColumn;
use Modules\Progressioni\Filament\Resources\AssenzeResource;
use Modules\Ptv\Filament\Resources\Pages\PtvBaseYearListRecords;
use Override;

class ListAssenza extends PtvBaseYearListRecords
{
    public static string $resource = AssenzeResource::class;

    #[Override]
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable(),
            'tipo' => TextColumn::make('tipo')
                ->numeric()
                ->sortable(),
            'codice' => TextColumn::make('codice')
                ->numeric()
                ->sortable(),
            'descr' => TextColumn::make('descr')
                ->searchable()
                ->sortable(),
            'anno' => TextColumn::make('anno')
                ->numeric()
                ->sortable(),
            'umi' => TextColumn::make('umi')
                ->sortable(),
            'dur' => TextColumn::make('dur')
                ->sortable(),
        ];
    }
}
