<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Map;

use Modules\Geo\Datas\Map\MarkerData;
use Spatie\QueueableAction\QueueableAction;

/**
 * Marker mappa interattiva (stub — implementazione dominio futura).
 *
 * Sostituisce MapService::getMarkers().
 *
 * @phpstan-type MapFilters array{category?: string, categories?: list<string>, search?: string|null, bounds?: array{minLat: float, minLng: float, maxLat: float, maxLng: float}, limit?: int, offset?: int}
 */
final class GetMapMarkersAction
{
    use QueueableAction;

    /**
     * @param MapFilters $filters
     * @return list<MarkerData>
     */
    public function execute(array $filters = []): array
    {
        return [];
    }
}
