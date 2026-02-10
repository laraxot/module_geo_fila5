<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources;

use Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoroAdm;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class CondizioniLavoroAdmResource extends XotBaseResource
{
    protected static ?string $model = CondizioniLavoroAdm::class;

    #[Override]
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [

        ];
    }
}
