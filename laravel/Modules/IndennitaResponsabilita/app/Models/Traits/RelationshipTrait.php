<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Models\Traits;

// use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\IndennitaResponsabilita\Models\ImportiCategoria;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Models\Message;
use Modules\IndennitaResponsabilita\Models\MyLog;
use Modules\Progressioni\Models\CategoriaPropro;
use Modules\Sigma\Models\Anag;

use function Safe\date;

/**
 * Trait RelationshipTrait.
 */
trait RelationshipTrait
{
    public function mails(): HasMany
    {
        $stabi = request()->input('stabi', '');
        $repar = request()->input('repar', '');
        $anno = request()->input('anno', date('Y'));
        if (is_string($anno) && is_numeric($anno)) {
            $this->setAttribute('anno', (int) $anno);
        } elseif (is_int($anno)) {
            $this->setAttribute('anno', $anno);
        }
        $year = request()->input('year', $this->getAttribute('anno') ?? $anno);
        if (is_string($year) && is_numeric($year)) {
            $this->setAttribute('anno', (int) $year);
        } elseif (is_int($year)) {
            $this->setAttribute('anno', $year);
        }

        return $this->hasMany(IndennitaResponsabilita::class, 'anno', 'anno')
            ->where('stabi', $stabi)
            ->where('repar', $repar);
        // ->where('ha_diritto',1)
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'anno', 'anno');
    }

    public function mailInviate(): HasMany
    {
        return $this->hasMany(MyLog::class, 'id_tbl', 'id')
            ->where('tbl', $this->getTable())
            ->where('note', 'sendMail');
    }
    

    public function importi(): HasOne
    {
        $anno = $this->anno ?? date('Y');
        $propro = $this->propro ?? 0;

        return $this->hasOne(ImportiCategoria::class, 'ente', 'ente')
            ->where('anno', $anno)
            ->whereRaw('find_in_set(?, lista_propro)', [(string) $propro]);
    }

    public function categoriaPropro(): HasOne
    {
        $anno = $this->anno ?? date('Y');
        $matr = $this->matr ?? 0;

        return $this->hasOne(CategoriaPropro::class, 'anno', 'anno')
            ->where('anno', $anno)
            ->where('matr', $matr);
    }

    /**
     * Get or create the importo for this category.
     */
    public function getImportoAttribute(): ?ImportiCategoria
    {
        $row = $this->importi;
        if ($row === null) {
            $rowOld = ImportiCategoria::where('ente', $this->ente)
                ->where('anno', $this->anno - 1)
                ->whereRaw('find_in_set(?, lista_propro)', [(string) $this->propro])
                ->first();

            if ($rowOld !== null) {
                $newRow = $rowOld->replicate();
                $newRow->anno = $this->anno;
                $newRow->save();

                return $newRow;
            }
        }

        return $row;
    }

    /**
     * Anagrafica relationship.
     * Note: This returns BelongsTo, but BaseScheda::anag() returns HasOne.
     * This is a known architectural issue documented in docs/anag-relationship-conflict-resolution.md
     *
     * @phpstan-ignore-next-line method.childReturnType - BelongsTo is semantically correct for child models
     */
    public function anag(): BelongsTo
    {
        return $this->belongsTo(Anag::class, 'matr', 'matr')
            ->where('ente', $this->getAttribute('ente'));
    }
}
