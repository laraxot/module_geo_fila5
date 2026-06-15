<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Modules\Sigma\Models\Contracts\SigmaDateRangeFields;
use Modules\Sigma\Models\Traits\Scopes\CommonScope;

/**
 * Base per modelli Sigma con intervallo date (dal/al + anno).
 *
 * Centralizza CommonScope e timestamps legacy; ogni sottoclasse implementa
 * rangeFromField(), rangeToField(), annFieldName() (contratto del trait).
 */
abstract class BaseDateRangeModel extends BaseModel implements SigmaDateRangeFields
{
    use CommonScope;

    public $timestamps = false;

    protected function getAnnoAttribute(): ?int
    {
        return $this->attributes['anno'] ?? $this->extractAnnoFromRange();
    }

    protected function extractAnnoFromRange(): ?int
    {
        $fromField = $this->rangeFromField();
        $fromValue = $this->attributes[$fromField] ?? null;
        if (is_numeric($fromValue) && strlen((string) $fromValue) >= 4) {
            return (int) substr((string) $fromValue, 0, 4);
        }

        return null;
    }
}
