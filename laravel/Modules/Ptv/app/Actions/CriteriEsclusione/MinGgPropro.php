<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\CriteriEsclusione;

use Illuminate\Support\Collection;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Override;

class MinGgPropro extends BaseCriterioEsclusione
{
    #[Override]
    public function execute(SchedaContract $scheda, string $value, Collection $criteriOption): string
    {
        $gg_cateco_fuori_sede = isset($scheda->gg_cateco_fuori_sede) ? $scheda->gg_cateco_fuori_sede : 0;
        $gg_cateco_in_sede = isset($scheda->gg_cateco_in_sede) ? $scheda->gg_cateco_in_sede : 0;
        $gg_cateco_fuori_sede_int = is_numeric($gg_cateco_fuori_sede) ? intval((string) $gg_cateco_fuori_sede) : 0;
        $gg_cateco_in_sede_int = is_numeric($gg_cateco_in_sede) ? intval((string) $gg_cateco_in_sede) : 0;
        $tot = $gg_cateco_fuori_sede_int + $gg_cateco_in_sede_int;
        $valueInt = is_numeric($value) ? intval($value) : 0;

        if ($tot < $valueInt) {
            return 'no min_gg_propro [my:'.(string) $tot.'][min:'.(string) $value.']';
        }

        return '';
    }
}
