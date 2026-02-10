<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Modules\Sigma\Models\Autorizzatori.
 *
 * @property string $nome
 * @property string $autorizzatore
 *
 * @method static Builder|Autorizzatori newModelQuery()
 * @method static Builder|Autorizzatori newQuery()
 * @method static Builder|Autorizzatori query()
 * @method static Builder|Autorizzatori whereAutorizzatore($value)
 * @method static Builder|Autorizzatori whereNome($value)
 *
 * @mixin \Eloquent
 */
class Autorizzatori extends BaseModel
{
    protected $table = 'autorizzatori';
}
