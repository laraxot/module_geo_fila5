<?php

declare(strict_types=1);

namespace Modules\Badge\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Badge\Database\Factories\MensaFactory;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Badge\Models\Mensa.
 *
 * @method static MensaFactory factory($count = null, $state = [])
 * @method static Builder|Mensa newModelQuery()
 * @method static Builder|Mensa newQuery()
 * @method static Builder|Mensa query()
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @property int $id
 * @property int|null $ente
 * @property int|null $matr
 * @property string|null $conome
 * @property string|null $nome
 * @property int|null $propro
 * @property int|null $posfun
 * @property int|null $stabi
 * @property int|null $repar
 * @property int|null $data
 * @property int|null $ora
 * @property int|null $tipo
 * @property string|null $note
 * @property-read Profile|null $deleter
 * @method static Builder<static>|Mensa whereConome($value)
 * @method static Builder<static>|Mensa whereData($value)
 * @method static Builder<static>|Mensa whereEnte($value)
 * @method static Builder<static>|Mensa whereId($value)
 * @method static Builder<static>|Mensa whereMatr($value)
 * @method static Builder<static>|Mensa whereNome($value)
 * @method static Builder<static>|Mensa whereNote($value)
 * @method static Builder<static>|Mensa whereOra($value)
 * @method static Builder<static>|Mensa wherePosfun($value)
 * @method static Builder<static>|Mensa wherePropro($value)
 * @method static Builder<static>|Mensa whereRepar($value)
 * @method static Builder<static>|Mensa whereStabi($value)
 * @method static Builder<static>|Mensa whereTipo($value)
 * @mixin \Eloquent
 */
class Mensa extends BaseModel
{
    protected $fillable = ['id', 'ente', 'matr', 'conome', 'nome', 'propro', 'posfun', 'stabi', 'repar', 'data', 'ora', 'tipo', 'note'];
}
