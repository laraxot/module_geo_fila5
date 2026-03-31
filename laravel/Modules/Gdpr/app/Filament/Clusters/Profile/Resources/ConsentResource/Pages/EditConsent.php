<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Clusters\Profile\Resources\ConsentResource\Pages;

use Modules\Gdpr\Filament\Clusters\Profile\Resources\ConsentResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditConsent extends XotBaseEditRecord
{
    public static string $resource = ConsentResource::class;
}
