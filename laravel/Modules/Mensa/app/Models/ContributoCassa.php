<?php

declare(strict_types=1);

namespace Modules\Mensa\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Mensa\Database\Factories\ContributoCassaFactory;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Mensa\Models\ContributoCassa.
 *
 * @method static ContributoCassaFactory factory($count = null, $state = [])
 * @method static Builder|ContributoCassa newModelQuery()
 * @method static Builder|ContributoCassa newQuery()
 * @method static Builder|ContributoCassa query()
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @property string $id
 * @property string|null $cod
 * @property string|null $cassa
 * @property string $perc
 * @property-read Profile|null $deleter
 * @method static Builder<static>|ContributoCassa whereCassa($value)
 * @method static Builder<static>|ContributoCassa whereCod($value)
 * @method static Builder<static>|ContributoCassa whereId($value)
 * @method static Builder<static>|ContributoCassa wherePerc($value)
 * @mixin \Eloquent
 */
class ContributoCassa extends BaseModel
{
    protected $fillable = ['id', 'cod', 'cassa', 'perc'];
}
