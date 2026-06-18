<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\CriteriEsclusione;

use Illuminate\Support\Collection;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Override;

class MinGgCatecoPosfunLavoratiInSede extends BaseCriterioEsclusione
{
    #[Override]
    public function execute(SchedaContract $scheda, string $value, Collection $criteriOption): string
    {
        // da fare

        return '';
    }
}
