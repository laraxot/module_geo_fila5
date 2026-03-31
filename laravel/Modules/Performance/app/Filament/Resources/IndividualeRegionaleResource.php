<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Modules\Performance\Filament\Resources\IndividualeRegionaleResource\Pages\CreateIndividualeRegionale;
use Modules\Performance\Filament\Resources\IndividualeRegionaleResource\Pages\EditIndividualeRegionale;
use Modules\Performance\Filament\Resources\IndividualeRegionaleResource\Pages\FillOutTheForm;
use Modules\Performance\Filament\Resources\IndividualeRegionaleResource\Pages\ListIndividualeRegionales;
use Modules\Performance\Models\IndividualeRegionale;
use Modules\Ptv\Filament\Resources\SchedaResource\Pages\CompilaScheda;
use Override;

class IndividualeRegionaleResource extends IndividualeResource
{
    protected static ?string $model = IndividualeRegionale::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    #[Override]
    public static function getRelations(): array
    {
        return [
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListIndividualeRegionales::route('/'),
            'create' => CreateIndividualeRegionale::route('/create'),
            'edit' => EditIndividualeRegionale::route('/{record}/edit'),
            'fill_out_the_form' => FillOutTheForm::route('/{record}/fill'),
            'compila' => CompilaScheda::route('/{record}/compila'),
        ];
    }
}
