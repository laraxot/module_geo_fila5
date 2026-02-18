<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Table;
use Illuminate\Support\Arr;
use Modules\Ptv\Actions\CriteriEsclusione\CheckCriterio;
use Modules\Ptv\Filament\Actions\Bulk\CheckCriterioEsclusioneBulkAction;
use Modules\Ptv\Filament\Actions\Header\CopyFromLastYearAction;
use Modules\Ptv\Models\Contracts\CriteriEsclusioneContract;
use Modules\Xot\Actions\Filament\Filter\GetYearFilter;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

use function Safe\date;

abstract class PtvBaseYearListRecords extends XotBaseListRecords
{
    #[Override]
    public function getHeaderActions(): array
    {
        /** @var array<string, mixed>|null $tableFilters */
        $tableFilters = $this->tableFilters;
        $anno = $tableFilters ? Arr::get($tableFilters, 'anno.value') : null;

        // @phpstan-ignore-next-line return.type
        return [
            ...parent::getHeaderActions(),
            CreateAction::make(),
            CopyFromLastYearAction::make('copy_from_last_year'),
        ];
    }

    #[Override]
    public function getTableFilters(): array
    {
        return [
            ...parent::getTableFilters(),
            'anno' => app(GetYearFilter::class)
                ->execute('anno', intval(date('Y')) - 3, intval(date('Y'))),
        ];
    }

    #[Override]
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'id' => TextColumn::make('id'),
            'name' => TextColumn::make('name'),
            'field_name' => TextColumn::make('field_name'),
            'op' => TextColumn::make('op'),
            'value' => TextColumn::make('value'),
            'type' => TextColumn::make('type'),
            'anno' => TextColumn::make('anno'),
        ];
    }

    #[Override]
    public function getTableActions(): array
    {
        // @phpstan-ignore-next-line return.type
        return [
            ...parent::getTableActions(),
            Action::make('check')
                ->action(function ($record): void {
                    // Type narrowing: ensure record implements CriteriEsclusioneContract
                    if (! is_object($record) || ! $record instanceof CriteriEsclusioneContract) {
                        return;
                    }

                    app(CheckCriterio::class)->execute($record);
                }),
        ];
    }

    #[Override]
    public function getTableBulkActions(): array
    {
        // @phpstan-ignore-next-line return.type
        return [
            ...parent::getTableBulkActions(),
            CheckCriterioEsclusioneBulkAction::make(),
            // DeleteBulkAction::make(),
        ];
    }

    public function tableOLD(Table $table): Table
    {
        return $table
            // ->columns($this->getTableColumns())
            // @phpstan-ignore-next-line arguments.count
            ->columns($this->layoutView->getTableColumns())
            ->contentGrid($this->layoutView->getTableContentGrid())
            ->headerActions($this->getTableHeaderActions())

            ->filters($this->getTableFilters())
            ->filtersLayout(FiltersLayout::AboveContent)
            ->persistFiltersInSession()
            ->recordActions($this->getTableActions())
            ->toolbarActions($this->getTableBulkActions())
            ->recordActionsPosition(RecordActionsPosition::BeforeColumns)
            ->defaultSort(
                column: 'created_at',
                direction: 'DESC',
            );
    }
}
