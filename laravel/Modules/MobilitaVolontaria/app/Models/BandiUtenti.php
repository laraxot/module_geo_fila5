<?php

declare(strict_types=1);

namespace Modules\MobilitaVolontaria\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\MobilitaVolontaria\Database\Factories\BandiUtentiFactory;

/**
 * Modules\MobilitaVolontaria\Models\BandiUtenti.
 *
 * @method static BandiUtentiFactory factory($count = null, $state = [])
 * @method static Builder|BandiUtenti newModelQuery()
 * @method static Builder|BandiUtenti newQuery()
 * @method static Builder|BandiUtenti query()
 * @property-read \Modules\Ptv\Models\Profile|null $creator
 * @property-read \Modules\Ptv\Models\Profile|null $deleter
 * @property-read \Modules\Ptv\Models\Profile|null $updater
 * @mixin \Eloquent
 */
class BandiUtenti extends BaseModel
{
    protected $fillable = ['id', 'id_bandi'];
}
