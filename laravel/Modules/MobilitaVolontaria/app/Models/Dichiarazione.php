<?php

declare(strict_types=1);

namespace Modules\MobilitaVolontaria\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\MobilitaVolontaria\Database\Factories\DichiarazioneFactory;

/**
 * Modules\MobilitaVolontaria\Models\Dichiarazione.
 *
 * @method static DichiarazioneFactory factory($count = null, $state = [])
 * @method static Builder|Dichiarazione newModelQuery()
 * @method static Builder|Dichiarazione newQuery()
 * @method static Builder|Dichiarazione query()
 *
 * @mixin \Eloquent
 */
class Dichiarazione extends BaseModel
{
    protected $fillable = ['id', 'codice_fiscale'];
}
