<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Geocoding;

use Spatie\QueueableAction\QueueableAction;

/**
 * Geocodifica un indirizzo in coordinate.
 */
class GeocodeAddressAction
{
    use QueueableAction;

    /**
     * @throws \RuntimeException Se l'indirizzo non viene trovato
     *
     * @return array{latitude: float, longitude: float, address: string}
     */
    public function execute(string $address): array
    {
        throw new \RuntimeException('Geocoding non ancora implementato');
    }
}
