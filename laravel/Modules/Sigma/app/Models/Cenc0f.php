<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Modules\Sigma\Models\Cenc0f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $ccsta
 * @property string|null $ccrep
 * @property string|null $ccsre
 * @property string|null $ccdes
 * @property string|null $ccann
 *
 * @method static Builder|Cenc0f newModelQuery()
 * @method static Builder|Cenc0f newQuery()
 * @method static Builder|Cenc0f query()
 * @method static Builder|Cenc0f whereCcann($value)
 * @method static Builder|Cenc0f whereCcdes($value)
 * @method static Builder|Cenc0f whereCcrep($value)
 * @method static Builder|Cenc0f whereCcsre($value)
 * @method static Builder|Cenc0f whereCcsta($value)
 * @method static Builder|Cenc0f whereEnte($value)
 * @method static Builder|Cenc0f whereId($value)
 *
 * @mixin \Eloquent
 */
class Cenc0f extends BaseModel
{
    protected $table = 'cenc0f';
}
