<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Sigma\Models\Contracts\SigmaDateRangeFields;
use Modules\Sigma\Models\Contracts\SigmaEnteMatrFields;
use Modules\Xot\Models\XotBaseModel;

/**
 * Class BaseModel.
 *
 * Base del modulo Sigma: connessione `generale`, cast condivisi, integrazione legacy.
 */
abstract class BaseModel extends XotBaseModel implements SigmaEnteMatrFields
{
    /**
     * Connessione database da utilizzare.
     * Utilizza la connessione 'generale' per compatibilità con sistemi esterni.
     *
     * @var string
     */
    protected $connection = 'generale';

    public function matrField(): string
    {
        return 'matr';
    }

    public function enteField(): string
    {
        return 'ente';
    }

    public function yearField(): string
    {
        return '';
    }

    /**
     * HasMany verso modello correlato con join ente+matr (DRY).
     *
     * @template TModel of \Illuminate\Database\Eloquent\Model
     *
     * @param  class-string<TModel>  $related
     * @return HasMany<TModel, $this>
     */
    protected function hasManyByEnteMatr(
        string $related,
        string $relatedMatrColumn = 'matr',
        string $relatedEnteColumn = 'ente',
    ): HasMany {
        $matrField = $this->matrField();
        $enteField = $this->enteField();

        /** @var HasMany<TModel, $this> $relation */
        $relation = $this->hasMany($related, $relatedMatrColumn, $matrField)
            ->where($relatedEnteColumn, $this->{$enteField});

        return $this->applyRelatedActiveAnnFilter($relation, $related);
    }

    /**
     * @template TModel of \Illuminate\Database\Eloquent\Model
     *
     * @param  HasMany<TModel, $this>  $relation
     * @param  class-string<TModel>  $related
     * @return HasMany<TModel, $this>
     */
    protected function applyRelatedActiveAnnFilter(HasMany $relation, string $related): HasMany
    {
        if (! is_a($related, SigmaDateRangeFields::class, true)) {
            return $relation;
        }

        /** @var SigmaDateRangeFields&\Illuminate\Database\Eloquent\Model $instance */
        $instance = new $related;

        return $relation->where($instance->annFieldName(), '');
    }

    /**
     * HasOne verso modello correlato con join ente+matr (DRY).
     *
     * @template TModel of \Illuminate\Database\Eloquent\Model
     *
     * @param  class-string<TModel>  $related
     * @return HasOne<TModel, $this>
     */
    protected function hasOneByEnteMatr(
        string $related,
        string $relatedMatrColumn = 'matr',
        string $relatedEnteColumn = 'ente',
    ): HasOne {
        $matrField = $this->matrField();
        $enteField = $this->enteField();

        /** @var HasOne<TModel, $this> $relation */
        $relation = $this->hasOne($related, $relatedMatrColumn, $matrField)
            ->where($relatedEnteColumn, $this->{$enteField});

        return $relation;
    }

    /**
     * @return array<string, string>
     */
    #[\Override]
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            // Cast specifici per il modulo Sigma
            'anv2kd' => 'date',
            'anv2ka' => 'date',
            'anvist' => 'integer',
            'anvimp' => 'decimal:5',
            'anvqta' => 'decimal:2',
        ];
    }
}
