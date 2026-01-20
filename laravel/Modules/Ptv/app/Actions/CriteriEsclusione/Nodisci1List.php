<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\CriteriEsclusione;

use Modules\Ptv\Models\Contracts\ProgressioneSchedaContract;
use Spatie\QueueableAction\QueueableAction;

class Nodisci1List
{
    use QueueableAction;

    public function execute(ProgressioneSchedaContract $scheda, string $value): string
    {
        if (\in_array($scheda->disci1, explode(',', $value), false)) {
            return 'no disci';
        }

        return '';
    }
}
