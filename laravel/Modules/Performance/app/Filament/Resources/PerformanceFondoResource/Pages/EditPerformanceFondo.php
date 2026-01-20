<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\PerformanceFondoResource\Pages;

use Modules\Performance\Filament\Resources\PerformanceFondoResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

use function Safe\ini_set;

ini_set('max_execution_time', '300');
ini_set('memory_limit', '512M');

class EditPerformanceFondo extends XotBaseEditRecord
{
    protected static string $resource = PerformanceFondoResource::class;
}
