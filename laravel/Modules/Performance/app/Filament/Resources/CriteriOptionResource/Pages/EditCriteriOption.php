<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\CriteriOptionResource\Pages;

use Modules\Performance\Filament\Resources\CriteriOptionResource;
use Modules\Ptv\Filament\Resources\CriteriOptionResource\Pages\EditCriteriOption as PtvEditCriteriOption;

class EditCriteriOption extends PtvEditCriteriOption
{
    public static string $resource = CriteriOptionResource::class;
}
