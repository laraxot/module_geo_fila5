<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources;

use Modules\Geo\Models\Address;
use Modules\Xot\Filament\Resources\XotBaseResource;

class AddressResource extends XotBaseResource
{
    protected static ?string $model = Address::class;
}
