<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotificationTemplateResource\Pages;

use Modules\Notify\Filament\Resources\NotificationTemplateResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListNotificationTemplates extends XotBaseListRecords
{
    protected static string $resource = NotificationTemplateResource::class;

    #[Override]
    public function getTableColumns(): array
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ...array_map(
                    fn($col) => is_object($col) ? $col : TextColumn::make($col),
                    $this->getTableColumns()
                )
            ]);
    }
    {
        return [];
    }
}
