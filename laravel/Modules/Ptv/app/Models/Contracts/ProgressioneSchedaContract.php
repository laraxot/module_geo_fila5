<?php

declare(strict_types=1);

namespace Modules\Ptv\Models\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Sigma\Models\Asz00k1;

/**
 * Contract specifico per le schede utilizzate nelle progressioni temporali variabili.
 * Estende SchedaContract aggiungendo i metodi necessari per la gestione dei criteri di esclusione.
 *
 * @property int|null $ha_diritto Flag se ha diritto alla progressione (0/1)
 * @property string|null $motivo Motivo di esclusione se non ha diritto
 * @property int|null $disci1 Codice disciplinare 1
 * @property int|null $posfun Posizione funzionale
 * @property int|null $posiz Posizione
 * @property int|null $propro Proprieta/appartenenza
 * @property int|null $matr Matricola dipendente per debug
 * @property mixed $last_data_assunz Data ultima assunzione (per criterio DateMinAssunz)
 *
 * @phpstan-require-extends Model
 *
 * @mixin \Eloquent
 */
interface ProgressioneSchedaContract extends SchedaContract
{
    /**
     * Salva il modello nel database.
     *
     * @return bool
     */
    public function save(array $options = []);

    /**
     * Accesso magic alle proprietà del modello (eredita da Eloquent).
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key);

    /**
     * Assegnazione magic alle proprietà del modello (eredita da Eloquent).
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function __set($key, $value);

    /**
     * Relazione con le assenze del dipendente.
     * Restituisce una relazione con metodi di scope per filtri temporali.
     *
     * @return HasMany<Asz00k1, $this>
     */
    public function asz(): HasMany;
}
