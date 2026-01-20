<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Modules\Sigma\Models\Varp00l2.
 *
 * @property int $id
 * @property string|null $enteap
 * @property string|null $proann
 * @property string|null $promat
 * @property string|null $prodat
 * @property string|null $progiu
 * @property string|null $prolet
 * @property string|null $proora
 *
 * @method static Builder|Varp00l2 newModelQuery()
 * @method static Builder|Varp00l2 newQuery()
 * @method static Builder|Varp00l2 query()
 * @method static Builder|Varp00l2 whereEnteap($value)
 * @method static Builder|Varp00l2 whereId($value)
 * @method static Builder|Varp00l2 whereProann($value)
 * @method static Builder|Varp00l2 whereProdat($value)
 * @method static Builder|Varp00l2 whereProgiu($value)
 * @method static Builder|Varp00l2 whereProlet($value)
 * @method static Builder|Varp00l2 wherePromat($value)
 * @method static Builder|Varp00l2 whereProora($value)
 *
 * @mixin \Eloquent
 */
class Varp00l2 extends BaseModel
{
    protected $table = 'varp00l2';
}
