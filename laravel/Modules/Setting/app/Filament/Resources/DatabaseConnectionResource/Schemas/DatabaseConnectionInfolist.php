<?php

declare(strict_types=1);

namespace Modules\Setting\Filament\Resources\DatabaseConnectionResource\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class DatabaseConnectionInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'name' => TextEntry::make('name'),
            'driver' => TextEntry::make('driver'),
            'host' => TextEntry::make('host'),
            'port' => TextEntry::make('port'),
            'database' => TextEntry::make('database'),
            'username' => TextEntry::make('username'),
            'charset' => TextEntry::make('charset'),
            'collation' => TextEntry::make('collation'),
            'prefix' => TextEntry::make('prefix'),
            'strict' => IconEntry::make('strict')
                ->boolean(),
            'engine' => TextEntry::make('engine'),
            'status' => TextEntry::make('status'),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
