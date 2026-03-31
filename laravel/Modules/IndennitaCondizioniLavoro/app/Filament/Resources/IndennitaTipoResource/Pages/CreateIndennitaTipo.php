<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources\IndennitaTipoResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\IndennitaCondizioniLavoro\Filament\Resources\IndennitaTipoResource;

class CreateIndennitaTipo extends CreateRecord
{
    public static string $resource = IndennitaTipoResource::class;
}
