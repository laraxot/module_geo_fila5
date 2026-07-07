<?php

declare(strict_types=1);

namespace Modules\Ptv\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface StabiDirigenteContract
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public static function firstOrCreate(array $attributes): self;

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function update(array<string, mixed> $attributes): bool;

    /**
     * @param  array<string, mixed>  $conditions
     */
    public function where(array<string, mixed> $conditions): Builder;
}
