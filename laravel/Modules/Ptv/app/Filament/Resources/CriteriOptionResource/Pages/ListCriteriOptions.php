<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\CriteriOptionResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\Ptv\Filament\Actions\Header\CopyFromLastYearAction;
use Modules\Ptv\Filament\Resources\CriteriOptionResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

use function Safe\date;

class ListCriteriOptions extends XotBaseListRecords
{
    public static string $resource = CriteriOptionResource::class;

    #[Override]
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'name' => TextColumn::make('name')
                ->searchable()
                ->sortable(),
            'value' => TextColumn::make('value')
                ->searchable()
                ->sortable(),
            'anno' => TextColumn::make('anno')
                ->numeric()
                ->sortable(),
            'field_name' => TextColumn::make('field_name')
                ->searchable()
                ->sortable(),
            'op' => TextColumn::make('op')
                ->searchable()
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

    #[Override]
    public function getTableFilters(): array
    {
        return [
            'anno' => SelectFilter::make('anno')
                ->options(function () {
                    $currentYear = (int) date('Y');

                    return [
                        $currentYear => $currentYear,
                        $currentYear - 1 => $currentYear - 1,
                        $currentYear - 2 => $currentYear - 2,
                    ];
                }),
        ];
    }

    #[Override]
    public function getTableActions(): array
    {
        return [
            'edit' => EditAction::make(),
        ];
    }

    #[Override]
    public function getTableBulkActions(): array
    {
        return [
            'delete' => DeleteBulkAction::make(),
        ];
    }

    #[Override]
    protected function getHeaderActions(): array
    {
        // @phpstan-ignore-next-line return.type
        return [
            CreateAction::make(),
            CopyFromLastYearAction::make(),
        ];
    }
}
