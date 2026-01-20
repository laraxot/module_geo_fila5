<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Modules\Progressioni\Database\Factories\AssenzeFactory;
use Modules\Sigma\Models\Asz00f;

// use Modules\Xot\Services\ModelService; // DEPRECATED: Class not found
/**
 * Modules\Progressioni\Models\Assenze.
 *
 * @property int $id
 * @property int|null $tipo
 * @property int|null $codice
 * @property string|null $descr
 * @property int|null $anno
 * @property string|null $umi
 * @property string|null $dur
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Collection<int, Asz00f> $asz00fs
 * @property int|null $asz00fs_count
 *
 * @method static AssenzeFactory factory($count = null, $state = [])
 * @method static Builder|Assenze newModelQuery()
 * @method static Builder|Assenze newQuery()
 * @method static Builder|Assenze query()
 * @method static Builder|Assenze whereAnno($value)
 * @method static Builder|Assenze whereCodice($value)
 * @method static Builder|Assenze whereCreatedAt($value)
 * @method static Builder|Assenze whereCreatedBy($value)
 * @method static Builder|Assenze whereDescr($value)
 * @method static Builder|Assenze whereDur($value)
 * @method static Builder|Assenze whereId($value)
 * @method static Builder|Assenze whereTipo($value)
 * @method static Builder|Assenze whereUmi($value)
 * @method static Builder|Assenze whereUpdatedAt($value)
 * @method static Builder|Assenze whereUpdatedBy($value)
 *
 * @mixin \Eloquent
 */
class Assenze extends BaseModel
{
    protected $fillable = ['id', 'tipo', 'codice', 'descr', 'anno', 'umi', 'dur'];

    protected $table = 'codici_assenze_progressione';

    public function schedas(): void
    {
        // solo per prendere
        // dddx('WIP');
        // return $this->hasMany(Schede::class);
        // dddx($this->asz00f);

        // return $this->hasManyThrough(Schede::class, Asz00f::class);
    }

    public function asz00fs(): HasMany
    {
        // ModelService::make()->setModel(app(Asz00f::class))->indexIfNotExists(['asztip', 'aszcod', 'aszann', 'asz2kd', 'asz2ka']);
        // TODO: Replace with proper index creation logic when ModelService is available

        return $this->hasMany(Asz00f::class, 'asztip', 'tipo')
            ->where('aszcod', $this->codice)
            ->where('aszann', '')
            ->ofYear((int) $this->anno);
    }
}
