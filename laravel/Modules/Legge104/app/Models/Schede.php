<?php

declare(strict_types=1);

namespace Modules\Legge104\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Legge104\Database\Factories\SchedeFactory;

/**
 * Modules\Legge104\Models\Schede.
 *
 * @method static SchedeFactory factory($count = null, $state = [])
 * @method static Builder|Schede newModelQuery()
 * @method static Builder|Schede newQuery()
 * @method static Builder|Schede query()
 *
 * @mixin \Eloquent
 */
class Schede extends BaseModel
{
    protected $fillable = ['id', 'ente', 'matr', 'cognome', 'nome', 'propro', 'posfun', 'clafun', 'stabi', 'stabi_txt', 'repar', 'repar_txt', 'indir', 'giorni_in_sede', 'n_giorni_in_sede', 'giorni_fuori_sede', 'n_giorni_fuori_sede', 'rep003', 'familiari', 'l104', 'disci1'];
}
