<?php

declare(strict_types=1);

namespace Modules\Setting\Filament\Resources\DatabaseConnectionResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Modules\Setting\Filament\Resources\DatabaseConnectionResource;
use Modules\Setting\Models\DatabaseConnection;

class ViewDatabaseConnection extends ViewRecord
{
    public static string $resource = DatabaseConnectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
            Action::make('test')
                ->action(function () {
                    /** @var DatabaseConnection|null $record */
                    $record = $this->record;
                    $record?->testConnection();
                })
                ->icon('heroicon-o-check-circle')
                ->color('success'),
        ];
    }
}
