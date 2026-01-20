<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\CriteriEsclusione;

use Modules\Ptv\Models\Contracts\ProgressioneSchedaContract;
use Spatie\QueueableAction\QueueableAction;

class ListaPosiz
{
    use QueueableAction;

    public function execute(ProgressioneSchedaContract $scheda, string $value): string
    {
        // ✅ isset() invece di property_exists() - funziona per attributi magici Eloquent
        $posiz = isset($scheda->posiz) ? $scheda->posiz : null;
        if (\in_array($posiz, explode(',', $value), true)) {
            return 'no posiz';
        }

        return '';
    }
}
