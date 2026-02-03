<?php

declare(strict_types=1);

namespace Modules\Setting\Filament\Resources\DatabaseConnectionResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Modules\Setting\Filament\Resources\DatabaseConnectionResource;
use Modules\Setting\Models\DatabaseConnection;

class EditDatabaseConnection extends EditRecord
{
    protected static string $resource = DatabaseConnectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
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

    protected function afterSave(): void
    {
        /** @var DatabaseConnection|null $record */
        $record = $this->record;

        if ($record && 'active' === $record->status) {
            $record->testConnection();
        }
    }

    protected function getRedirectUrl(): string
    {
        $resource = $this->getResource();
        $url = $resource::getUrl('index');

        return is_string($url) ? $url : '';
    }
}
