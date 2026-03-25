<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\MessageResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\Ptv\Filament\Resources\MessageResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\Xot\Filament\Traits\HasXotTable;
use Override;

class ListMessages extends XotBaseListRecords
{
    use HasXotTable;

    public static string $resource = MessageResource::class;

    

    #[Override]
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'id' => TextColumn::make('id'),
            'parent_id' => TextColumn::make('parent_id'),
            'type' => TextColumn::make('type'),
            'title' => TextColumn::make('title'),
            // TextColumn::make('txt'),
            'anno' => TextColumn::make('anno'),
        ];
    }

    #[Override]
    public function getTableFilters(): array
    {
        return [
            SelectFilter::make('anno')
                ->options([
                    '2023' => '2023',
                    '2024' => '2024',
                    '2025' => '2025',
                    '2026' => '2026',
                ]),
        ];
    }
}
