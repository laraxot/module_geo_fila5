<?php

declare(strict_types=1);

namespace Modules\Legge104\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Legge104\Database\Factories\SchedaFactory;

/**
 * Modules\Legge104\Models\Scheda.
 *
 * @method static SchedaFactory factory($count = null, $state = [])
 * @method static Builder|Scheda newModelQuery()
 * @method static Builder|Scheda newQuery()
 * @method static Builder|Scheda query()
 * @property-read \Modules\Ptv\Models\Profile|null $creator
 * @property-read \Modules\Ptv\Models\Profile|null $deleter
 * @property-read \Modules\Ptv\Models\Profile|null $updater
 * @mixin \Eloquent
 */
class Scheda extends BaseModel
{
    protected $fillable = ['id', 'ente', 'matr', 'cognome', 'nome', 'propro', 'posfun', 'clafun', 'stabi', 'stabi_txt', 'repar', 'repar_txt', 'indir', 'giorni_in_sede', 'n_giorni_in_sede', 'giorni_fuori_sede', 'n_giorni_fuori_sede', 'rep003', 'familiari', 'l104', 'disci1'];
}
