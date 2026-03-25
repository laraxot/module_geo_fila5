<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\MessageResource\Pages;

use Filament\Actions\CreateAction;
use Modules\IndennitaResponsabilita\Filament\Resources\MessageResource;
use Modules\Ptv\Filament\Resources\MessageResource\Pages\ListMessages as PtvListMessages;
use Override;

class ListMessages extends PtvListMessages
{
    public static string $resource = MessageResource::class;

    
}
