<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\MessageResource\Pages;

use Modules\Ptv\Filament\Resources\MessageResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditMessage extends XotBaseEditRecord
{
    protected static string $resource = MessageResource::class;
}
