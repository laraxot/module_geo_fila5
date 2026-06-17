<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Support\Components\Component;
use Modules\Ptv\Enums\CriteriEsclusioneEnum;
use Modules\Ptv\Models\CriteriEsclusione;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

abstract class BaseCriteriEsclusioneResource extends XotBaseResource
{
    protected static ?string $model = CriteriEsclusione::class;

    /**
     * @return array<string, Component>
     */
    #[Override]
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
