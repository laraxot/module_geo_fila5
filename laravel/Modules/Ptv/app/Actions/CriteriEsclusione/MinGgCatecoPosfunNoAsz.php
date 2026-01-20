<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\CriteriEsclusione;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Override;

class MinGgCatecoPosfunNoAsz extends BaseCriterioEsclusione
{
    #[Override]
    public function execute(Model $scheda, string $value, Collection $criteriOption): string
    {
        $gg_cateco_posfun_no_asz = isset($scheda->gg_cateco_posfun_no_asz) ? $scheda->gg_cateco_posfun_no_asz : 0;
        $gg_cateco_posfun_no_asz = is_numeric($gg_cateco_posfun_no_asz) ? (int) $gg_cateco_posfun_no_asz : 0;
        $valueInt = is_numeric($value) ? intval($value) : 0;
        if ($gg_cateco_posfun_no_asz < $valueInt) {
            return ' no min_gg_cateco_posfun_no_asz[my:'.(string) $gg_cateco_posfun_no_asz.'][min:'.(string) $value.']';
        }

        return '';
    }
}
