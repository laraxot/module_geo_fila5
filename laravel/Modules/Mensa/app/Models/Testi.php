<?php

declare(strict_types=1);

namespace Modules\Mensa\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Mensa\Database\Factories\TestiFactory;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Mensa\Models\Testi.
 *
 * @method static TestiFactory factory($count = null, $state = [])
 * @method static Builder|Testi newModelQuery()
 * @method static Builder|Testi newQuery()
 * @method static Builder|Testi query()
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @property string $id
 * @property string|null $testo
 * @property-read Profile|null $deleter
 * @method static Builder<static>|Testi whereId($value)
 * @method static Builder<static>|Testi whereTesto($value)
 * @mixin \Eloquent
 */
class Testi extends BaseModel
{
    protected $fillable = ['id', 'testo'];
}
