<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\LocationResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
<<<<<<< .merge_file_oarJXp
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

/**
 * Schema del form Luogo.
 *
 * `latitude`/`longitude` restano campi numerici espliciti: il componente mappa
 * interattivo non è ancora portato su Filament 5, quindi le coordinate si
 * inseriscono a mano invece di essere ricavate dal picker.
 */
class LocationForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
=======
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class LocationForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, Component>
>>>>>>> .merge_file_ROyQFD
     */
    public function getFormSchema(): array
    {
        return [
<<<<<<< .merge_file_oarJXp
            'name' => TextInput::make('name')->required()->maxLength(255),
            'latitude' => TextInput::make('latitude')->required()->numeric(),
            'longitude' => TextInput::make('longitude')->required()->numeric(),
            'street' => TextInput::make('street')->maxLength(255),
            'city' => TextInput::make('city')->maxLength(255),
            'state' => TextInput::make('state')->maxLength(255),
            'zip' => TextInput::make('zip')->maxLength(255),
            'formatted_address' => TextInput::make('formatted_address')->maxLength(1024),
=======
            'main' => Section::make()
                ->schema([
                    TextInput::make('name'),
                ]),
>>>>>>> .merge_file_ROyQFD
        ];
    }
}
