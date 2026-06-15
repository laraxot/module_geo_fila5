<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\RatingResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class RatingsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'extra_attributes_type' => TextColumn::make('extra_attributes.type'),
            'extra_attributes_anno' => TextColumn::make('extra_attributes.anno'),
            'id' => TextColumn::make('id')
                ->sortable()
                ->searchable(),
            'title' => TextColumn::make('title')
                ->sortable()
                ->searchable(),
            'rule' => TextColumn::make('rule')
                ->sortable()
                ->searchable(),
            'is_disabled' => IconColumn::make('is_disabled')
                ->boolean(),
            'is_readonly' => IconColumn::make('is_readonly')
                ->boolean(),
        ];
    }
}
