<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\AddressResource\Pages;

use Modules\Geo\Filament\Resources\AddressResource;
use Modules\Geo\Filament\Resources\AddressResource\Schemas\AddressInfolist;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewAddress extends XotBaseViewRecord
{
    protected static string $resource = AddressResource::class;

    /**
     * @return array<string, \Filament\Schemas\Components\Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return app(AddressInfolist::class)->getInfolistSchema();
    }
}
