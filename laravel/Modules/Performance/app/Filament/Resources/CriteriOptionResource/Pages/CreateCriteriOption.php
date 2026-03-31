<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\CriteriOptionResource\Pages;

use Modules\Performance\Filament\Resources\CriteriOptionResource;
use Modules\Ptv\Filament\Resources\CriteriOptionResource\Pages\CreateCriteriOption as PtvCreateCriteriOption;

class CreateCriteriOption extends PtvCreateCriteriOption
{
    public static string $resource = CriteriOptionResource::class;
}
