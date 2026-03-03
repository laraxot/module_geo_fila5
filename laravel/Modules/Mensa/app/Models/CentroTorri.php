<?php

declare(strict_types=1);

namespace Modules\Mensa\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Mensa\Database\Factories\CentroTorriFactory;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Mensa\Models\CentroTorri.
 *
 * @method static CentroTorriFactory factory($count = null, $state = [])
 * @method static Builder|CentroTorri newModelQuery()
 * @method static Builder|CentroTorri newQuery()
 * @method static Builder|CentroTorri query()
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @property string $id
 * @property string|null $matricola
 * @property string|null $cognome
 * @property string|null $nome
 * @property string|null $numero_di_badge
 * @property string|null $badge_intero
 * @property string|null $field
 * @property string|null $field1
 * @property string|null $field11
 * @property-read Profile|null $deleter
 * @method static Builder<static>|CentroTorri whereBadgeIntero($value)
 * @method static Builder<static>|CentroTorri whereCognome($value)
 * @method static Builder<static>|CentroTorri whereField($value)
 * @method static Builder<static>|CentroTorri whereField1($value)
 * @method static Builder<static>|CentroTorri whereField11($value)
 * @method static Builder<static>|CentroTorri whereId($value)
 * @method static Builder<static>|CentroTorri whereMatricola($value)
 * @method static Builder<static>|CentroTorri whereNome($value)
 * @method static Builder<static>|CentroTorri whereNumeroDiBadge($value)
 * @mixin \Eloquent
 */
class CentroTorri extends BaseModel
{
    protected $fillable = ['id', 'matricola', 'cognome', 'nome', 'numero_di_badge', 'badge_intero', 'field', 'field1', 'field11'];
}
