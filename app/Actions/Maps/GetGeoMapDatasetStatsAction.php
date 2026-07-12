<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Maps;

use Spatie\QueueableAction\QueueableAction;

class GetGeoMapDatasetStatsAction
{
    use QueueableAction;

    public function __construct(
        private readonly LoadGeoMapDatasetAction $loadGeoMapDatasetAction = new LoadGeoMapDatasetAction(),
        private readonly GetGeoMapDatasetCategoriesAction $getGeoMapDatasetCategoriesAction = new GetGeoMapDatasetCategoriesAction(),
    ) {
    }

    /**
     * @return array{total: int, points: int, zones: int, categories: int}
     */
    public function execute(string $path): array
    {
        $features = $this->loadGeoMapDatasetAction->loadFeatures($path);
        $points = 0;
        $zones = 0;

        foreach ($features as $feature) {
            $geometryType = $feature['geometry']['type'] ?? null;

            if ('Point' === $geometryType) {
                ++$points;
            }

            if ('Polygon' === $geometryType || 'MultiPolygon' === $geometryType) {
                ++$zones;
            }
        }

        return [
            'total' => count($features),
            'points' => $points,
            'zones' => $zones,
            'categories' => count($this->getGeoMapDatasetCategoriesAction->execute($path)),
        ];
    }
}
