<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\TreatmentResource\Pages;

use Modules\Gdpr\Filament\Resources\TreatmentResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateTreatment extends XotBaseCreateRecord
{
    public static string $resource = TreatmentResource::class;
}
