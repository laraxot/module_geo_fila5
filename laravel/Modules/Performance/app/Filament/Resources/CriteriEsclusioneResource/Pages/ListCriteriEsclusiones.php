<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\CriteriEsclusioneResource\Pages;

use Modules\Performance\Filament\Resources\CriteriEsclusioneResource;
use Modules\Ptv\Filament\Resources\CriteriEsclusioneResource\Pages\ListCriteriEsclusiones as PtvListCriteriEsclusiones;

class ListCriteriEsclusiones extends PtvListCriteriEsclusiones
{
    public static string $resource = CriteriEsclusioneResource::class;
}
