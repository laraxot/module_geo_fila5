<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\PerformanceResource\Pages;

use Modules\Performance\Filament\Resources\PerformanceResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreatePerformance extends XotBaseCreateRecord
{
    protected static string $resource = PerformanceResource::class;
}
