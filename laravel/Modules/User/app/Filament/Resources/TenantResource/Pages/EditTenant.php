<?php

/**
 * --.
 */
declare(strict_types=1);

namespace Modules\User\Filament\Resources\TenantResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Modules\User\Filament\Resources\TenantResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditTenant extends XotBaseEditRecord
{
    public static string $resource = TenantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'view' => ViewAction::make(),
            'delete' => DeleteAction::make(),
        ];
    }
}
