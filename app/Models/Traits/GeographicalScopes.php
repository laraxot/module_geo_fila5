<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait GeographicalScopes
{
    /**
     * Scope per calcolare la distanza tra due punti.
     */
    public function scopeWithDistance(Builder $query, float $latitude, float $longitude): Builder
    {
        return $query->select('*')->selectRaw(
            $this->getDistanceSql(withAlias: true),
            [$latitude, $longitude, $latitude],
        );
    }

    /**
     * Scope per ordinare i risultati per distanza.
     */
    public function scopeOrderByDistance(Builder $query, float $latitude, float $longitude): Builder
    {
        return $query->orderByRaw(
            $this->getDistanceSql(),
            [$latitude, $longitude, $latitude],
        );
    }

    private function getDistanceSql(bool $withAlias = false): string
    {
        $sql = '
            (6371 * acos(
                cos(radians(?)) *
                cos(radians(latitude)) *
                cos(radians(longitude) - radians(?)) +
                sin(radians(?)) *
                sin(radians(latitude))
            ))
        ';

        return $withAlias ? $sql.' AS distance' : $sql;
    }
}
