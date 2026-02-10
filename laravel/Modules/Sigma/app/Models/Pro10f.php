<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Modules\Sigma\Models\Pro10f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $promen
 * @property string|null $propar
 * @property string|null $proabi
 *
 * @method static Builder|Pro10f newModelQuery()
 * @method static Builder|Pro10f newQuery()
 * @method static Builder|Pro10f query()
 * @method static Builder|Pro10f whereEnte($value)
 * @method static Builder|Pro10f whereId($value)
 * @method static Builder|Pro10f whereProabi($value)
 * @method static Builder|Pro10f wherePromen($value)
 * @method static Builder|Pro10f wherePropar($value)
 *
 * @mixin \Eloquent
 */
class Pro10f extends BaseModel
{
    protected $table = 'pro10f';
}
