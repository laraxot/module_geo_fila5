<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Traits;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Model;
=======
>>>>>>> laraxot/dev
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Geo\Models\Place;

/**
 * Modules\Geo\Models\Traits\HasPlaceTrait.
<<<<<<< HEAD
 *
 * @phpstan-require-extends Model
 *
 * @phpstan-ignore trait.unused
=======
>>>>>>> laraxot/dev
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
