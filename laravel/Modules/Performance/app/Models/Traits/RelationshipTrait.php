<?php

declare(strict_types=1);

namespace Modules\Performance\Models\Traits;

// use Illuminate\Support\Str;
// ----- models------
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Performance\Models\CriteriEsclusione;
use Modules\Performance\Models\CriteriMaggiorazione;
use Modules\Performance\Models\CriteriOption;
use Modules\Performance\Models\CriteriValutazione;
use Modules\Performance\Models\Individuale;
use Modules\Performance\Models\IndividualeAssenze;
use Modules\Performance\Models\IndividualePesi;
use Modules\Performance\Models\IndividualeTotStabi;
use Modules\Performance\Models\MyLog;
use Modules\Performance\Models\Option;
use Modules\Performance\Models\StabiDirigente;

// ------ ext models---

// ----- services -----

// ------ traits ---

/**
 * Modules\Performance\Models\Traits\RelationshipTrait.
 *
 * @property int $ente
 * @property int $matr
 * @property int $propro
 * @property int $posfun
 * @property int $anno
 * @property int $stabi
 * @property int $repar
 */
trait RelationshipTrait
{
    public function criteriOptions(): HasMany
    {
        return $this->hasMany(CriteriOption::class, 'anno', 'anno');
    }

    public function codiciAssenze(): HasMany
    {
        return $this->hasMany(IndividualeAssenze::class, 'anno', 'anno');
    }

    public function criteriMaggiorazione(): HasOne
    {
        return $this->hasOne(CriteriMaggiorazione::class, 'anno', 'anno');
    }

    public function criteriEsclusione(): HasMany
    {
        return $this->hasMany(CriteriEsclusione::class, 'anno', 'anno');
    }

    public function criteriValutazioneOld(): HasMany
    {
        return $this->hasMany(CriteriValutazione::class, 'anno', 'anno')
            ->where('post_type', $this->type)
            ->ordered();

        /*
        ->withDefault(
            [
                'name'=>'no-set',
                'value'=>'andare a mettere in options',
            ]
        );
        */
    }

    public function cards(): HasMany // traduzione di scheda
    {return $this->hasMany(Individuale::class, 'anno', 'anno')
            ->where('ente', $this->ente)
            ->where('matr', $this->matr);
    }

    public function peso(): HasOne
    {
        return $this->hasOne(IndividualePesi::class, 'anno', 'anno')
            ->whereRaw('find_in_set("'.$this->propro.'",lista_propro)')
            ->where('type', $this->type);
    }

    public function pesoPo(): HasOne
    {
        return $this->hasOne(IndividualePesi::class, 'anno', 'anno')->where('type', 'po');
        // ->whereRaw('find_in_set('.$this->propro.',lista_propro)');
    }

    // @phpstan-ignore-next-line
    public function otherWinnerRows(): HasMany
    {
        return $this->hasMany(static::class, 'matr', 'matr')
            ->where('ente', $this->ente)
            ->where('anno', $this->anno)
            ->where('id', '!=', $this->getKey())
            // ->where('ha_diritto', '>', 0)
            ->whereRaw('(ha_diritto>0 or posfun>=100)');
    }

    public function stabiDirigente(): HasOne
    {
        $row = $this->hasOne(StabiDirigente::class, 'stabi', 'stabi')
            ->where('repar', $this->repar)
            ->where('anno', $this->anno);

        if ($row->count() > 0) {
            return $row;
        }

        StabiDirigente::firstOrCreate(
            [
                'stabi' => $this->stabi,
                'repar' => $this->repar,
                'anno' => $this->anno,
            ]
        );

        return $this->hasOne(StabiDirigente::class, 'stabi', 'stabi')
            ->where('repar', $this->repar)
            ->where('anno', $this->anno);
        // dddx('preso');
    }

    public function options(): HasMany
    {
        return $this->hasMany(Option::class, 'year', 'anno')
            ->where('option_type', $this->type)
            ->orderBy('pos');
        /*
        ->withDefault(
            [
                'name'=>'no-set',
                'value'=>'andare a mettere in options',
            ]
        );
        */
    }

    public function mailInviate(): HasMany
    {
        return $this->hasMany(MyLog::class, 'id_tbl', 'id')
            ->where('tbl', $this->getTable())
            ->where('note', 'sendMail');
    }

    public function totStabi(): HasOne
    {
        // dddx(class_basename($this));// IndividualeDip per collegare sia organizzativa che individuale con le loro
        // relazioni

        return $this->hasOne(IndividualeTotStabi::class, 'stabi', 'stabi')
            ->where('anno', $this->anno);
    }
}
