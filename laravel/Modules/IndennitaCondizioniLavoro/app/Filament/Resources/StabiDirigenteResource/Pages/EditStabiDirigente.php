<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources\StabiDirigenteResource\Pages;

use Modules\IndennitaCondizioniLavoro\Filament\Resources\StabiDirigenteResource;
use Modules\Ptv\Filament\Resources\StabiDirigenteResource\Pages\EditStabiDirigente as PtvEditStabiDirigente;

class EditStabiDirigente extends PtvEditStabiDirigente
{
    protected static string $resource = StabiDirigenteResource::class;
}
