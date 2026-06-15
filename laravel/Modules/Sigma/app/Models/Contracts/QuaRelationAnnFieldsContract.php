<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Contracts;

/**
 * Contratto per modelli che hanno relazioni verso Qua/Rep/Sto con filtro anno vuoto.
 *
 * Quando un modello ha relazioni hasMany verso tabelle storiche con campo anno
 * (quaann, repann, stann, ...), questo contratto fornisce il metodo per
 * ottenere il valore da filtrare (tipicamente stringa vuota '').
 *
 * @see \Modules\Sigma\Models\Traits\Relationships\EnteMatrRelationship
 */
interface SigmaQuaRelationAnnFields
{
    /**
     * Valore del campo anno da usare nei filtri whereRaw.
     *
     * @return literal-string
     */
    public function quaRelationAnnValue(): string;
}