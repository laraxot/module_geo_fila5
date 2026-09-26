<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\Pages;

<<<<<<< .merge_file_C1SpiF
=======
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
>>>>>>> .merge_file_teAgtC
use Modules\Geo\Filament\Resources\LocationResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewLocation extends XotBaseViewRecord
{
    protected static string $resource = LocationResource::class;
<<<<<<< .merge_file_C1SpiF
=======

    /**
     * @return array<string, Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return [
            'location_info' => Section::make('Informazioni Location')
                ->schema([
                    'name' => TextEntry::make('name'),
                    'address' => TextEntry::make('address'),
                    'city' => TextEntry::make('city'),
                    'postal_code' => TextEntry::make('postal_code'),
                    'country' => TextEntry::make('country'),
                ])
                ->columns(2),
        ];
    }
>>>>>>> .merge_file_teAgtC
}
