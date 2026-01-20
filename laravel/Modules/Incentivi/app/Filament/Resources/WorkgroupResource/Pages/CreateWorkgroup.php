<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\WorkgroupResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Incentivi\Filament\Resources\WorkgroupResource;

class CreateWorkgroup extends CreateRecord
{
    protected static string $resource = WorkgroupResource::class;
}
