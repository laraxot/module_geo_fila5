<?php

declare(strict_types=1);

namespace Modules\Mensa\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Mensa\Database\Factories\MensaManualiFactory;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Mensa\Models\MensaManuali.
 *
 * @method static MensaManualiFactory factory($count = null, $state = [])
 * @method static Builder|MensaManuali newModelQuery()
 * @method static Builder|MensaManuali newQuery()
 * @method static Builder|MensaManuali query()
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @property string $id
 * @property int|null $ente
 * @property int|null $matr
 * @property string|null $cognome
 * @property string|null $nome
 * @property string|null $datat
 * @property-read Profile|null $deleter
 * @method static Builder<static>|MensaManuali whereCognome($value)
 * @method static Builder<static>|MensaManuali whereDatat($value)
 * @method static Builder<static>|MensaManuali whereEnte($value)
 * @method static Builder<static>|MensaManuali whereId($value)
 * @method static Builder<static>|MensaManuali whereMatr($value)
 * @method static Builder<static>|MensaManuali whereNome($value)
 * @mixin \Eloquent
 */
class MensaManuali extends BaseModel
{
    protected $fillable = ['id', 'ente', 'matr', 'cognome', 'nome', 'datat'];
}
