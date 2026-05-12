<?php

declare(strict_types=1);

namespace Modules\Job\app\Filament\Resources\JobsWaitingResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class JobsWaitingForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, \Filament\Forms\Components\Component>
     */
    public static function getFormSchema(): array
    {
        return [
            Section::make([
                'name' => TextInput::make('name'),
            ]),
        ];
    }
}