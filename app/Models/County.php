<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
<<<<<<< HEAD
=======
use Modules\Geo\Database\Factories\CountyFactory;
>>>>>>> laraxot/dev
use Modules\Xot\Contracts\ProfileContract;

/**
 * Suddivisione tipo “county” (contesto USA / geonames), non il comune italiano.
 *
<<<<<<< HEAD
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $updater
 *
=======
 * @property string               $id
 * @property string               $county
 * @property string|null          $county_code
 * @property int|null             $state_id
 * @property Carbon|null          $created_at
 * @property Carbon|null          $updated_at
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @property ProfileContract|null $deleter
 *
 * @method static CountyFactory          factory($count = null, $state = [])
>>>>>>> laraxot/dev
 * @method static Builder<static>|County newModelQuery()
 * @method static Builder<static>|County newQuery()
 * @method static Builder<static>|County query()
 *
<<<<<<< HEAD
 * @property int $id
 * @property int|null $state_id Stato/regione di appartenenza
 * @property string $county Nome della suddivisione (county/provincia)
 * @property string|null $county_code Codice della suddivisione
 * @property int|null $state_index Indice progressivo entro lo stato
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 *
 * @method static Builder<static>|County whereCounty($value)
 * @method static Builder<static>|County whereCountyCode($value)
 * @method static Builder<static>|County whereCreatedAt($value)
 * @method static Builder<static>|County whereCreatedBy($value)
 * @method static Builder<static>|County whereDeletedAt($value)
 * @method static Builder<static>|County whereDeletedBy($value)
 * @method static Builder<static>|County whereId($value)
 * @method static Builder<static>|County whereStateId($value)
 * @method static Builder<static>|County whereStateIndex($value)
 * @method static Builder<static>|County whereUpdatedAt($value)
 * @method static Builder<static>|County whereUpdatedBy($value)
=======
 * @method static Builder<static>|County whereCounty($value)
 * @method static Builder<static>|County whereCountyCode($value)
 * @method static Builder<static>|County whereCreatedAt($value)
 * @method static Builder<static>|County whereId($value)
 * @method static Builder<static>|County whereStateId($value)
 * @method static Builder<static>|County whereUpdatedAt($value)
>>>>>>> laraxot/dev
 *
 * @mixin \Eloquent
 */
class County extends BaseModel
{
    protected $fillable = [
        'state_id',
        'county',
        'state_index',
    ];
}
