<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Modules\Performance\Filament\Resources\OptionResource\Pages;
use Modules\Performance\Models\Option;
use Modules\Ptv\Filament\Resources\OptionResource as PtvOptionResource;

class OptionResource extends PtvOptionResource
{
    protected static ?string $model = Option::class;

    /*

     public static function getPages(): array
     {
         return [
             'index' => Pages\ListOptions::route('/'),
             'create' => Pages\CreateOption::route('/create'),
             'edit' => Pages\EditOption::route('/{record}/edit'),
         ];
     }
     */
}
