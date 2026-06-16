<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\RatingResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Modules\Progressioni\Filament\Resources\RatingResource;
use Modules\Progressioni\Models\Rating;
use Override;
use Modules\Rating\Filament\Resources\RatingResource\Tables\BaseRatingsTable;

class RatingsTable extends BaseRatingsTable
{
    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            ...parent::getTableColumns(),
            'extra_attributes_type' => TextColumn::make('extra_attributes.type'),
            'extra_attributes_anno' => TextColumn::make('extra_attributes.anno'),
            /*
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
            */
        ];
    }


    /**
     * @return array<string, Filter>
     */
    #[Override]
    public function getTableFilters(): array
    {
        return [
            'filter' => Filter::make('filter')
                ->schema([
                    'anno' => Select::make('anno')
                        ->options(self::getYears()),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    if (! isset($data['anno'])) {
                        return $query;
                    }
                    /** @var Builder<Rating> $query */
                    /** @var int|string|null $anno */
                    $anno = $data['anno'] ?? null;
                    if ($anno === null) {
                        return $query;
                    }

                    // Query per schemaless attributes - filtra per extra_attributes->anno
                    return $query->where('extra_attributes->anno', $anno);
                }),
        ];
    }

    /**
     * @return array<int, string>
     */
    protected static function getYears(): array
    {
        $currentYear = Carbon::now()->year;
        $years = [];
        for ($year = $currentYear; $year >= $currentYear-2; $year--) {
            $years[$year] = (string) $year;
        }
        return $years;
       
    }
}
