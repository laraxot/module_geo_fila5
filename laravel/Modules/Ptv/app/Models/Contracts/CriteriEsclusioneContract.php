<?php

declare(strict_types=1);

namespace Modules\Ptv\Models\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Modules\Progressioni\Database\Factories\CriteriEsclusioneFactory;

/**
 * Undocumented interface.
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $field_name
 * @property string|null $op
 * @property string|null $value
 * @property string|null $type
 * @property int|null $anno
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 *
 * @method static CriteriEsclusioneFactory factory($count = null, $state = [])
 * @method static Builder<static> newModelQuery()
 * @method static Builder<static> newQuery()
 * @method static Builder<static> query()
 * @method static Builder<static> whereAnno($value)
 * @method static Builder<static> whereCreatedAt($value)
 * @method static Builder<static> whereCreatedBy($value)
 * @method static Builder<static> whereFieldName($value)
 * @method static Builder<static> whereId($value)
 * @method static Builder<static> whereName($value)
 * @method static Builder<static> whereOp($value)
 * @method static Builder<static> whereType($value)
 * @method static Builder<static> whereUpdatedAt($value)
 * @method static Builder<static> whereUpdatedBy($value)
 * @method static Builder<static> whereValue($value)
 */
interface CriteriEsclusioneContract
{
    /**
     * Ottiene la relazione HasMany delle schede associate al criterio.
     */
    public function schede(): HasMany;

    /**
     * Ottiene la collezione iterabile delle schede per la verifica criteri.
     */
    public function getSchedaCollection(): Collection;

    /**
     * Ottiene la collezione delle opzioni dei criteri.
     *
     * @return \Illuminate\Support\Collection<string, mixed>
     */
    public function criteriOptionsCollection(): \Illuminate\Support\Collection;

    /**
     * Ottiene un attributo del modello (eredita da Eloquent Model).
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key);
}
