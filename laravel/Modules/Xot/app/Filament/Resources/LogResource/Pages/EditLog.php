<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\LogResource\Pages;

use Modules\Xot\Filament\Resources\LogResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditLog extends XotBaseEditRecord
{
    public static string $resource = LogResource::class;
}
