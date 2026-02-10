<?php

declare(strict_types=1);

namespace Modules\Mensa\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Mensa\Database\Factories\MensileFactory;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Mensa\Models\Mensile.
 *
 * @method static MensileFactory factory($count = null, $state = [])
 * @method static Builder|Mensile newModelQuery()
 * @method static Builder|Mensile newQuery()
 * @method static Builder|Mensile query()
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 *
 * @mixin \Eloquent
 */
class Mensile extends BaseModel
{
    protected $fillable = ['id', 'clafun', 'smesli', 'sannli', 'cod', 'cassa', 'impoeu', 'contributo'];
}
