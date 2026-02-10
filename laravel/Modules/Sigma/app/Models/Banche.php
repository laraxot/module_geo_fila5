<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Modules\Sigma\Models\Banche.
 *
 * @property int $id
 * @property string|null $banca
 * @property string|null $agenz
 * @property string|null $desban
 *
 * @method static Builder|Banche newModelQuery()
 * @method static Builder|Banche newQuery()
 * @method static Builder|Banche query()
 * @method static Builder|Banche whereAgenz($value)
 * @method static Builder|Banche whereBanca($value)
 * @method static Builder|Banche whereDesban($value)
 * @method static Builder|Banche whereId($value)
 *
 * @mixin \Eloquent
 */
class Banche extends BaseModel
{
    protected $table = 'banche';
}
