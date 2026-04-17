<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\MessageResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Ptv\Filament\Resources\MessageResource;

class CreateMessage extends CreateRecord
{
    public static string $resource = MessageResource::class;
}
