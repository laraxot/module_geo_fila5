<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Modules\Sigma\Models\ViewMatrBadge.
 *
 * @method static Builder|ViewMatrBadge newModelQuery()
 * @method static Builder|ViewMatrBadge newQuery()
 * @method static Builder|ViewMatrBadge query()
 * @property-read \Modules\Ptv\Models\Profile|null $creator
 * @property-read \Modules\Ptv\Models\Profile|null $deleter
 * @property-read \Modules\Ptv\Models\Profile|null $updater
 * @method static \Modules\Sigma\Database\Factories\ViewMatrBadgeFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class ViewMatrBadge extends BaseModel
{
    protected $table = 'viewmatrbadge';
}
