<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\CriteriEsclusione;

use Illuminate\Support\Collection;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Spatie\QueueableAction\QueueableAction;

class MinGgPosiz1InSede
{
    use QueueableAction;

    public function execute(SchedaContract $scheda, string $value, Collection $criteriOption): string
    {
        $gg_posiz_1_in_sede = isset($scheda->gg_posiz_1_in_sede) ? $scheda->gg_posiz_1_in_sede : 0;
        $gg_posiz_1_in_sede_int = is_numeric($gg_posiz_1_in_sede) ? intval((string) $gg_posiz_1_in_sede) : 0;
        $valueInt = is_numeric($value) ? intval($value) : 0;
        if ($gg_posiz_1_in_sede_int < $valueInt) {
            $gg_posiz_1_in_sede_str = is_string($gg_posiz_1_in_sede) || is_numeric($gg_posiz_1_in_sede) ? (string) $gg_posiz_1_in_sede : '0';

            return 'no min_gg_posiz_1_in_sede [my:'.$gg_posiz_1_in_sede_str.'][min:'.(string) $value.']';
        }

        return '';
    }
}
