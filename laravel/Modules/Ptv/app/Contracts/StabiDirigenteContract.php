<?php

declare(strict_types=1);

namespace Modules\Ptv\Contracts;

use Illuminate\Database\Eloquent\Builder;

/** @template TModel */
interface StabiDirigenteContract
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public static function firstOrCreate(array $attributes): self;

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function update(array $attributes): bool;

    /**
     * @param  array<string, mixed>  $conditions
     * @return Builder<TModel>
     */
    public function where(array $conditions): Builder;
}
