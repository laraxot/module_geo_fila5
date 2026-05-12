<?php

declare(strict_types=1);

namespace Modules\User\app\Filament\Clusters\Socialite\Resources\SocialiteUserResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class SocialiteUserForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, \Filament\Schemas\Components\Component>
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
