<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\AssenzeResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Progressioni\Filament\Resources\AssenzeResource;

class CreateAssenze extends CreateRecord
{
    protected static string $resource = AssenzeResource::class;
}
