<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Models;

use Modules\Ptv\Models\CategoriaPropro as PtvCategoriaPropro;

/**
 * Modules\IndennitaCondizioniLavoro\Models\CategoriaPropro.
 *
 * @mixin \Eloquent
 */
class CategoriaPropro extends PtvCategoriaPropro
{
    protected $connection = 'indennita_condizioni_lavoro';
}
