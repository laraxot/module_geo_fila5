<?php

declare(strict_types=1);

namespace Modules\Ptv\Models\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Sigma\Models\Asz00k1;

/**
 * Contract per le schede di valutazione del personale nelle progressioni temporali variabili.
 * Definisce le proprietà essenziali per la gestione dei criteri di esclusione e valutazione.
 *
 * @phpstan-require-extends Model
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
 * @property int|null $propro Codice propro
 * @property mixed $last_data_assunz Data ultima assunzione
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\Ptv\Models\CriteriEsclusione>|null $criteriEsclusione
 * @property float|null $perf_ind_media Media performance individuale
 * @property int|null $excellences_count_last_3_years Conteggio eccellenze ultimi 3 anni
 *
 * @method HasMany<Asz00k1, Model> asz() Relazione ASZ — implementata in BaseScheda
 * @method MorphMany myLogs() Log invio mail — trait HasMyLogs su BaseScheda
 *
 * @mixin \Eloquent
 */
interface SchedaContract
{
}
