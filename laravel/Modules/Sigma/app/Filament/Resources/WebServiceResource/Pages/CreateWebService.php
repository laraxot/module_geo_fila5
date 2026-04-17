<?php

declare(strict_types=1);

namespace Modules\Sigma\Filament\Resources\WebServiceResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Sigma\Filament\Resources\WebServiceResource;

class CreateWebService extends CreateRecord
{
    public static string $resource = WebServiceResource::class;
}
