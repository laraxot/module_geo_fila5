<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\CriteriEsclusione;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Override;

class MinGgCatecoPosfunLavoratiInSede extends BaseCriterioEsclusione
{
    #[Override]
    public function execute(Model $scheda, string $value, Collection $criteriOption): string
    {
        // da fare

        return '';
    }
}
