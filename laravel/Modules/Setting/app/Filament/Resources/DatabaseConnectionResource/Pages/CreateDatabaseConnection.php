<?php

declare(strict_types=1);

namespace Modules\Setting\Filament\Resources\DatabaseConnectionResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Setting\Filament\Resources\DatabaseConnectionResource;
use Modules\Setting\Models\DatabaseConnection;

class CreateDatabaseConnection extends CreateRecord
{
    protected static string $resource = DatabaseConnectionResource::class;

    protected function getRedirectUrl(): string
    {
        $resource = $this->getResource();
        $url = $resource::getUrl('index');

        return is_string($url) ? $url : '';
    }

    protected function afterCreate(): void
    {
        /** @var DatabaseConnection|null $connection */
        $connection = $this->record;

        if ($connection && $connection->status === 'active') {
            $connection->testConnection();
        }
    }
}
