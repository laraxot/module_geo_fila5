<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Modules\Sigma\Models\Tabe00f.
 *
 * @property int $id
 * @property string|null $codtab
 * @property string|null $codice
 * @property string|null $field2
 *
 * @method static Builder|Tabe00f newModelQuery()
 * @method static Builder|Tabe00f newQuery()
 * @method static Builder|Tabe00f query()
 * @method static Builder|Tabe00f whereCodice($value)
 * @method static Builder|Tabe00f whereCodtab($value)
 * @method static Builder|Tabe00f whereField2($value)
 * @method static Builder|Tabe00f whereId($value)
 *
 * @mixin \Eloquent
 */
class Tabe00f extends BaseModel
{
    protected $table = 'tabe00f';
}
