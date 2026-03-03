<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Modules\Sigma\Models\QuaAnaTq.
 *
 * @method static Builder|QuaAnaTq newModelQuery()
 * @method static Builder|QuaAnaTq newQuery()
 * @method static Builder|QuaAnaTq query()
 * @property-read \Modules\Ptv\Models\Profile|null $creator
 * @property-read \Modules\Ptv\Models\Profile|null $deleter
 * @property-read \Modules\Ptv\Models\Profile|null $updater
 * @method static \Modules\Sigma\Database\Factories\QuaAnaTqFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class QuaAnaTq extends BaseModel
{
    protected $table = 'quaanatq';
}
