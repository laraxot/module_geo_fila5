<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Modules\Sigma\Models\Ced08l1.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $scont
 * @property string|null $smatr
 * @property string|null $sannli
 * @property string|null $aarif
 * @property string|null $svocfi
 * @property string|null $totale
 * @property string|null $impoeu
 * @property string|null $orestr
 * @property string|null $congua
 * @property string|null $congeu
 *
 * @method static Builder|Ced08l1 newModelQuery()
 * @method static Builder|Ced08l1 newQuery()
 * @method static Builder|Ced08l1 query()
 * @method static Builder|Ced08l1 whereAarif($value)
 * @method static Builder|Ced08l1 whereCongeu($value)
 * @method static Builder|Ced08l1 whereCongua($value)
 * @method static Builder|Ced08l1 whereEnte($value)
 * @method static Builder|Ced08l1 whereId($value)
 * @method static Builder|Ced08l1 whereImpoeu($value)
 * @method static Builder|Ced08l1 whereOrestr($value)
 * @method static Builder|Ced08l1 whereSannli($value)
 * @method static Builder|Ced08l1 whereScont($value)
 * @method static Builder|Ced08l1 whereSmatr($value)
 * @method static Builder|Ced08l1 whereSvocfi($value)
 * @method static Builder|Ced08l1 whereTotale($value)
 *
 * @mixin \Eloquent
 */
class Ced08l1 extends BaseModel
{
    protected $table = 'ced08l1';
}
