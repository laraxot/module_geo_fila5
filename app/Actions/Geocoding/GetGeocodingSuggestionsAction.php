<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Geocoding;

use Spatie\QueueableAction\QueueableAction;

/**
 * Ottiene suggerimenti per la ricerca di un indirizzo.
 */
class GetGeocodingSuggestionsAction
{
    use QueueableAction;

    /**
     * @return array<int, array<string, mixed>>
     */
    public function execute(string $query): array
    {
        return [];
    }
}
