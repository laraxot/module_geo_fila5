<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Modules\Sigma\Models\Jmenu01l.
 *
 * @property int $id
 * @property string|null $flanab
 * @property string|null $cdmnab
 * @property string|null $dsmnab
 * @property string|null $sinfab
 * @property string|null $mnpgab
 * @property string|null $nmlhab
 * @property string|null $nmfhab
 * @property string|null $nmmhab
 * @property string|null $tpohab
 *
 * @method static Builder|Jmenu01l newModelQuery()
 * @method static Builder|Jmenu01l newQuery()
 * @method static Builder|Jmenu01l query()
 * @method static Builder|Jmenu01l whereCdmnab($value)
 * @method static Builder|Jmenu01l whereDsmnab($value)
 * @method static Builder|Jmenu01l whereFlanab($value)
 * @method static Builder|Jmenu01l whereId($value)
 * @method static Builder|Jmenu01l whereMnpgab($value)
 * @method static Builder|Jmenu01l whereNmfhab($value)
 * @method static Builder|Jmenu01l whereNmlhab($value)
 * @method static Builder|Jmenu01l whereNmmhab($value)
 * @method static Builder|Jmenu01l whereSinfab($value)
 * @method static Builder|Jmenu01l whereTpohab($value)
 *
 * @mixin \Eloquent
 */
class Jmenu01l extends BaseModel
{
    protected $table = 'jmenu01l';
}
