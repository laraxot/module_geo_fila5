<?php

declare(strict_types=1);

namespace Modules\Ptv\Models\Traits;

use Illuminate\Database\Eloquent\Relations;
use Illuminate\Support\Str;

/*
 * Undocumented trait.
 */
trait HasValutatore
{
    public function valutatore(): Relations\BelongsTo
    {
        $static_class = static::class;

        $class = Str::of($static_class)
            ->before('\Models\\')
            ->append('\Models\StabiDirigente')
            ->toString();

        return $this->belongsTo($class, 'valutatore_id', 'valutatore_id');
    }
}
