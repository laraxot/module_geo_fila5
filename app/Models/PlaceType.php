<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
<<<<<<< .merge_file_CS8Lqk
=======
use Modules\Geo\Database\Factories\PlaceTypeFactory;
>>>>>>> .merge_file_Df3VXx
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Models\Traits\HasXotFactory;

/**
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 *
<<<<<<< .merge_file_CS8Lqk
 * @method static \Modules\Geo\Database\Factories\PlaceTypeFactory factory($count = null, $state = [])
 * @method static Builder<static>|PlaceType                        newModelQuery()
 * @method static Builder<static>|PlaceType                        newQuery()
 * @method static Builder<static>|PlaceType                        query()
 *
 * @property int         $id
=======
 * @method static Builder<static>|PlaceType newModelQuery()
 * @method static Builder<static>|PlaceType newQuery()
 * @method static Builder<static>|PlaceType query()
 *
 * @property ProfileContract|null $deleter
 *
 * @method static PlaceTypeFactory factory($count = null, $state = [])
 *
 * @property string      $id
>>>>>>> .merge_file_Df3VXx
 * @property string      $name
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder<static>|PlaceType whereCreatedAt($value)
 * @method static Builder<static>|PlaceType whereDescription($value)
 * @method static Builder<static>|PlaceType whereId($value)
 * @method static Builder<static>|PlaceType whereName($value)
 * @method static Builder<static>|PlaceType whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class PlaceType extends BaseModel
{
<<<<<<< .merge_file_CS8Lqk
=======
    /**  */
>>>>>>> .merge_file_Df3VXx
    use HasXotFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    // Definisci le relazioni e i metodi necessari per la classe PlaceType
}
