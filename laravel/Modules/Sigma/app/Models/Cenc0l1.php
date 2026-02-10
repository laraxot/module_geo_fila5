<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Modules\Sigma\Models\Cenc0l1.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $ccsta
 * @property string|null $ccrep
 * @property string|null $ccsre
 * @property string|null $ccdes
 * @property string|null $ccann
 *
 * @method static Builder|Cenc0l1 newModelQuery()
 * @method static Builder|Cenc0l1 newQuery()
 * @method static Builder|Cenc0l1 query()
 * @method static Builder|Cenc0l1 whereCcann($value)
 * @method static Builder|Cenc0l1 whereCcdes($value)
 * @method static Builder|Cenc0l1 whereCcrep($value)
 * @method static Builder|Cenc0l1 whereCcsre($value)
 * @method static Builder|Cenc0l1 whereCcsta($value)
 * @method static Builder|Cenc0l1 whereEnte($value)
 * @method static Builder|Cenc0l1 whereId($value)
 *
 * @mixin \Eloquent
 */
class Cenc0l1 extends BaseModel
{
    protected $table = 'cenc0l1';
}
