<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\CriteriEsclusioneResource\Pages;

use Modules\Performance\Filament\Resources\CriteriEsclusioneResource;
use Modules\Ptv\Filament\Resources\CriteriEsclusioneResource\Pages\CreateCriteriEsclusione as PtvCreateCriteriEsclusione;

class CreateCriteriEsclusione extends PtvCreateCriteriEsclusione
{
    public static string $resource = CriteriEsclusioneResource::class;
}
