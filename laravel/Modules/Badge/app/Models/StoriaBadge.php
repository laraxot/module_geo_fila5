<?php

declare(strict_types=1);

namespace Modules\Badge\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Badge\Database\Factories\StoriaBadgeFactory;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Badge\Models\StoriaBadge.
 *
 * @method static StoriaBadgeFactory factory($count = null, $state = [])
 * @method static Builder|StoriaBadge newModelQuery()
 * @method static Builder|StoriaBadge newQuery()
 * @method static Builder|StoriaBadge query()
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @property int $id
 * @property int|null $ente
 * @property int|null $matricola
 * @property string|null $cognome
 * @property string|null $nome
 * @property string|null $badge
 * @property string|null $data
 * @property string|null $note
 * @property int|null $last_stato
 * @property string|null $handle
 * @property string|null $datemod
 * @property-read Profile|null $deleter
 * @method static Builder<static>|StoriaBadge whereBadge($value)
 * @method static Builder<static>|StoriaBadge whereCognome($value)
 * @method static Builder<static>|StoriaBadge whereData($value)
 * @method static Builder<static>|StoriaBadge whereDatemod($value)
 * @method static Builder<static>|StoriaBadge whereEnte($value)
 * @method static Builder<static>|StoriaBadge whereHandle($value)
 * @method static Builder<static>|StoriaBadge whereId($value)
 * @method static Builder<static>|StoriaBadge whereLastStato($value)
 * @method static Builder<static>|StoriaBadge whereMatricola($value)
 * @method static Builder<static>|StoriaBadge whereNome($value)
 * @method static Builder<static>|StoriaBadge whereNote($value)
 * @mixin \Eloquent
 */
class StoriaBadge extends BaseModel
{
    protected $fillable = ['id', 'ente', 'matricola', 'cognome', 'nome', 'badge', 'data', 'note', 'last_stato', 'handle', 'datemod'];
}
