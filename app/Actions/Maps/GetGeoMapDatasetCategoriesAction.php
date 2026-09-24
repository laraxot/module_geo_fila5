<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Maps;

use Spatie\QueueableAction\QueueableAction;

final class GetGeoMapDatasetCategoriesAction
{
    use QueueableAction;

    /**
     * @param  list<array{type: string, properties: array<string, scalar|null>, geometry: array{type: string, coordinates: array<mixed>}}>  $features
     * @return list<string>
     */
    public function execute(array $features): array
    {
        $categories = [];

        foreach ($features as $feature) {
            if (($feature['geometry']['type'] ?? null) !== 'Point') {
                continue;
            }

            $category = $feature['properties']['p'] ?? $feature['properties']['category'] ?? null;

            if (is_string($category) && $category !== '') {
                $categories[] = $category;
            }
        }

        $categories = array_values(array_unique($categories));
        sort($categories);

        return $categories;
    }
}
