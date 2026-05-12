<?php

declare(strict_types=1);

namespace Modules\User\app\Filament\Clusters\Socialite\Resources\SsoProviderResource\Schemas;

use Filament\Infolists\Components\TextEntry;

class SsoProviderInfolist
{
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'name' => TextEntry::make('name'),
            'created_at' => TextEntry::make('created_at')->dateTime(),
        ];
    }
}
