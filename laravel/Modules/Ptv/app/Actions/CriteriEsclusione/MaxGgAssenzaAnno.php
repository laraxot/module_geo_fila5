<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\CriteriEsclusione;

use Modules\Ptv\Models\Contracts\ProgressioneSchedaContract;
use Spatie\QueueableAction\QueueableAction;

class MaxGgAssenzaAnno
{
    use QueueableAction;

    public function execute(ProgressioneSchedaContract $scheda, string $value): string
    {
        return '';
    }
}
