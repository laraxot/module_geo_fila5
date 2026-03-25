<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\EsclusiExtraResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Progressioni\Filament\Resources\EsclusiExtraResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditEsclusiExtra extends XotBaseEditRecord
{
    public static string $resource = EsclusiExtraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
