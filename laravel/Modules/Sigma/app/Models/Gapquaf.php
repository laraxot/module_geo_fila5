<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Modules\Sigma\Models\Gapquaf.
 *
 * @property int $id
 * @property string|null $qente
 * @property string|null $qtipo
 * @property string|null $qprof
 * @property string|null $qposi
 * @property string|null $qdesc
 * @property string|null $qabil
 *
 * @method static Builder|Gapquaf newModelQuery()
 * @method static Builder|Gapquaf newQuery()
 * @method static Builder|Gapquaf query()
 * @method static Builder|Gapquaf whereId($value)
 * @method static Builder|Gapquaf whereQabil($value)
 * @method static Builder|Gapquaf whereQdesc($value)
 * @method static Builder|Gapquaf whereQente($value)
 * @method static Builder|Gapquaf whereQposi($value)
 * @method static Builder|Gapquaf whereQprof($value)
 * @method static Builder|Gapquaf whereQtipo($value)
 *
 * @mixin \Eloquent
 */
class Gapquaf extends BaseModel
{
    protected $table = 'gapquaf';
}
