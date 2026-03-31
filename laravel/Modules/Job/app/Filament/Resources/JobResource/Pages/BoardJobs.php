<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\JobResource\Pages;

use Modules\Job\Filament\Resources\JobResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseResourcePage;

class BoardJobs extends XotBaseResourcePage
{
    public static string $resource = JobResource::class;
}
