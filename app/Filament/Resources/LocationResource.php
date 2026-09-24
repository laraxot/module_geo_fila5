<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources;

use Modules\Geo\Models\Location;
use Modules\Xot\Filament\Resources\XotBaseResource;

class LocationResource extends XotBaseResource
{
    protected static ?string $model = Location::class;
}
