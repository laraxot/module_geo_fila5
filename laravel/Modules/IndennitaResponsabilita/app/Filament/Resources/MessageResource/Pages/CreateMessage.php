<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\MessageResource\Pages;

use Modules\IndennitaResponsabilita\Filament\Resources\MessageResource;
use Modules\Ptv\Filament\Resources\MessageResource\Pages\CreateMessage as PtvCreateMessage;

class CreateMessage extends PtvCreateMessage
{
    public static string $resource = MessageResource::class;
}
