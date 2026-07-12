<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Map;

use Spatie\QueueableAction\QueueableAction;

/**
 * Esporta i dati della mappa nel formato specificato.
 */
class ExportMapDataAction
{
    use QueueableAction;

    /**
     * @param array<string, mixed> $filters
     *
     * @return array<string, mixed>|string
     */
    public function execute(array $filters = [], string $format = 'json'): array|string
    {
        return [];
    }
}
