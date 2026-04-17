<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\SchedaResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Progressioni\Filament\Resources\SchedaResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditScheda extends XotBaseEditRecord
{
    public static string $resource = SchedaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
