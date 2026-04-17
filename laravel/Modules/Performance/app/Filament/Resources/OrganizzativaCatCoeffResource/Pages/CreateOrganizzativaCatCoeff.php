<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\OrganizzativaCatCoeffResource\Pages;

use Modules\Performance\Filament\Resources\OrganizzativaCatCoeffResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateOrganizzativaCatCoeff extends XotBaseCreateRecord
{
    public static string $resource = OrganizzativaCatCoeffResource::class;
}
