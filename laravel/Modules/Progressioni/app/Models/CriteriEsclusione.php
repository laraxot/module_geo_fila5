<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Modules\Progressioni\Database\Factories\CriteriEsclusioneFactory;
use Modules\Ptv\Models\Contracts\CriteriEsclusioneContract;
use Modules\Ptv\Models\CriteriEsclusione as PtvCriteriEsclusione;

/**
 * Modules\Progressioni\Models\CriteriEsclusione.
 *
 * @property int $id
 * @property bool $is_enabled
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
 * @method static CriteriEsclusioneFactory factory($count = null, $state = [])
 * @method static Builder|CriteriEsclusione newModelQuery()
 * @method static Builder|CriteriEsclusione newQuery()
 * @method static Builder|CriteriEsclusione query()
 * @method static Builder|CriteriEsclusione whereAnno($value)
 * @method static Builder|CriteriEsclusione whereCreatedAt($value)
 * @method static Builder|CriteriEsclusione whereCreatedBy($value)
 * @method static Builder|CriteriEsclusione whereFieldName($value)
 * @method static Builder|CriteriEsclusione whereId($value)
 * @method static Builder|CriteriEsclusione whereName($value)
 * @method static Builder|CriteriEsclusione whereOp($value)
 * @method static Builder|CriteriEsclusione whereType($value)
 * @method static Builder|CriteriEsclusione whereUpdatedAt($value)
 * @method static Builder|CriteriEsclusione whereUpdatedBy($value)
 * @method static Builder|CriteriEsclusione whereValue($value)
 * @mixin Builder
 * @property-read \Modules\Ptv\Models\Profile|null $creator
 * @property-read Collection<int, \Modules\Progressioni\Models\CriteriOption> $criteriOptions
 * @property-read int|null $criteri_options_count
 * @property-read \Modules\Ptv\Models\Profile|null $deleter
 * @property-read Collection<int, \Modules\Progressioni\Models\Schede> $schede
 * @property-read int|null $schede_count
 * @property-read \Modules\Ptv\Models\Profile|null $updater
 * @method static Builder<static>|CriteriEsclusione whereIsEnabled($value)
 * @mixin \Eloquent
 */
class CriteriEsclusione extends PtvCriteriEsclusione implements CriteriEsclusioneContract
{
    protected $connection = 'progressione';

    public function getSchedeAttribute(): Collection
    {
        return $this->schede()->get();
    }

    /**
     * Get the schede collection.
     */
    public function getSchedeCollection(): Collection
    {
        return $this->schede()->get();
    }

    public function criteriOptionsCollection(): \Illuminate\Support\Collection
    {
        return \Illuminate\Support\Collection::make(
            $this->criteriOptions()->get()->toArray()
        );
    }
} // end class
