<?php

declare(strict_types=1);

namespace Modules\Badge\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Badge\Database\Factories\HalleyFactory;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Badge\Models\Halley.
 *
 * @method static HalleyFactory factory($count = null, $state = [])
 * @method static Builder|Halley newModelQuery()
 * @method static Builder|Halley newQuery()
 * @method static Builder|Halley query()
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 *
 * @mixin \Eloquent
 */
class Halley extends BaseModel
{
    protected $fillable = ['id', 'data', 'uscita', 'matr', 'ora'];
}
