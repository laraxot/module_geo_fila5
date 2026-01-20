<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources\StabiDirigenteResource\Pages;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Modules\IndennitaCondizioniLavoro\Filament\Resources\StabiDirigenteResource;
use Modules\Ptv\Filament\Resources\StabiDirigenteResource\Pages\ListStabiDirigentes as PtvListStabiDirigentes;
use Override;

class ListStabiDirigentes extends PtvListStabiDirigentes
{
    protected static string $resource = StabiDirigenteResource::class;

    #[Override]
    /**
     * @return array<string, \Filament\Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        /** @var array<string, \Filament\Tables\Columns\Column> $columns */
        $columns = parent::getTableColumns();
        $columns['quadrimestre'] = TextColumn::make('quadrimestre');

        return $columns;
    }

    #[Override]
    public function getTableFilters(): array
    {
        $fiters = parent::getTableFilters();
        $fiters[] = SelectFilter::make('quadrimestre')
            ->options([
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
            ])->query(static fn (Builder $query, array $data): Builder => $query->when($data['value'], fn (Builder $query, $quadrimestre) => $query->where('quadrimestre', $quadrimestre)));

        return $fiters;
    }
}
