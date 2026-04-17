<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\OptionResource\Pages;

use Modules\Performance\Filament\Resources\OptionResource;
use Modules\Ptv\Filament\Resources\OptionResource\Pages\ListOptions as PtvListOptions;

class ListOptions extends PtvListOptions
{
    public static string $resource = OptionResource::class;
}
