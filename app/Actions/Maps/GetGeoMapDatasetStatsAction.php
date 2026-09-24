<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Maps;

use Spatie\QueueableAction\QueueableAction;

final class GetGeoMapDatasetStatsAction
{
    use QueueableAction;

    /**
     * @param  list<array{type: string, properties: array<string, scalar|null>, geometry: array{type: string, coordinates: array<mixed>}}>  $features
     * @return array{total: int, points: int, zones: int, categories: int}
     */
    public function execute(array $features): array
    {
        $points = 0;
        $zones = 0;

        foreach ($features as $feature) {
            $geometryType = $feature['geometry']['type'] ?? null;

            if ($geometryType === 'Point') {
                ++$points;
            }

            if ($geometryType === 'Polygon' || $geometryType === 'MultiPolygon') {
                ++$zones;
            }
        }

        return [
            'total' => count($features),
            'points' => $points,
            'zones' => $zones,
            'categories' => count(app(GetGeoMapDatasetCategoriesAction::class)->execute($features)),
        ];
    }
}
