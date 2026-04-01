<?php

declare(strict_types=1);

namespace Modules\Ptv\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use RuntimeException;

/*
 * Undocumented trait.
 */
trait HasCriteriValutazione
{
    public function criteriValutazione(): HasMany
    {
        
        $myclass = static::class;
        $class = Str::of($myclass)
            ->before('\Models\\')
            ->append('\Models\CriteriValutazione')
            ->toString();

        // Type narrowing: ensure class exists and is a Model class
        if (! class_exists($class)) {
            throw new RuntimeException("Class {$class} does not exist");
        }

        /** @var class-string<Model> $classString */
        $classString = $class;

        return $this->hasMany($classString, 'anno', 'anno');
    }
}
