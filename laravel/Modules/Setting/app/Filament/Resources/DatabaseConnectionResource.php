<?php

declare(strict_types=1);

namespace Modules\Setting\Filament\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Xot\Filament\Resources\XotBaseResource;

final class DatabaseConnectionResource extends XotBaseResource
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return array_merge(
            self::getConnectionFields(),
            self::getCredentialFields(),
            self::getOptionFields()
        );
    }

    /**
     * @return array<string, Component>
     */
    private static function getConnectionFields(): array
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
        ];
    }

    /**
     * @return array<string, Component>
     */
    private static function getCredentialFields(): array
    {
        return [
            'username' => TextInput::make('username')
                ->required()
                ->maxLength(255),
            'password' => TextInput::make('password')
                ->password()
                ->required()
                ->maxLength(255),
        ];
    }

    /**
     * @return array<string, Component>
     */
    private static function getOptionFields(): array
    {
        return [
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns(self::getTableColumnsSchema())
            ->filters([
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * @return array<int, \Filament\Tables\Columns\Column>
     */
    private static function getTableColumnsSchema(): array
    {
        return [
            TextColumn::make('name')
                ->searchable(),
            TextColumn::make('driver')
                ->searchable(),
            TextColumn::make('host')
                ->searchable(),
            TextColumn::make('port')
                ->numeric()
                ->sortable(),
            TextColumn::make('database')
                ->searchable(),
            TextColumn::make('username')
                ->searchable(),
            TextColumn::make('charset')
                ->searchable(),
            TextColumn::make('collation')
                ->searchable(),
            TextColumn::make('prefix')
                ->searchable(),
            IconColumn::make('strict')
                ->boolean(),
            TextColumn::make('engine')
                ->searchable(),
            TextColumn::make('status')
                ->searchable(),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
