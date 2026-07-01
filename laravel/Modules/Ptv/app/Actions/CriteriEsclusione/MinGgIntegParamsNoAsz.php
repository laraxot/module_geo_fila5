<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\CriteriEsclusione;

use Illuminate\Support\Collection;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Modules\Sigma\Models\Traits\Helpers\SchedaHelper;
use Override;

/**
 * Giorni minimi da parametri integrativi al netto delle assenze (gg_esperienza_no_asz).
 *
 * @see SchedaHelper::getGgEsperienzaNoAsz()
 */
class MinGgIntegParamsNoAsz extends BaseCriterioEsclusione
{
    #[Override]
    public function execute(SchedaContract $scheda, string $value, Collection $criteriOption): string
    {
        $ggEsperienzaNoAsz = isset($scheda->gg_esperienza_no_asz) ? $scheda->gg_esperienza_no_asz : 0;
        $ggEsperienzaNoAsz = is_numeric($ggEsperienzaNoAsz) ? (int) $ggEsperienzaNoAsz : 0;
        $valueInt = is_numeric($value) ? (int) $value : 0;

        if ($ggEsperienzaNoAsz < $valueInt) {
            return 'no min_gg_integ_params_no_asz [my:'.(string) $ggEsperienzaNoAsz.'][min:'.(string) $value.']';
        }

        return '';
    }
}
