<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\MessageResource\Pages;

use Modules\Progressioni\Filament\Resources\MessageResource;
use Modules\Ptv\Filament\Resources\MessageResource\Pages\EditMessage as PtvEditMessage;

class EditMessage extends PtvEditMessage
{
    public static string $resource = MessageResource::class;
}
