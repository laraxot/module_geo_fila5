<?php

declare(strict_types=1);

namespace Modules\Setting\Filament\Resources\DatabaseConnectionResource\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component as SchemaComponent;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class DatabaseConnectionForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')
                ->required()
                ->maxLength(255),
            'driver' => Select::make('driver')
                ->required()
                ->options([
                    'mysql' => 'MySQL',
                    'pgsql' => 'PostgreSQL',
                    'sqlite' => 'SQLite',
                    'sqlsrv' => 'SQL Server',
                ]),
            'host' => TextInput::make('host')
                ->required()
                ->maxLength(255),
            'port' => TextInput::make('port')
                ->required()
                ->numeric(),
            'database' => TextInput::make('database')
                ->required()
                ->maxLength(255),
            'username' => TextInput::make('username')
                ->required()
                ->maxLength(255),
            'password' => TextInput::make('password')
                ->password()
                ->required()
                ->maxLength(255),
            'charset' => TextInput::make('charset')
                ->maxLength(255),
            'collation' => TextInput::make('collation')
                ->maxLength(255),
            'prefix' => TextInput::make('prefix')
                ->maxLength(255),
            'strict' => Toggle::make('strict')
                ->required(),
            'engine' => TextInput::make('engine')
                ->maxLength(255),
            'options' => KeyValue::make('options'),
            'status' => Select::make('status')
                ->required()
                ->options([
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                ]),
        ];
    }
}
