<?php

declare(strict_types=1);

namespace Modules\MobilitaVolontaria\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\MobilitaVolontaria\Database\Factories\BandiFactory;

/**
 * Modules\MobilitaVolontaria\Models\Bandi.
 *
 * @method static BandiFactory factory($count = null, $state = [])
 * @method static Builder|Bandi newModelQuery()
 * @method static Builder|Bandi newQuery()
 * @method static Builder|Bandi query()
 *
 * @mixin \Eloquent
 */
class Bandi extends BaseModel
{
    protected $fillable = ['id', 'comune'];
}
