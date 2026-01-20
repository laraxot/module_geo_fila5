<?php

/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

declare(strict_types=1);

namespace Modules\Incentivi\Actions;

use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Modules\Incentivi\Models\CapitalPercentage;
use Spatie\QueueableAction\QueueableAction;

class SpareImportoTotaleAction
{
    use QueueableAction;

    public function execute(float $amount, Get $get, Set $set): void
    {
        $tipoValue = (object) $get('tipo');
        $tipoIncentivo = is_string($tipoValue->value) ? $tipoValue->value : (string) $tipoValue->value;

        $percentage = CapitalPercentage::where('tipologia', $tipoIncentivo)
            ->where('da', '<=', $amount)
            ->where('a', '>=', $amount)
            ->first();

        if ($percentage === null) {
            $set('percentuale_fondo', 0);
            $set('importo_effettivo_fondo', 0);
            $set('componente_incentivante', 0);
            $set('componente_innovazione', 0);

            return;
        }

        $valore = is_numeric($percentage->valore) ? (float) $percentage->valore : 0.0;
        $set('percentuale_fondo', $valore);
        $set('importo_effettivo_fondo', (float) ($valore * $amount / 100));

        $fondoAmount = $get('importo_effettivo_fondo');
        $fondoAmountFloat = is_numeric($fondoAmount) ? (float) $fondoAmount : 0.0;
        $set('componente_incentivante', (float) (0.80 * $importoEffettivoFondoFloat));
        $set('componente_innovazione', (float) (0.20 * $importoEffettivoFondoFloat));
    }
}
