<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources\CondizioniLavoroAdmResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\IndennitaCondizioniLavoro\Filament\Resources\CondizioniLavoroAdmResource;

class CreateCondizioniLavoroAdm extends CreateRecord
{
    public static string $resource = CondizioniLavoroAdmResource::class;
}
