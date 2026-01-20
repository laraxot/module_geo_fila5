<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Modules\Performance\Models\StabiDirigente;
use Modules\Ptv\Filament\Resources\StabiDirigenteResource as PtvStabiDirigenteResource;

class StabiDirigenteResource extends PtvStabiDirigenteResource
{
    protected static ?string $model = StabiDirigente::class;
}
