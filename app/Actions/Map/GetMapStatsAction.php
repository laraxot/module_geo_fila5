<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Map;

use Spatie\QueueableAction\QueueableAction;

/**
 * Ottiene le statistiche della mappa in base ai filtri.
 */
class GetMapStatsAction
{
    use QueueableAction;

    /**
     * @param array<string, mixed> $filters
     *
     * @return array<string, mixed>
     */
    public function execute(array $filters = []): array
    {
        return [];
    }
}
