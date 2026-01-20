<?php

declare(strict_types=1);

namespace Modules\Mensa\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Mensa\Database\Factories\CirFactory;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Mensa\Models\Cir.
 *
 * @method static CirFactory factory($count = null, $state = [])
 * @method static Builder|Cir newModelQuery()
 * @method static Builder|Cir newQuery()
 * @method static Builder|Cir query()
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 *
 * @mixin \Eloquent
 */
class Cir extends BaseModel
{
    protected $fillable = ['id'];
}
