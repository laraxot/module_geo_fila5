<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\MessageResource\Pages;

use Modules\IndennitaResponsabilita\Filament\Resources\MessageResource;
use Modules\Ptv\Filament\Resources\MessageResource\Pages\EditMessage as PtvEditMessage;

class EditMessage extends PtvEditMessage
{
    protected static string $resource = MessageResource::class;
}
