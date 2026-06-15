<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\CriteriEsclusione;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

class Check
{
    use QueueableAction;

    /**
     * Verifica i criteri di esclusione per una scheda.
     *
     * @param  Model  $scheda  La scheda da verificare
     * @param  iterable<int, Model>  $criteriEsclusione  Criteri di esclusione (modello modulo-specifico)
     * @param  Collection  $criteriOption  Opzioni criteri (tipicamente pluck name => value_real)
     */
    public function execute(Model $scheda, iterable $criteriEsclusione, Collection $criteriOption): void
    {
        $motivi = [];
        foreach ($criteriEsclusione as $criterio) {
            if (! ($criterio instanceof Model)) {
                continue;
            }

            $criterioName = isset($criterio->name) && is_string($criterio->name) ? $criterio->name : '';
            if ($criterioName === '') {
                continue;
            }

            $action = '\Modules\Ptv\Actions\CriteriEsclusione\\'.Str::studly($criterioName);

            if (! class_exists($action)) {
                continue;
            }

            $actionInstance = app($action);
            if (! is_object($actionInstance) || ! method_exists($actionInstance, 'execute')) {
                continue;
            }

            $criterioValue = isset($criterio->value) ? $criterio->value : null;
            $motivo = $actionInstance->execute($scheda, $criterioValue, $criteriOption);

            if (is_string($motivo) && $motivo !== '') {
                $motivi[] = $motivo;
            }
        }
        $ha_diritto = true;
        $motivo = '';
        if (count($motivi) > 0) {
            $ha_diritto = false;
            $motivo = implode(',', $motivi);
        }
        $scheda->update([
            'ha_diritto' => $ha_diritto,
            'motivo' => $motivo,
        ]);
    }
}
