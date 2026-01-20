<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Modules\Progressioni\Filament\Resources\MessageResource\Pages\CreateMessage;
use Modules\Progressioni\Filament\Resources\MessageResource\Pages\EditMessage;
use Modules\Progressioni\Filament\Resources\MessageResource\Pages\ListMessages;
use Modules\Progressioni\Models\Message;
use Modules\Ptv\Filament\Resources\MessageResource as PtvMessageResource;
use Override;

class MessageResource extends PtvMessageResource
{
    protected static ?string $model = Message::class;

    /*
    public static function getFormSchemaOOO(): array
    {
        return [
            TextInput::make('id')->disabled(),
            Select::make('type')
                ->options([
                    'info' => 'Informazione',
                    'warning' => 'Avviso',
                    'error' => 'Errore',
                    'success' => 'Successo',
                ])
                ->required(),
            TextInput::make('title')->required(),
            Textarea::make('txt')->rows(5)->required(),
            TextInput::make('anno')->numeric()->required(),
        ];
    }
    */
    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListMessages::route('/'),
            'create' => CreateMessage::route('/create'),
            'edit' => EditMessage::route('/{record}/edit'),
        ];
    }
}
