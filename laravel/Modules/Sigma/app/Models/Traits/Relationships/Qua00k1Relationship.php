<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Relationships;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Sigma\Models\Qua00k1;

/**
 * Relazione HasMany verso Qua00k1 con filtro anno vuoto.
 *
 * @phpstan-require-extends \Modules\Sigma\Models\BaseModel
 *
 * @see \Modules\Sigma\Models\Contracts\SigmaQuaRelationAnnFields
 */
trait Qua00k1Relationship
{
    /**
     * @return HasMany<Qua00k1, $this>
     */
    public function qua00k1(): HasMany
    {
        $table = (new Qua00k1)->getTable();

        return $this->hasManyByEnteMatr(Qua00k1::class)
            ->where($table.'.quaann', '');
    }
}