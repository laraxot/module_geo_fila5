<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\StabiDirigenteResource\Pages;

use Modules\IndennitaResponsabilita\Filament\Resources\StabiDirigenteResource;
use Modules\Ptv\Filament\Resources\StabiDirigenteResource\Pages\CreateStabiDirigente as PtvCreateStabiDirigente;

class CreateStabiDirigente extends PtvCreateStabiDirigente
{
    protected static string $resource = StabiDirigenteResource::class;
}
