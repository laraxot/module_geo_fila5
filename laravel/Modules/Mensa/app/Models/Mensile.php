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
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @property string $id
 * @property string|null $clafun
 * @property string|null $smesli
 * @property string|null $sannli
 * @property string|null $cod
 * @property string|null $cassa
 * @property string|null $impoeu
 * @property string|null $contributo
 * @property-read Profile|null $deleter
 * @method static Builder<static>|Mensile whereCassa($value)
 * @method static Builder<static>|Mensile whereClafun($value)
 * @method static Builder<static>|Mensile whereCod($value)
 * @method static Builder<static>|Mensile whereContributo($value)
 * @method static Builder<static>|Mensile whereId($value)
 * @method static Builder<static>|Mensile whereImpoeu($value)
 * @method static Builder<static>|Mensile whereSannli($value)
 * @method static Builder<static>|Mensile whereSmesli($value)
 * @mixin \Eloquent
 */
class Mensile extends BaseModel
{
    protected $fillable = ['id', 'clafun', 'smesli', 'sannli', 'cod', 'cassa', 'impoeu', 'contributo'];
}
