<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\Pages;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\Geo\Filament\Resources\LocationResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewLocation extends XotBaseViewRecord
{
    protected static string $resource = LocationResource::class;

    /**
     * @return array<string, EditAction>
     */
    {
        return [
            'edit' => EditAction::make(),
        ];
    }

    /**
     * @return array<string, \Filament\Schemas\Components\Component>
     */
    {
        return app(LocationInfolist::class)->getInfolistSchema();
    }
}
