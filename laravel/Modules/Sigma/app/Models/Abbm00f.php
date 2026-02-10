<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Modules\Sigma\Models\Abbm00f.
 *
 * @property int $id
 * @property int $enteap
 * @property int $ramatr
 * @property int $raanno
 * @property int $ramese
 * @property int $raminu
 *
 * @method static Builder|Abbm00f newModelQuery()
 * @method static Builder|Abbm00f newQuery()
 * @method static Builder|Abbm00f query()
 * @method static Builder|Abbm00f whereEnteap($value)
 * @method static Builder|Abbm00f whereId($value)
 * @method static Builder|Abbm00f whereRaanno($value)
 * @method static Builder|Abbm00f whereRamatr($value)
 * @method static Builder|Abbm00f whereRamese($value)
 * @method static Builder|Abbm00f whereRaminu($value)
 *
 * @mixin \Eloquent
 */
class Abbm00f extends BaseModel
{
    protected $table = 'abbm00f';
}
