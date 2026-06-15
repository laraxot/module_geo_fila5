<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Modules\Sigma\Models\Traits\Scopes\CommonScope;

/**
 * Base per modelli Sigma con intervallo date (dal/al + anno).
 *
 * Centralizza CommonScope e timestamps legacy; ogni sottoclasse implementa
 * rangeFromField(), rangeToField(), annFieldName() (contratto del trait).
 */
abstract class BaseDateRangeModel extends BaseModel
{
    use CommonScope;

    public $timestamps = false;
}
