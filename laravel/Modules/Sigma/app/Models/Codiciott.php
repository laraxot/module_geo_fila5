<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Modules\Sigma\Models\Codiciott.
 *
 * @property int $id
 * @property string|null $tipo
 * @property string|null $codice
 * @property string|null $descr
 *
 * @method static Builder|Codiciott newModelQuery()
 * @method static Builder|Codiciott newQuery()
 * @method static Builder|Codiciott query()
 * @method static Builder|Codiciott whereCodice($value)
 * @method static Builder|Codiciott whereDescr($value)
 * @method static Builder|Codiciott whereId($value)
 * @method static Builder|Codiciott whereTipo($value)
 *
 * @mixin \Eloquent
 */
class Codiciott extends BaseModel
{
    protected $table = 'codiciott';
}
