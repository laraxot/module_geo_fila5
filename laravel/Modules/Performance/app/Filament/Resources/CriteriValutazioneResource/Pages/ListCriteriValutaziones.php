<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\CriteriValutazioneResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Actions;
use Filament\Tables\Columns;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters;
use Filament\Tables\Filters\SelectFilter;
use Modules\Performance\Filament\Resources\CriteriValutazioneResource;
use Modules\Ptv\Enums\WorkerType;
use Modules\Ptv\Filament\Actions\Header\CopyFromLastYearAction;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

use function Safe\date;

class ListCriteriValutaziones extends XotBaseListRecords
{
    protected static string $resource = CriteriValutazioneResource::class;

    /**
     * @return array<string, Columns\TextColumn>
     */
    #[Override]
    public function getTableColumns(): array
    {
        return [
            'id_padre' => TextColumn::make('id_padre')
                ->numeric()
                ->sortable(),
            'nome' => TextColumn::make('nome')
                ->searchable()
                ->sortable(),
            'label' => TextColumn::make('label')
                ->searchable()
                ->sortable(),
            'descr' => TextColumn::make('descr')
                ->searchable(),
            'post_type' => TextColumn::make('post_type')
                ->searchable()
                ->sortable(),
            'posizione' => TextColumn::make('posizione')
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
            'post_type' => SelectFilter::make('post_type')
                ->options(WorkerType::class),
        ];
    }

    /**
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
