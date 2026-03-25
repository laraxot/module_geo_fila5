<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\LogResource\Pages;

use Modules\Xot\Filament\Resources\LogResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateLog extends XotBaseCreateRecord
{
    public static string $resource = LogResource::class;
}
