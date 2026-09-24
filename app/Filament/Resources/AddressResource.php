<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources;

<<<<<<< HEAD
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Geo\Models\Address;
=======
use Modules\Geo\Models\Address;
use Modules\Xot\Filament\Resources\XotBaseResource;
>>>>>>> laraxot/dev

class AddressResource extends XotBaseResource
{
    protected static ?string $model = Address::class;
}
