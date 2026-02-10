<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Modules\Sigma\Models\Autorizzatori.
 *
 * @property string $nome
 * @property string $autorizzatore
 * @method static Builder|Autorizzatori newModelQuery()
 * @method static Builder|Autorizzatori newQuery()
 * @method static Builder|Autorizzatori query()
 * @method static Builder|Autorizzatori whereAutorizzatore($value)
 * @method static Builder|Autorizzatori whereNome($value)
 * @property-read \Modules\Ptv\Models\Profile|null $creator
 * @property-read \Modules\Ptv\Models\Profile|null $deleter
 * @property-read \Modules\Ptv\Models\Profile|null $updater
 * @method static \Modules\Sigma\Database\Factories\AutorizzatoriFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class Autorizzatori extends BaseModel
{
    protected $table = 'autorizzatori';
}
