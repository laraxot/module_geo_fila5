<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\PerformanceResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Performance\Filament\Resources\PerformanceResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditPerformance extends XotBaseEditRecord
{
    protected static string $resource = PerformanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
