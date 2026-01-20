<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeCatCoeffResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Actions;
use Filament\Tables\Columns;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters;
use Filament\Tables\Filters\SelectFilter;
use Modules\Performance\Filament\Resources\IndividualeCatCoeffResource;
use Modules\Ptv\Filament\Actions\Header\CopyFromLastYearAction;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

use function Safe\date;

class ListIndividualeCatCoeffs extends XotBaseListRecords
{
    protected static string $resource = IndividualeCatCoeffResource::class;

    /**
     * Get the list table columns.
     *
     * @return array<string, Column>
     */
    #[Override]
    public function getTableColumns(): array
    {
        return [
            'lista_propro' => TextColumn::make('lista_propro')
                ->searchable(),
            'coeff' => TextColumn::make('coeff')
                ->numeric()
                ->sortable(),
            'descr' => TextColumn::make('descr')
                ->searchable()
                ->wrap(),
            'tot_giorni' => TextColumn::make('tot_giorni')
                ->numeric()
                ->sortable(),
            'tot_giorni_pt' => TextColumn::make('tot_giorni_pt')
                ->numeric()
                ->sortable(),
            'tot_giorni_pt_coeff' => TextColumn::make('tot_giorni_pt_coeff')
                ->numeric()
                ->sortable(),
            'quota_teorica' => TextColumn::make('quota_teorica')
                ->numeric()
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

    /**
     * Get the table filters.
     *
     * @return array<string, Filters\SelectFilter>
     */
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
            'lista_propro' => SelectFilter::make('lista_propro')
                ->searchable()
                ->preload(),
        ];
    }

    /**
     * Get the table actions.
     *
     * @return array<string, Action>
     */
    #[Override]
    public function getTableActions(): array
    {
        return [
            'edit' => EditAction::make(),
            'delete' => DeleteAction::make(),
        ];
    }

    /**
     * Get the table bulk actions.
     *
     * @return array<string, DeleteBulkAction>
     */
    #[Override]
    public function getTableBulkActions(): array
    {
        return [
            'delete' => DeleteBulkAction::make(),
        ];
    }

    /**
     * Get the header actions for the list page.
     *
     * @return array<string, Action>
     */
    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            'create' => CreateAction::make(),
            'copy' => CopyFromLastYearAction::make(),
        ];
    }
}
