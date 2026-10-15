<?php

declare(strict_types=1);

namespace Tests\Modules\Geo\Fixtures\Traits;

use Modules\Geo\Models\Traits\HasPlaceTrait;

final class HasPlaceTraitPhpstanProbe extends GeoPhpstanProbeModel
{
    use HasPlaceTrait;
}
