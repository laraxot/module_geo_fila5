<?php

declare(strict_types=1);

namespace Modules\Geo\app\Actions\Map;

use Spatie\QueueableAction\QueueableAction;

/**
 * @phpstan-type MapFilters array{category?: string, categories?: list<string>, search?: string|null, bounds?: array{minLat: float, minLng: float, maxLat: float, maxLng: float}, limit?: int, offset?: int}
 * @phpstan-type MapStats array{total: int, categories: int}
 */
final class GetMapStatsAction
{
    use QueueableAction;

    /**
     * @param MapFilters $filters
     * @return MapStats
     */
    public function execute(array $filters = []): array
    {
        return ['total' => 0, 'categories' => 0];
    }
}
