<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\OptionResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Ptv\Filament\Resources\OptionResource;

class CreateOption extends CreateRecord
{
    public static string $resource = OptionResource::class;
}
