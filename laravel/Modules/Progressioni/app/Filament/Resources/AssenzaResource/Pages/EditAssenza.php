<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\AssenzaResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Modules\Progressioni\Filament\Resources\AssenzaResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditAssenza extends XotBaseEditRecord
{
    protected static string $resource = AssenzaResource::class;

    
}
