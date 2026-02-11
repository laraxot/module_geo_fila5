<?php

declare(strict_types=1);

namespace Modules\Xot\Traits;

use Illuminate\Database\Eloquent\Builder;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

/**
 * Trait per implementare Schemaless Attributes in modo consistente.
 *
 * Fornisce metodi standard per lavorare con extra_attributes
 * seguendo le best practices di Spatie e del progetto PTVX.
 *
 * @template TModel of \Illuminate\Database\Eloquent\Model
 *
 * @see https://github.com/spatie/laravel-schemaless-attributes
 */
trait HasSchemalessAttributes
{
    /**
     * Scope per filtrare per attributi schemaless.
     *
     * @param  Builder<$this>  $query
     * @return Builder<$this>
     */
    public function scopeWithExtraAttributes(Builder $query): Builder
    {
        // ✅ isset() è sufficiente poiché il cast garantisce un oggetto SchemalessAttributes
        if (isset($this->extra_attributes)) {
            return $this->extra_attributes->modelScope();
        }

        return $query;
    }

    /**
     * Scope per query specifiche su extra_attributes.
     *
     * @param  Builder<$this>  $query
     * @return Builder<$this>
     */
    public function scopeWhereExtraAttribute(Builder $query, string $key, mixed $value): Builder
    {
        /** @var Builder<$this> $res */
        $res = $query->where("extra_attributes->{$key}", $value);

        return $res;
    }

    /**
     * Get un valore da extra_attributes.
     */
    public function getExtraAttribute(string $key, mixed $default = null): mixed
    {
        return $this->extra_attributes->get($key, $default);
    }

    /**
     * Set un valore in extra_attributes.
     */
    public function setExtraAttribute(string $key, mixed $value): void
    {
        $this->extra_attributes->set($key, $value);
    }

    /**
     * Get tutti gli extra_attributes come array.
     *
     * @return array<string, mixed>
     */
    public function getExtraAttributes(): array
    {
        /** @var array<string, mixed> $res */
        $res = $this->extra_attributes->all();

        return $res;
    }

    /**
     * Controlla se esiste un attributo in extra_attributes.
     */
    public function hasExtraAttribute(string $key): bool
    {
        return $this->extra_attributes->has($key);
    }

    /**
     * Rimuove un attributo da extra_attributes.
     */
    public function removeExtraAttribute(string $key): void
    {
        $this->extra_attributes->forget($key);
    }
}
