<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class UserInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, \Filament\Infolists\Components\Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'name' => TextEntry::make('name'),
            'email' => TextEntry::make('email'),
            'created_at' => TextEntry::make('created_at')->dateTime(),
        ];
    }
}
