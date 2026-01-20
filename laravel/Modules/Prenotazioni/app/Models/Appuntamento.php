<?php

declare(strict_types=1);

namespace Modules\Prenotazioni\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Prenotazioni\Database\Factories\AppuntamentoFactory;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Prenotazioni\Models\Appuntamento.
 *
 * @property int $id
 * @property int|null $ente
 * @property int|null $matr
 * @property string|null $giorno
 * @property int|null $id_tipo
 * @property string|null $note
 * @property string|null $handle
 * @property int|null $last_stato
 * @property string|null $datemod
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_by
 * @property string|null $deleted_at
 * @property string|null $created_by
 * @property string|null $updated_by
 *
 * @method static AppuntamentoFactory factory($count = null, $state = [])
 * @method static Builder|Appuntamento newModelQuery()
 * @method static Builder|Appuntamento newQuery()
 * @method static Builder|Appuntamento query()
 * @method static Builder|Appuntamento whereCreatedAt($value)
 * @method static Builder|Appuntamento whereCreatedBy($value)
 * @method static Builder|Appuntamento whereDatemod($value)
 * @method static Builder|Appuntamento whereDeletedAt($value)
 * @method static Builder|Appuntamento whereDeletedBy($value)
 * @method static Builder|Appuntamento whereEnte($value)
 * @method static Builder|Appuntamento whereGiorno($value)
 * @method static Builder|Appuntamento whereHandle($value)
 * @method static Builder|Appuntamento whereId($value)
 * @method static Builder|Appuntamento whereIdTipo($value)
 * @method static Builder|Appuntamento whereLastStato($value)
 * @method static Builder|Appuntamento whereMatr($value)
 * @method static Builder|Appuntamento whereNote($value)
 * @method static Builder|Appuntamento whereUpdatedAt($value)
 * @method static Builder|Appuntamento whereUpdatedBy($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 *
 * @mixin \Eloquent
 */
class Appuntamento extends BaseModel
{
    protected $fillable = ['id', 'ente', 'matr', 'giorno', 'id_tipo', 'note', 'handle', 'last_stato', 'datemod', 'created_at', 'updated_at', 'deleted_by', 'deleted_at', 'created_by', 'updated_by'];
}
