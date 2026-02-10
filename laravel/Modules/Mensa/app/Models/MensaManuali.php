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
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 *
 * @mixin \Eloquent
 */
class MensaManuali extends BaseModel
{
    protected $fillable = ['id', 'ente', 'matr', 'cognome', 'nome', 'datat'];
}
