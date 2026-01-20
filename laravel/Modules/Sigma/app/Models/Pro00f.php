<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Modules\Sigma\Models\Pro00f.
 *
 * @property int $id
 * @property string|null $UTENTE
 * @property string|null $ENTE
 *
 * @method static Builder|Pro00f newModelQuery()
 * @method static Builder|Pro00f newQuery()
 * @method static Builder|Pro00f query()
 * @method static Builder|Pro00f whereENTE($value)
 * @method static Builder|Pro00f whereId($value)
 * @method static Builder|Pro00f whereUTENTE($value)
 *
 * @mixin \Eloquent
 */
class Pro00f extends BaseModel
{
    protected $table = 'pro00f';
}
