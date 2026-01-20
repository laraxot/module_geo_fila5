<?php

declare(strict_types=1);

namespace Modules\Sigma\Datas;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

/**
 * Undocumented class.
 */
class GgFilterData extends Data
{
    public ?string $lista_propro = null; // ' => $categoria->lista_propro,

    public ?string $lista_propro_sup = null; // ' => $categoria->lista_propro_sup,

    public ?string $posfun = null; // 'posfun'=>$this->posfun,

    public ?string $posiz = null; // 'posiz'=>$this->posiz,

    public ?Carbon $date_min = null; // 'date_min' => $this->criteriOptionsArr('data_presenza_dal'),

    public ?Carbon $date_max = null; // 'date_max' => $this->criteriOptionsArr('data_presenza_al'),

    public ?string $lista_tipo_codice = null; // 'lista_tipo_codice'=>$this->getListaTipoCodiceAspettative(),
}
