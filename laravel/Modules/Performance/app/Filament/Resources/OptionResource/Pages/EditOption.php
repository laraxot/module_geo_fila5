<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\OptionResource\Pages;

use Modules\Performance\Filament\Resources\OptionResource;
use Modules\Ptv\Filament\Resources\OptionResource\Pages\EditOption as PtvEditOption;

class EditOption extends PtvEditOption
{
    protected static string $resource = OptionResource::class;
}
