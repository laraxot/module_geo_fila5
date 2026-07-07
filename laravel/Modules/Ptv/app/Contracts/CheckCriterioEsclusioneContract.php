<?php

declare(strict_types=1);

namespace Modules\Ptv\Contracts;

use Illuminate\Support\Collection;
use Modules\Ptv\Models\Contracts\SchedaContract;

/** @template TKey of array-key @template TValue */
interface CheckCriterioEsclusioneContract
{
    /**
     * @param  Collection<TKey, TValue>  $criteriOption
     */
    public function execute(SchedaContract $scheda, string $value, Collection $criteriOption): string;
}
