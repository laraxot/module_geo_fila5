<?php

declare(strict_types=1);

namespace Modules\Ptv\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface CheckCriterioEsclusioneContract
{
    public function execute(Model $scheda, string $value, Collection $criteriOption): string;
}
