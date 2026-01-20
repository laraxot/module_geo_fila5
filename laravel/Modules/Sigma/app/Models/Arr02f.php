<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Modules\Sigma\Models\Arr02f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $r2matr
 * @property string|null $r2pro
 * @property string|null $r2limi
 * @property string|null $r2ecez
 *
 * @method static Builder|Arr02f newModelQuery()
 * @method static Builder|Arr02f newQuery()
 * @method static Builder|Arr02f query()
 * @method static Builder|Arr02f whereEnte($value)
 * @method static Builder|Arr02f whereId($value)
 * @method static Builder|Arr02f whereR2ecez($value)
 * @method static Builder|Arr02f whereR2limi($value)
 * @method static Builder|Arr02f whereR2matr($value)
 * @method static Builder|Arr02f whereR2pro($value)
 *
 * @mixin \Eloquent
 */
class Arr02f extends BaseModel
{
    protected $table = 'arr02f';
}
