<?php

declare(strict_types=1);

namespace Modules\Badge\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Badge\Database\Factories\MylogFactory;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Badge\Models\Mylog.
 *
 * @method static MylogFactory factory($count = null, $state = [])
 * @method static Builder|Mylog newModelQuery()
 * @method static Builder|Mylog newQuery()
 * @method static Builder|Mylog query()
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @property-read Profile|null $deleter
 * @mixin \Eloquent
 */
class Mylog extends BaseModel
{
    protected $fillable = ['id', 'id_tbl', 'tbl', 'id_approvaz', 'note', 'handle'];
}
