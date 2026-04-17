<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\OrganizzativaResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Modules\Performance\Filament\Resources\OrganizzativaResource;
use Modules\Progressioni\Filament\Resources\ProgressioniResource\RelationManagers;

class ViewOrganizzativa extends ViewRecord
{
    public static string $resource = OrganizzativaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    /* va in progressioniResource
    public function getRelations():array {

        return [
            RelationManagers\Qua00fRelationManager::class,
        ];
    }
    */
}
