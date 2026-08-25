<?php

declare(strict_types=1);

namespace Modules\Geo\Datas\GoogleMaps;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

/**
 * Data Transfer Object per le risposte dell'API di Google Maps.
 */
class GoogleMapResponseData extends Data
{
    /**
<<<<<<< HEAD
    * @param DataCollection<int, GoogleMapResultData> $results Risultati della geocodifica
=======
     * @param DataCollection<int, GoogleMapResultData> $results Risultati della geocodifica
>>>>>>> laraxot/dev
     * @param string                                   $status  Stato della risposta
     */
    public function __construct(
        public readonly DataCollection $results,
        public readonly string $status,
    ) {
    }
}
