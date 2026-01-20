<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\CriteriEsclusione;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Override;

class ListaProproPosfun extends BaseCriterioEsclusione
{
    #[Override]
    public function execute(Model $scheda, string $value, Collection $criteriOption): string
    {
        // PHPStan Level 10: isset() invece di property_exists() per Eloquent magic properties
        $propro = isset($scheda->propro) ? $scheda->getAttribute('propro') : '';
        $posfun = isset($scheda->posfun) ? $scheda->getAttribute('posfun') : '';

        $propro = is_string($propro) || is_numeric($propro) ? (string) $propro : '';
        $posfun = is_string($posfun) || is_numeric($posfun) ? (string) $posfun : '';

        $propro_posfun = $propro.'-'.$posfun;
        if (\in_array($propro_posfun, explode(',', (string) $value), false)) {
            return 'no propro posfun [my:'.$propro_posfun.']';
        }

        return '';
    }
}
