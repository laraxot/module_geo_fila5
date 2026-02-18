<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Modules\IndennitaCondizioniLavoro\Filament\Resources\StabiDirigenteResource\Pages;
use Modules\IndennitaCondizioniLavoro\Models\StabiDirigente;
use Modules\Ptv\Filament\Resources\StabiDirigenteResource as PtvStabiDirigenteResource;
use Override;

class StabiDirigenteResource extends PtvStabiDirigenteResource
{
    protected static ?string $model = StabiDirigente::class;

    #[Override]
    public static function getFormSchema(): array
    {
        return [
            ...parent::getFormSchema(),
            'quadrimestre' => TextInput::make('quadrimestre'),
        ];
    }
    /*
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStabiDirigentes::route('/'),
            'create' => Pages\CreateStabiDirigente::route('/create'),
            'edit' => Pages\EditStabiDirigente::route('/{record}/edit'),
        ];
    }
        */
}
