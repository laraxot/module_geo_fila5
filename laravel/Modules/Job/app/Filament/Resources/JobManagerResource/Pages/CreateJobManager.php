<?php

/**
 * --.
 */

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\JobManagerResource\Pages;

use Modules\Job\Filament\Resources\JobManagerResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateJobManager extends XotBaseCreateRecord
{
    public static string $resource = JobManagerResource::class;
}
