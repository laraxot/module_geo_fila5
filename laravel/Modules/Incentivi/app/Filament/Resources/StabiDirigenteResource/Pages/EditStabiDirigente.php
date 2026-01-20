<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\StabiDirigenteResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Incentivi\Filament\Resources\StabiDirigenteResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditStabiDirigente extends XotBaseEditRecord
{
    protected static string $resource = StabiDirigenteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
