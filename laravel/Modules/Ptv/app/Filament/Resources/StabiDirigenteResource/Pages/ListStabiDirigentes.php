<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\StabiDirigenteResource\Pages;

use Filament\Actions;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Filament\Resources\StabiDirigenteResource;
use Modules\Ptv\Models\StabiDirigente;
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
     * Get the table actions definition.
     *
     * @return array<string, Actions\Action>
     */
    public function getTableActions(): array
    {
        return [
            'view' => ViewAction::make(),
            'edit' => EditAction::make(),
        ];
    }

    /**
     * Get the table bulk actions definition.
     *
     * @return array<string, Actions\BulkAction>
     */
    public function getTableBulkActions(): array
    {
        return [
            'delete' => DeleteBulkAction::make(),
        ];
    }

    /**
     * Get the header actions.
     *
     * @return array<string, Actions\Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            'create' => Actions\CreateAction::make(),
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
}
