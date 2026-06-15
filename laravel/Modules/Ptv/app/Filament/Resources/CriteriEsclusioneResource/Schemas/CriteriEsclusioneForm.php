<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\CriteriEsclusioneResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Ptv\Enums\CriteriEsclusioneEnum;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class CriteriEsclusioneForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->disabled(),
            'name' => Select::make('name')->options(CriteriEsclusioneEnum::class),
            'field_name' => TextInput::make('field_name'),
            'op' => Select::make('op')
                ->options([
                    '=' => 'Uguale a',
                    '!=' => 'Diverso da',
                    '>' => 'Maggiore di',
                    '<' => 'Minore di',
                    '>=' => 'Maggiore o uguale a',
                    '<=' => 'Minore o uguale a',
                    'LIKE' => 'Contiene',
                    'NOT LIKE' => 'Non contiene',
                ]),
            'value' => TextInput::make('value')->required(),
            'type' => Select::make('type')
                ->options([
                    'string' => 'Stringa',
                    'int' => 'Intero',
                    'date' => 'Data',
                    'list' => 'Lista',
                ]),
            'anno' => TextInput::make('anno')->numeric()->required(),
        ];
    }
}
