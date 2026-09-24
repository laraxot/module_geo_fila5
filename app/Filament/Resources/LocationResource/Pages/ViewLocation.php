<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\LocationResource\Pages;

use Filament\Actions\EditAction;
use Modules\Geo\Filament\Resources\LocationResource;
use Modules\Geo\Filament\Resources\LocationResource\Schemas\LocationInfolist;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewLocation extends XotBaseViewRecord
{
    protected static string $resource = LocationResource::class;

    /**
     * @return array<string, EditAction>
     */
    protected function getHeaderActions(): array
    {
        return [
            'edit' => EditAction::make(),
        ];
    }

    /**
     * @return array<string, \Filament\Schemas\Components\Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return app(LocationInfolist::class)->getInfolistSchema();
    }
}
