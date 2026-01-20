<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources;

use Modules\Progressioni\Models\CriteriEsclusione;
use Modules\Ptv\Filament\Resources\CriteriEsclusioneResource as PtvCriteriEsclusioneResource;

class CriteriEsclusioneResource extends PtvCriteriEsclusioneResource
{
    protected static ?string $model = CriteriEsclusione::class;
}
