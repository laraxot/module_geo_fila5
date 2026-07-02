<?php

declare(strict_types=1);

namespace Modules\Geo\Datas\Location;

use Spatie\LaravelData\Data;

// ponytail: root-level Modules\Geo\Datas\CoordinatesData was identical — deleted.
// Use this canonical version in Modules\Geo\Datas\Location namespace.
class CoordinatesData extends Data
{
    public function __construct(
        public readonly float $latitude,
        public readonly float $longitude,
    ) {
    }
}
