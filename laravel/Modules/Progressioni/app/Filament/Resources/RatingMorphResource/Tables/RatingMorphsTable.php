<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\RatingMorphResource\Tables;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class RatingMorphsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array<string, Column>
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

    /**
     * @return array<string, mixed>
     */
    public function getTableFilters(): array<string, Filter>
    {
        return [
            'type' => SelectFilter::make('ratingable_type')
                ->options([
                    'post' => 'Post',
                    'user' => 'User',
                    'comment' => 'Comment',
                ]),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableActions(): array<string, Action>
    {
        return [
            'edit' => EditAction::make(),
            'delete' => DeleteAction::make(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableBulkActions(): array<string, mixed>
    {
        return [
            'delete' => DeleteBulkAction::make(),
        ];
    }

    public function getTableHeaderActions(): array<string, mixed>
    {
        return [
            'create' => CreateAction::make(),
        ];
    }
}
