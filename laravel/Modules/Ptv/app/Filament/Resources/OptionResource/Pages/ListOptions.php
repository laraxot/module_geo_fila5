<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\OptionResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Tables;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\Performance\Models\Option;
use Modules\Ptv\Enums\WorkerType;
use Modules\Ptv\Filament\Actions\Header\CopyFromLastYearAction;
use Modules\Ptv\Filament\Resources\OptionResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListOptions extends XotBaseListRecords
{
    protected static string $resource = OptionResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        // @phpstan-ignore-next-line return.type
        return [
            CreateAction::make(),
            CopyFromLastYearAction::make(),
        ];
    }

    #[Override]
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            TextColumn::make('id')
                ->numeric()
                ->sortable(),
            /*
                Tables\Columns\TextInputColumn::make('parent_id')
                    ->type('number')
                    ->sortable(),
                */
            SelectColumn::make('parent_id')->options(function ($record) {
                // Type narrowing: ensure record is object with properties
                if (! is_object($record)) {
                    return [];
                }

                $year = isset($record->year) ? $record->year : null;
                $optionType = isset($record->option_type) ? $record->option_type : null;
                $name = isset($record->name) ? $record->name : null;

                if ($year === null || $optionType === null || $name === null) {
                    return [];
                }

                $query = Option::where('year', $year)
                    ->where('option_type', $optionType)
                    ->where('name', $name);

                // Type narrowing: ensure record has getKey() method
                if (method_exists($record, 'getKey')) {
                    $recordKey = $record->getKey();
                    if ($recordKey !== null) {
                        $query = $query->where('id', '!=', $recordKey);
                    }
                }

                $opts = $query->where('value', '!=', '')
                    ->get()
                    ->mapWithKeys(function ($item) {
                        $k = $item->id;
                        $v = $item->id.' ]'.$item->value;

                        return [$k => $v];
                    })
                    ->concat([null => 'Root'])
                    ->toArray();

                return $opts;
            }),
            TextColumn::make('option_type')
                ->searchable(),
            TextColumn::make('name')
                ->searchable(),
            TextColumn::make('value')
                ->searchable()
                ->wrap(),
            TextColumn::make('txt')
                ->searchable()
                ->wrap()
                ->html(),
            TextColumn::make('txt1')
                ->searchable()
                ->wrap()
                ->html(),
            /*
                Tables\Columns\TextColumn::make('option_id')
                    ->numeric()
                    ->sortable(),
                */
            /*
                Tables\Columns\TextColumn::make('pos')
                    ->numeric()
                    ->sortable(),
                */
            TextColumn::make('year')
                ->numeric()
                ->sortable(),
        ];
    }

    #[Override]
    public function getTableFilters(): array
    {
        return [
            SelectFilter::make('year')
                ->options(function () {
                    $currentYear = (int) date('Y');

                    return [
                        $currentYear => $currentYear,
                        $currentYear - 1 => $currentYear - 1,
                        $currentYear - 2 => $currentYear - 2,
                    ];
                }),
            SelectFilter::make('option_type')
                ->options(WorkerType::class),
        ];
    }
}
