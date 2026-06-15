<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\CriteriEsclusioneResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Modules\Ptv\Filament\Actions\Bulk\CheckCriterioEsclusioneBulkAction;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class CriteriEsclusionesTable extends XotBaseResourceTable
{
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'is_enabled' => ToggleColumn::make('is_enabled'),
            'name' => TextColumn::make('name')
                ->searchable()
                ->sortable(),
            'field_name' => TextColumn::make('field_name')
                ->searchable()
                ->sortable(),
            'op' => TextColumn::make('op')
                ->searchable()
                ->sortable(),
            'value' => TextColumn::make('value')
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

    public function getTableBulkActions(): array
    {
        // @phpstan-ignore-next-line return.type
        return [
            ...parent::getTableBulkActions(),
            CheckCriterioEsclusioneBulkAction::make(),
            // DeleteBulkAction::make(),
        ];
    }
}
