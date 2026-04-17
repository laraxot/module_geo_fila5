<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\OptionResource\Pages;

use Modules\Ptv\Filament\Resources\OptionResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditOption extends XotBaseEditRecord
{
    public static string $resource = OptionResource::class;
}
