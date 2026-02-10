<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Modules\Sigma\Models\Province.
 *
 * @property int $id
 * @property string|null $codpro
 * @property string|null $codreg
 * @property string|null $prodes
 * @method static Builder|Province newModelQuery()
 * @method static Builder|Province newQuery()
 * @method static Builder|Province query()
 * @method static Builder|Province whereCodpro($value)
 * @method static Builder|Province whereCodreg($value)
 * @method static Builder|Province whereId($value)
 * @method static Builder|Province whereProdes($value)
 * @property-read \Modules\Ptv\Models\Profile|null $creator
 * @property-read \Modules\Ptv\Models\Profile|null $deleter
 * @property-read \Modules\Ptv\Models\Profile|null $updater
 * @method static \Modules\Sigma\Database\Factories\ProvinceFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class Province extends BaseModel
{
    protected $table = 'province';
}
