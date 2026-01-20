<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Modules\Progressioni\Filament\Resources\AssenzeResource\Pages\CreateAssenze;
use Modules\Progressioni\Filament\Resources\AssenzeResource\Pages\EditAssenze;
use Modules\Progressioni\Filament\Resources\AssenzeResource\Pages\ListAssenzes;
use Modules\Progressioni\Models\Assenze;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class AssenzeResource extends XotBaseResource
{
    protected static ?string $model = Assenze::class;

    #[Override]
    /**
     * @return array<string, \Filament\Forms\Components\Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->disabled(),
            'tipo' => TextInput::make('tipo')->numeric(),
            'codice' => TextInput::make('codice')->numeric(),
            'descr' => TextInput::make('descr')->maxLength(250),
            'anno' => TextInput::make('anno')->numeric(),
            'umi' => TextInput::make('umi')->maxLength(2),
            'dur' => TextInput::make('dur')->maxLength(50),
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListAssenzes::route('/'),
            'create' => CreateAssenze::route('/create'),
            'edit' => EditAssenze::route('/{record}/edit'),
        ];
    }
}
