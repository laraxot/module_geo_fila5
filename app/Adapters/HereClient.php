<?php

declare(strict_types=1);

namespace Modules\Geo\Adapters;

use Modules\Geo\Actions\Here\GetHereRouteDurationAndLengthAction;

/**
 * Adapter per l'API HERE Routing (durata e lunghezza percorso).
 */
class HereClient
{
    /**
     * @return array<string, mixed>|null
     */
    public function getDurationAndLength(float $lat1, float $lon1, float $lat2, float $lon2): ?array
    {
        return app(GetHereRouteDurationAndLengthAction::class)->execute($lat1, $lon1, $lat2, $lon2);
    }
}
