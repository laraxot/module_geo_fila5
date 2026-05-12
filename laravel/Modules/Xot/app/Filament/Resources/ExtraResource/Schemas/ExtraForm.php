<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\ExtraResource\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class ExtraForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, \Filament\Forms\Components\Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->required()->maxLength(36),
            'post_type' => TextInput::make('post_type')->required()->maxLength(255),
            'post_id' => TextInput::make('post_id')->required()->numeric(),
            'value' => KeyValue::make('value')
                ->keyLabel('Chiave')
                ->valueLabel('Valore')
                ->reorderable()
                ->columnSpanFull(),
        ];
    }
}
