<?php

declare(strict_types=1);

namespace Modules\Badge\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Badge\Database\Factories\MensaFactory;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Badge\Models\Mensa.
 *
 * @method static MensaFactory factory($count = null, $state = [])
 * @method static Builder|Mensa newModelQuery()
 * @method static Builder|Mensa newQuery()
 * @method static Builder|Mensa query()
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 *
 * @mixin \Eloquent
 */
class Mensa extends BaseModel
{
    protected $fillable = ['id', 'ente', 'matr', 'conome', 'nome', 'propro', 'posfun', 'stabi', 'repar', 'data', 'ora', 'tipo', 'note'];
}
