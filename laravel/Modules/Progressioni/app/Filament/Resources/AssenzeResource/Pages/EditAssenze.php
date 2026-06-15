<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\AssenzeResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Modules\Progressioni\Filament\Resources\AssenzeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditAssenze extends XotBaseEditRecord
{
    protected static string $resource = AssenzeResource::class;

    /**
     * @return array<string, Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
