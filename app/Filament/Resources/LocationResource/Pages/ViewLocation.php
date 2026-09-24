<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\LocationResource\Pages;

use Filament\Actions\EditAction;
<<<<<<< HEAD
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Modules\Geo\Filament\Resources\LocationResource;
=======
use Modules\Geo\Filament\Resources\LocationResource;
use Modules\Geo\Filament\Resources\LocationResource\Schemas\LocationInfolist;
>>>>>>> laraxot/dev
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewLocation extends XotBaseViewRecord
{
    protected static string $resource = LocationResource::class;

<<<<<<< HEAD
=======
    /**
     * @return array<string, EditAction>
     */
>>>>>>> laraxot/dev
    protected function getHeaderActions(): array
    {
        return [
            'edit' => EditAction::make(),
        ];
    }

<<<<<<< HEAD
    
=======
    /**
     * @return array<string, \Filament\Schemas\Components\Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return app(LocationInfolist::class)->getInfolistSchema();
    }
>>>>>>> laraxot/dev
}
