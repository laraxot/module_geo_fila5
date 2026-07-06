<?php

declare(strict_types=1);

namespace Modules\Ptv\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

/*
 * Undocumented trait.
 */
trait HasMyLogs
{
    public function myLogs(): MorphMany
    {
        $class = static::class;
        $log_class = Str::of($class)
            ->before('\Models\\')
            ->append('\Models\MyLog')
            ->toString();

        /** @var class-string<\Illuminate\Database\Eloquent\Model> $log_class */
        return $this->morphMany($log_class, 'model');
    }
}
