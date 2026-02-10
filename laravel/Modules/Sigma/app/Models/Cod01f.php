<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Modules\Sigma\Models\Cod01f.
 *
 * @property int $id
 * @property string|null $TIPO
 * @property string|null $CODICE
 * @property string|null $CODREG
 * @property string|null $CODIC1
 * @property string|null $CODIC2
 * @property string|null $CODIC3
 * @property string|null $CODIC4
 * @property string|null $CODIC5
 *
 * @method static Builder|Cod01f newModelQuery()
 * @method static Builder|Cod01f newQuery()
 * @method static Builder|Cod01f query()
 * @method static Builder|Cod01f whereCODIC1($value)
 * @method static Builder|Cod01f whereCODIC2($value)
 * @method static Builder|Cod01f whereCODIC3($value)
 * @method static Builder|Cod01f whereCODIC4($value)
 * @method static Builder|Cod01f whereCODIC5($value)
 * @method static Builder|Cod01f whereCODICE($value)
 * @method static Builder|Cod01f whereCODREG($value)
 * @method static Builder|Cod01f whereId($value)
 * @method static Builder|Cod01f whereTIPO($value)
 *
 * @mixin \Eloquent
 */
class Cod01f extends BaseModel
{
    protected $table = 'cod01f';
}
