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

    protected static string $resource = MessageResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    #[Override]
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            TextColumn::make('id'),
            TextColumn::make('parent_id'),
            TextColumn::make('type'),
            TextColumn::make('title'),
            // TextColumn::make('txt'),
            TextColumn::make('anno'),
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
                ]),
        ];
    }
}
