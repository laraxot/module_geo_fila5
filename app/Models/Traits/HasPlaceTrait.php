<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Traits;

<<<<<<< .merge_file_zjftaQ
use Illuminate\Database\Eloquent\Model;
=======
>>>>>>> .merge_file_dBkWs0
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Geo\Models\Place;

/**
 * Modules\Geo\Models\Traits\HasPlaceTrait.
<<<<<<< .merge_file_zjftaQ
 *
 * @phpstan-require-extends Model
 *
 * @phpstan-ignore trait.unused
=======
>>>>>>> .merge_file_dBkWs0
 */
trait HasPlaceTrait
{
    // ----- relationship -----

    /** @phpstan-ignore-next-line */
    public function place(): MorphOne
    {
        return $this->morphOne(Place::class, 'model');
    }

    /** @phpstan-ignore-next-line */
    public function places(): MorphMany
    {
        return $this->morphMany(Place::class, 'model');
    }

    // ----- mutators -----
    // public function getPlaceAttribute(string $value){
    //     return
    // }
}
