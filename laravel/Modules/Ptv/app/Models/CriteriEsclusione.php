<?php

declare(strict_types=1);

namespace Modules\Ptv\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Progressioni\Database\Factories\CriteriEsclusioneFactory;
use Modules\Ptv\Models\Contracts\CriteriEsclusioneContract;

/**
 * class Modules\Progressioni\Models\CriteriEsclusione.
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
 *
 * @property Profile|null $creator
 * @property \Illuminate\Database\Eloquent\Collection<int, CriteriOption> $criteriOptions
 * @property int|null $criteri_options_count
 * @property Profile|null $updater
 *
 * @mixin \Eloquent
 */
class CriteriEsclusione extends BaseModel implements CriteriEsclusioneContract
{
    protected $fillable = ['id', 'name', 'field_name', 'op', 'value', 'type', 'anno'];

    protected $table = 'criteri_esclusione';

    // -------------------------

    public function schede(): HasMany
    {
        $class = Str::of(static::class)->beforeLast('\\')->append('\\Schede')->toString();

        /** @phpstan-ignore-next-line */
        return $this->hasMany($class, 'anno', 'anno');
    }

    public function getSchedeCollection(): EloquentCollection
    {
        return $this->schede()->get();
    }

    public function criteriOptions(): HasMany
    {
        $class = Str::of(static::class)->beforeLast('\\')->append('\\CriteriOption')->toString();

        /** @phpstan-ignore-next-line */
        return $this->hasMany($class, 'anno', 'anno');
    }

    public function criteriOptionsCollection(): Collection
    {
        $criteriOption = $this
            ->criteriOptions
            ->map(function ($item) {
                $value = '';
                /** @phpstan-ignore-next-line */
                switch ($item->type) {
                    case 'list':
                        /** @phpstan-ignore-next-line */
                        $value = explode(',', $item->value);
                        break;
                    case 'int':
                        $value = intval($value);
                        break;
                    case 'date':
                        /** @phpstan-ignore-next-line */
                        $value = $item->value;
                        if ($value != null) {
                            $value = Carbon::parse($value);
                        }
                        break;
                    default:
                        /** @phpstan-ignore-next-line */
                        dddx($item->type);
                        break;
                }
                /** @phpstan-ignore-next-line */
                $item->value_real = $value;

                return $item;
            })
            ->pluck('value_real', 'name');

        return $criteriOption;
    }
} // end class
