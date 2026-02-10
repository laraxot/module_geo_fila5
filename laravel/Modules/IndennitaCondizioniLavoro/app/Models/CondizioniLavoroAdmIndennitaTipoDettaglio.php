<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * @property-read CondizioniLavoro|null $condizioniLavoro
 * @property-read int|float $tot
 * @property-read int|float $tot_x_ptime
 * @property-read IndennitaTipoDettaglio|null $indennitaTipoDettaglio
 *
 * @method static Builder<static>|CondizioniLavoroAdmIndennitaTipoDettaglio newModelQuery()
 * @method static Builder<static>|CondizioniLavoroAdmIndennitaTipoDettaglio newQuery()
 * @method static Builder<static>|CondizioniLavoroAdmIndennitaTipoDettaglio query()
 *
 * @mixin \Eloquent
 */
class CondizioniLavoroAdmIndennitaTipoDettaglio extends CondizioniLavoroIndennitaTipoDettaglioPivot {}
