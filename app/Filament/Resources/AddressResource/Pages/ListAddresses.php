<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\AddressResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Modules\Geo\Filament\Resources\AddressResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListAddresses extends XotBaseListRecords
{
    protected static string $resource = AddressResource::class;

    /**
     * @return array<Action>
     */
    #[\Override]
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
