<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\RatingMorphResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class RatingMorphsTable extends XotBaseResourceTable
{
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable()
                ->searchable(),
            'rating' => TextColumn::make('rating')
                ->sortable()
                ->searchable(),
            'ratingable_type' => TextColumn::make('ratingable_type')
                ->label('Type')
                ->sortable(),
            'ratingable_id' => TextColumn::make('ratingable_id')
                ->label('ID')
                ->sortable(),
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
            'updated_at' => TextColumn::make('updated_at')
                ->dateTime()
                ->sortable(),
        ];
    }
}
