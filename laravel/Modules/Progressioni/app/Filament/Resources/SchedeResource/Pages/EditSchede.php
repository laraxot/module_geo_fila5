<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\SchedeResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Progressioni\Filament\Resources\SchedeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditSchede extends XotBaseEditRecord
{
    protected static string $resource = SchedeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
