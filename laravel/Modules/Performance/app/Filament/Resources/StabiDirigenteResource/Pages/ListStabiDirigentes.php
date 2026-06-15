<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\StabiDirigenteResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\TextInput;
use Modules\Performance\Filament\Resources\StabiDirigenteResource;
use Modules\Performance\Models\Individuale;
use Modules\Performance\Models\StabiDirigente;
use Modules\Ptv\Filament\Actions\Header\ImportValutatoriAction;
use Modules\Ptv\Filament\Resources\StabiDirigenteResource\Pages\ListStabiDirigentes as PtvListStabiDirigentes;
use Override;

class ListStabiDirigentes extends PtvListStabiDirigentes
{
    protected static string $resource = StabiDirigenteResource::class;


     /**
     * @return array<string, Action|ActionGroup>
     */
    #[Override]
    protected function getHeaderActions(): array
    {
        $actions = parent::getHeaderActions();
        $actions['import_valutatori'] = ImportValutatoriAction::make('import_valutatori')
            ->addFields([
                'anno' => TextInput::make('anno'),
            ])->setStabiDirigenteModel(StabiDirigente::class)
            ->setSchedaModel(Individuale::class);

        return $actions;
    }
}
