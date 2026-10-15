<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Map;

use Spatie\QueueableAction\QueueableAction;

/**
 * @phpstan-type MapFilters array{category?: string, categories?: list<string>, search?: string|null, bounds?: array{minLat: float, minLng: float, maxLat: float, maxLng: float}, limit?: int, offset?: int}
 * @phpstan-type MapMarker array{id: string, lat: float, lng: float, category: string}
 */
final class GetMapMarkersAction
{
    use QueueableAction;

    /**
     * @param MapFilters $filters
     * @return list<MapMarker>
     */
    public function execute(array $filters = []): array
    {
        return [];
    }
}
