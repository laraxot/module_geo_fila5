<?php

declare(strict_types=1);

namespace Modules\Ptv\Models\Contracts;

/**
 * Contract per le schede di valutazione del personale nelle progressioni temporali variabili.
 * Definisce le proprietà essenziali per la gestione dei criteri di esclusione e valutazione.
 *
 * @property int $ente Codice ente
 * @property int $matr Matricola dipendente
 * @property int|null $ha_diritto Flag se ha diritto alla progressione (0/1)
 * @property string|null $motivo Motivo di esclusione se non ha diritto
 * @property int|null $disci1 Codice disciplinare 1
 * @property int|null $posfun Posizione funzionale
 * @property string|null $cognome Cognome dipendente
 * @property string|null $nome Nome dipendente
 * @property int|null $anno Anno di riferimento
 * @property string|null $categoria_eco Categoria economica
 * @property int|null $posiz Posizione
 * @property int|null $stabi Stabilimento
 * @property int|null $repar Reparto
 * @property string|null $email Email del dipendente
 * @property object|null $valutatore Relazione con il valutatore
 */
interface SchedaContract
{
    // Methods inherited from Eloquent Model:
    // - save(array $options = [])
    // - setHaDirittoAttribute(?int $value): void
    // - setMotivoAttribute(?string $value): void
}
