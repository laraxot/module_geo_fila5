<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\StabiDirigenteResource\Pages;

use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteBulkAction;
use Modules\Ptv\Models\StabiDirigente;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Filament\Resources\StabiDirigenteResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListStabiDirigentes extends XotBaseListRecords
{
    protected static string $resource = StabiDirigenteResource::class;

    /**
     * Get the table columns definition.
     *
     * @return array<string, Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable(),

            'valutatore_id' => TextColumn::make('valutatore_id')
                ->numeric()
                ->sortable(),

            'stabi' => TextColumn::make('stabi')
                ->searchable()
                ->sortable(),

            'repar' => TextColumn::make('repar')
                ->searchable()
                ->sortable(),

            'nome_stabi' => TextColumn::make('nome_stabi')
                ->searchable()
                ->sortable(),

            'matr' => TextColumn::make('matr')
                ->searchable()
                ->sortable(),

            'nome_diri' => TextColumn::make('nome_diri')
                ->searchable()
                ->sortable(),

            'email' => TextColumn::make('email')
                ->searchable()
                ->sortable(),

            'anno' => TextColumn::make('anno')
                ->numeric()
                ->sortable(),
        ];
    }

    

    /**
     * Get the Eloquent query builder.
     *
     * @return Builder<StabiDirigente>
     */
    public function getEloquentQuery(): Builder
    {
        return StabiDirigenteResource::getEloquentQuery();
    }

     /**
     * Undocumented function.
     *
     * @return array<\Filament\Tables\Filters\BaseFilter>
     */
    public function getTableFilters(): array
    {
        return [
            SelectFilter::make('anno')
                ->options([
                    '2022' => '2022',
                    '2023' => '2023',
                    '2024' => '2024',
                    '2025' => '2025',
                    '2026' => '2026',
                ])->query(static function (Builder $query, array $data): Builder {
                    if (null == $data['value']) {
                        return $query->where('id', 0);
                    }

                    return $query->where('anno', $data['value']);
                }),
        ];
    }
}
