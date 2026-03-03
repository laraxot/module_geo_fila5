<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

// ---- traits --
/**
 * Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoroIndennitaTipoDettaglioPivot.
 *
 * @property int $id
 * @property int|null $condizioni_lavoro_id
 * @property int|null $indennita_tipo_dettaglio_id
 * @property int|null $gg
 * @property string|null $note
 * @property-read CondizioniLavoro|null $condizioniLavoro
 * @property-read int|float $tot
 * @property-read int|float $tot_x_ptime
 * @property-read IndennitaTipoDettaglio|null $indennitaTipoDettaglio
 * @method static Builder|CondizioniLavoroIndennitaTipoDettaglioPivot newModelQuery()
 * @method static Builder|CondizioniLavoroIndennitaTipoDettaglioPivot newQuery()
 * @method static Builder|CondizioniLavoroIndennitaTipoDettaglioPivot query()
 * @method static Builder|CondizioniLavoroIndennitaTipoDettaglioPivot whereCondizioniLavoroId($value)
 * @method static Builder|CondizioniLavoroIndennitaTipoDettaglioPivot whereGg($value)
 * @method static Builder|CondizioniLavoroIndennitaTipoDettaglioPivot whereId($value)
 * @method static Builder|CondizioniLavoroIndennitaTipoDettaglioPivot whereIndennitaTipoDettaglioId($value)
 * @method static Builder|CondizioniLavoroIndennitaTipoDettaglioPivot whereNote($value)
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder<static>|CondizioniLavoroIndennitaTipoDettaglioPivot whereCreatedAt($value)
 * @method static Builder<static>|CondizioniLavoroIndennitaTipoDettaglioPivot whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CondizioniLavoroIndennitaTipoDettaglioPivot extends BasePivot
{
    protected $table = 'condizioni_lavoro_x_indennita_tipo_dettaglio';

    protected $fillable = ['condizioni_lavoro_id', 'indennita_tipo_dettaglio_id', 'gg', 'note'];

    // protected $dates=['created_at','updated_at'];

    // --- relationship ---
    public function condizioniLavoro(): HasOne
    {
        return $this->hasOne(CondizioniLavoro::class, 'id', 'condizioni_lavoro_id');
    }

    public function indennitaTipoDettaglio(): HasOne
    {
        return $this->hasOne(IndennitaTipoDettaglio::class, 'id', 'indennita_tipo_dettaglio_id');
    }

    // ---- mutators --
    public function getTotAttribute(mixed $value): int|float
    {
        $gg = $this->gg ?? 0;
        $euroGiorno = $this->indennitaTipoDettaglio->euro_giorno ?? 0;

        return (int) $gg * (float) $euroGiorno;
    }

    public function getTotXPtimeAttribute(mixed $value): int|float
    {
        $tot = $this->tot;
        $ptime = $this->condizioniLavoro->perc_p_time_daterange ?? 0;

        return (float) $tot * (float) $ptime;
    }
}
