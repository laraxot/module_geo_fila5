<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources;

use Modules\IndennitaResponsabilita\Models\MyLog;
use Modules\Ptv\Filament\Resources\MyLogResource as PtvMyLogResource;

class MyLogResource extends PtvMyLogResource
{
    protected static ?string $model = MyLog::class;
}
