<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Ptv\Models\Profile;

// ---- traits --
/**
 * Modules\IndennitaCondizioniLavoro\Models\Opzioni.
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $value
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 *
 * @method static Builder|Opzioni newModelQuery()
 * @method static Builder|Opzioni newQuery()
 * @method static Builder|Opzioni query()
 * @method static Builder|Opzioni whereCreatedAt($value)
 * @method static Builder|Opzioni whereId($value)
 * @method static Builder|Opzioni whereName($value)
 * @method static Builder|Opzioni whereUpdatedAt($value)
 * @method static Builder|Opzioni whereValue($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 *
 * @mixin \Eloquent
 */
class Opzioni extends BaseModel
{
    protected $table = 'opzioni';

    /**
     * @var list<string>
     */
    protected $fillable = ['id', 'name', 'value'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
