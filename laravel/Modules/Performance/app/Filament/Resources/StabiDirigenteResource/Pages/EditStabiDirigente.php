<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\StabiDirigenteResource\Pages;

use Modules\Performance\Filament\Resources\StabiDirigenteResource;
use Modules\Ptv\Filament\Resources\StabiDirigenteResource\Pages\EditStabiDirigente as PtvcEditStabiDirigente;

class EditStabiDirigente extends PtvcEditStabiDirigente
{
    protected static string $resource = StabiDirigenteResource::class;
}
