<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Map;

use Spatie\QueueableAction\QueueableAction;

/**
 * Ottiene i marker della mappa in base ai filtri.
 */
class GetMapMarkersAction
{
    use QueueableAction;

    /**
     * @param array<string, mixed> $filters
     *
     * @return array<int, array<string, mixed>>
     */
    public function execute(array $filters = []): array
    {
        return [];
    }
}
