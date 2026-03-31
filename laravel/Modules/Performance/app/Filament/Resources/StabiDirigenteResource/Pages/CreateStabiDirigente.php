<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\StabiDirigenteResource\Pages;

use Modules\Performance\Filament\Resources\StabiDirigenteResource;
use Modules\Ptv\Filament\Resources\StabiDirigenteResource\Pages\CreateStabiDirigente as PtvcCreateStabiDirigente;

class CreateStabiDirigente extends PtvcCreateStabiDirigente
{
    public static string $resource = StabiDirigenteResource::class;
}
