<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\OptionResource\Pages;

use Modules\Performance\Filament\Resources\OptionResource;
use Modules\Ptv\Filament\Resources\OptionResource\Pages\CreateOption as PtvCreateOption;

class CreateOption extends PtvCreateOption
{
    public static string $resource = OptionResource::class;
}
