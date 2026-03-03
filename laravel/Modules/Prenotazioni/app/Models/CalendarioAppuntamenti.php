<?php

declare(strict_types=1);

namespace Modules\Prenotazioni\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Prenotazioni\Database\Factories\CalendarioAppuntamentiFactory;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Prenotazioni\Models\CalendarioAppuntamenti.
 *
 * @property int $id
 * @property int|null $ente
 * @property int|null $matr
 * @property string|null $giorno_start
 * @property string|null $giorno_end
 * @property int|null $id_tipo
 * @property string|null $note
 * @property int|null $max_utenti
 * @property string|null $handle
 * @property int|null $last_stato
 * @property string|null $datemod
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_by
 * @property string|null $deleted_at
 * @method static CalendarioAppuntamentiFactory factory($count = null, $state = [])
 * @method static Builder|CalendarioAppuntamenti newModelQuery()
 * @method static Builder|CalendarioAppuntamenti newQuery()
 * @method static Builder|CalendarioAppuntamenti query()
 * @method static Builder|CalendarioAppuntamenti whereCreatedAt($value)
 * @method static Builder|CalendarioAppuntamenti whereCreatedBy($value)
 * @method static Builder|CalendarioAppuntamenti whereDatemod($value)
 * @method static Builder|CalendarioAppuntamenti whereDeletedAt($value)
 * @method static Builder|CalendarioAppuntamenti whereDeletedBy($value)
 * @method static Builder|CalendarioAppuntamenti whereEnte($value)
 * @method static Builder|CalendarioAppuntamenti whereGiornoEnd($value)
 * @method static Builder|CalendarioAppuntamenti whereGiornoStart($value)
 * @method static Builder|CalendarioAppuntamenti whereHandle($value)
 * @method static Builder|CalendarioAppuntamenti whereId($value)
 * @method static Builder|CalendarioAppuntamenti whereIdTipo($value)
 * @method static Builder|CalendarioAppuntamenti whereLastStato($value)
 * @method static Builder|CalendarioAppuntamenti whereMatr($value)
 * @method static Builder|CalendarioAppuntamenti whereMaxUtenti($value)
 * @method static Builder|CalendarioAppuntamenti whereNote($value)
 * @method static Builder|CalendarioAppuntamenti whereUpdatedAt($value)
 * @method static Builder|CalendarioAppuntamenti whereUpdatedBy($value)
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @property-read Profile|null $deleter
 * @mixin \Eloquent
 */
class CalendarioAppuntamenti extends BaseModel
{
    protected $fillable = ['id', 'ente', 'matr', 'giorno_start', 'giorno_end', 'id_tipo', 'note', 'max_utenti', 'handle', 'last_stato', 'datemod', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_by', 'deleted_at'];
}
