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
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 *
 * @mixin \Eloquent
 */
class StoriaBadge extends BaseModel
{
    protected $fillable = ['id', 'ente', 'matricola', 'cognome', 'nome', 'badge', 'data', 'note', 'last_stato', 'handle', 'datemod'];
}
