<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Geo\Models\Place;

/**
 * Modules\Geo\Models\Traits\HasPlaceTrait.
 *
<<<<<<< .merge_file_HBFIL8
 * @phpstan-require-extends Model
=======
 * <<<<<<< HEAD
 * =======
 *
 * @phpstan-require-extends \Illuminate\Database\Eloquent\Model
 *
 * >>>>>>> df4b0e0 (.)
>>>>>>> .merge_file_L1dbMv
 *
 * @phpstan-ignore trait.unused
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
