<?php

declare(strict_types=1);

namespace Modules\Geo\Datas\Elevation;

// ponytail: root-level Modules\Geo\Datas\ElevationResultDTO was identical — deleted.
// Use this canonical version in Modules\Geo\Datas\Elevation namespace.
readonly class ElevationResultDTO
{
    public function __construct(
        public float $elevation,
        public float $latitude,
        public float $longitude,
    ) {
    }
}
