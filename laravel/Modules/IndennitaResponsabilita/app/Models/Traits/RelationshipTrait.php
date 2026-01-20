<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Models\Traits;

// use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\IndennitaResponsabilita\Models\ImportiCategoria;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Models\Message;
use Modules\IndennitaResponsabilita\Models\MyLog;
use Modules\IndennitaResponsabilita\Models\Rating;
use Modules\IndennitaResponsabilita\Models\RatingMorph;
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

    public function myLogs(): HasMany
    {
        return $this->hasMany(MyLog::class, 'id_tbl', 'id')
            ->where('tbl', $this->getTable());
    }

    public function importi(): HasOne
    {
        $row = $this->hasOne(ImportiCategoria::class, 'ente', 'ente')->where('anno', $this->anno)->whereRaw('find_in_set("'.$this->propro.'",lista_propro)');
        if (0 === $row->count()) {
            $rowOld = ImportiCategoria::where('ente', $this->ente)
                ->where('anno', $this->anno - 1)
                ->whereRaw('find_in_set("'.$this->propro.'",lista_propro)');
            if (1 !== $rowOld->count()) {
                if (0 === $this->propro) {
                    return $row;
                }

                echo '<h3>['.$this->anno.']['.$this->propro.']['.__LINE__.']['.__FILE__.']</h3>';

                // dddx([$rowOld->get(), 'qualcosa e\' andato storto ['.__LINE__.']['.__FILE__.']]);
                return $row;
            }

            $firstRow = $rowOld->first();
            if (null !== $firstRow) {
                $newRow = $firstRow->replicate();
                $newRow->anno = $this->anno;
                $newRow->save();
            }
            $row = $this->hasOne(ImportiCategoria::class, 'ente', 'ente')
                ->where('anno', $this->anno)
                ->whereRaw('find_in_set("'.$this->propro.'",lista_propro)');
        }

        return $row;
    }

    /**
     * Anagrafica relationship.
     * Note: This returns BelongsTo, but BaseScheda::anag() returns HasOne.
     * This is a known architectural issue documented in docs/anag-relationship-conflict-resolution.md
     *
     * @return BelongsTo
     * @phpstan-ignore-next-line method.childReturnType - BelongsTo is semantically correct for child models
     */
    public function anag(): BelongsTo
    {
        return $this->belongsTo(Anag::class, 'matr', 'matr')
            ->where('ente', $this->getAttribute('ente'));
    }
}
