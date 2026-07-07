<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models\Traits;

use Illuminate\Database\Eloquent\Relations
     * @return HasMany<\Modules\Progressioni\Models\CriteriOption, $this>\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
us
     * @return HasOne<\Modules\Progressioni\Models\StipendioTabellare, $this>e Illu
     * @ret
     * @return HasMany<\Modules\Progressioni\Models\CriteriEsclusione, $this>urn HasMany
     * @return HasMany<\Modules\Progressioni\Models\Assenza, $this><\Modules\Progressioni\Models\Scheda, $this>minate\Database\Eloquent\Relations
     * @return HasMany<\Modules\Performance\Models\Individuale, $this>\MorphMany;
use Illuminate\Support\Collection;
use Modules\Performance\Models\Individuale as PerformanceIndividuale;
use Modules\Progressioni\Models\Assenza;
use Modules\Progressioni\Models\CategoriaPropro;
use Modules\Progressioni\Models\CodiciAspettative;
use Modules\Progressioni\Models\Coeff;
use Modules\Progressioni\Models\CriteriEsclusione;
use Modules\Progressioni\Models\CriteriOption;
use Modules\Progressioni\Models\CriteriPrecedenza;
use Modules\Progressioni\Models\CriteriValutazione;
use Modules\Progressioni\Models\EsclusiExtra;
use Modules\Progressioni\Models\MaxCatecoPosfunAnno;
use Modules\Progressioni\Models\Message;
use Modules\Progressioni\Models\MyLog;
use Modules\Progressioni\Models\Pesi;
use Modules\Progressioni\Models\Scheda;
use Modules\Progressioni\Models\SchedaCriteri;
use Modules\Progressioni\Models\StabiDirigente;
use Modules\Progressioni\Models\StipendioTabellare;
use Modules\Progressioni\Models\Valutatore;
use Modules\Sigma\Models\Anag;
use Modules\Sigma\Models\Asz00f;
use Modules\Sigma\Models\Asz00k1;

use function Safe\date;

/**
 * Modules\Progressioni\Models\Traits\ProgressioniRelationshipTrait.
 */
trait ProgressioniRelationshipTrait
{
    /*
    public function categoriaPropro(): HasOne
    {
        return $this->hasOne(CategoriaPropro::class, 'anno', 'anno')
            ->whereRaw('find_in_set("'.$this->propro.'",lista_propro)');
    }

    */
    public function mails(): HasMany
    {
        $valutatore_id = request()->input('valutatore_id', '');
        $valutatore_id = 1;
        /**
         * @var int
         */
        $anno = request()->input('anno', date('Y'));
        $this->anno = $anno;

        return $this->hasMany(Scheda::class, 'anno', 'anno')
            ->where('valutatore_id', $valutatore_id)
            ->where('ha_diritto', 1);
    }

    public function criteriEsclusione(): HasMany
    {
        return $this->hasMany(CriteriEsclusione::class, 'anno', 'anno');
    }

    public function criteriOptions(): HasMany
    {
        return $this->hasMany(CriteriOption::class, 'anno', 'anno');
    }
/**
     * @return HasMany<\Modules\Progressioni\Models\Message, $this>
    */
    
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'anno', 'anno');
    }

    public function esclusoExtra(): HasOne
    {
        return $this->hasOne(EsclusiExtra::class, 'anno', 'anno')->where('ente', $this->ente)->where('matr', $this->matr);
    }

    public function isEsclusoExtra(): bool
    {
        return $this->esclusoExtra()->exists();
    }

    /*
    public function anag():HasOne {
        return $this->hasOne(Anag::class,'matr','matr')->where('ente',$this->ente);
    }
    */
/**
     * @return HasMany<\Modules\Progressioni\Models\SchedaCriteri, $this>
    */
        public function schedaCriteri(): HasMany
    {
        return $this->hasMany(SchedaCriteri::class, 'anno', 'anno');
    }

    public function criteriValutazione(): HasMany
    {
        return $this->hasMany(CriteriValutazione::class, 'anno', 'anno');
    }

    public function criteriPrecedenza(): HasMany
    {
        return $this->hasMany(CriteriPrecedenza::class, 'anno', 'anno');
    }

    public function coeff(): HasMany
    {
        return $this->hasMany(Coeff::class, 'anno', 'anno');
    }
/**
     * @return HasMany<\Modules\Sigma\Models\Asz00f, $this>
    */
    
    public function asz00fs(): HasMany
    {
        return $this->hasMany(Asz00f::class, 'matr', 'matr')
            ->where('ente', $this->ente)
            ->where('aszann', '')
            ->ofYear((int) $this->anno);
    }

    public function righeDoppie(): HasMany
    {
        return $this->hasMany(Scheda::class, 'anno', 'anno')
            ->where('matr', $this->matr)
            // ->where('id', '!=', $this->id)
            ->orderBy('dal');
    }

    /**
     * senza Anno .. perche' devo relazionarmi con gli ultimi 3 anni
     */
    public function performanceIndividuale(): HasMany
    {
        return $this->hasMany(PerformanceIndividuale::class, 'matr', 'matr')
            ->where('ente', $this->ente);
    }

    public function stipendioTabellare(): HasOne
    {
        return $this->hasOne(StipendioTabellare::class, 'propro', 'propro')
            ->where('posfun', $this->posfunval)
            ->where('anno', $this->anno)
            ->orderBy('ptime', 'desc'); // per avere il dato senza arrotondamenti se possibile
    }
/**
     * @return HasOne<\Modules\Progressioni\Models\StipendioTabellare, $this>
    */
    
    public function stipendioTabellareUp(): HasOne
    {
        return $this->hasOne(StipendioTabellare::class, 'propro', 'propro')
            ->where('posfun', (int) $this->posfunval + 1)
            ->where('anno', (int) $this->anno)
            ->orderBy('ptime', 'desc'); // per avere il dato senza arrotondamenti se possibile
    }

    /*
    public function myLogs(): HasMany {
        return $this->hasMany(MyLog::class, 'id_tbl', 'id')
            ->where('tbl', $this->getTable());
    }
    */
/**
     * @return MorphMany<\Modules\Progressioni\Models\MyLog, $this>
    */
    
    public function myLogs(): MorphMany
    {
        return $this->morphMany(MyLog::class, 'model');
    }

    public function mailInviate(): MorphMany
    {
        return $this->myLogs()
            ->where('note', 'sendMail');
    }

    public function maxCatecoPosfun(): HasOne
    {
        return $this->hasOne(MaxCatecoPosfunAnno::class, 'anno', 'anno')
            ->where('cateco', $this->categoria_ecoval)
            ->where('posfun', $this->posfunval);
    }

    /**
     * @return Collection<int, string>
     */
    ublic function allStabiRepars(): Collection
    {
        return $this->hasMany(StabiDirigente::class, 'anno', 'anno')
            ->pluck('nome_diri', 'id');
    }

    /*
    public function stabiDirigente(): HasOne
    {
       $row = $this->hasOne(StabiDirigente::class, 'stabi', 'stabi')
           ->where('repar', $this->repar)
           ->where('anno', $this->anno);
       if ($row->first() === null) {
           // $params = getRouteParameters();
           // extract($params);
           $tmp = StabiDirigente::firstOrCreate(['stabi' => $this->stabi, 'repar' => $this->repar, 'anno' => $this->anno]);
           $row = $this->hasOne(StabiDirigente::class, 'stabi', 'stabi')
               ->where('repar', $this->repar)
               ->where('anno', $this->anno);
       }

       return $row;
    }
*/
/**
     * @return HasOne<\Modules\Progressioni\Models\Pesi, $this>
    */
        public function pesi(): HasOne
    {
        return $this->hasOne(Pesi::class, 'anno', 'anno')
            ->whereRaw('find_in_set(?, lista_propro)', [(string) $this->propro]);
    }

    /**
     * Riga pesi criteri per anno e lista_propro (alias di `pesi()`).
     *
     * Nome allineato a Performance e a SchedaTrait (`$this->peso`).
     *
     * @return HasOne<Pesi, $this>
     */
    public function peso(): HasOne
    {
        return $this->pesi();
    }

    /*
        public function valutatore(): BelongsTo
        {
            // return $this->belongsTo(Valutatore::class);
            return $this->belongsTo(StabiDirigente::class, 'valutatore_id', 'id');
            // return $this->hasOne(StabiDirigente::class, 'id', 'valutatore_id');
        }
    */
/**
     * @return HasOne<\Modules\Progressioni\Models\StabiDirigente, $this>
    */
        public function valutatoreDefault(): HasOne
    {
        return $this->hasOne(StabiDirigente::class, 'stabi', 'stabi')
            ->where('repar', 0)
            ->where('anno', $this->anno);
    }

    /*
    public function codiciAspettative():\Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(CodiciAspettative::class, 'anno', 'anno');
        //return CodiciAspettative::where('anno',$this->anno);
    }
    */

    /**
     * Undocumented function.
     */
    public function assenze(): HasMany
    {
        return $this->hasMany(Assenza::class, 'anno', 'anno');
        // return CodiciAspettative::where('anno',$this->anno);
    }

    /**
     * @return HasMany<Asz00k1, $this>
     */
    public function aszEff(): HasMany
    {
        $lista_codici_aspettative = $this->listaCodiciAspettative();
        $asz = $this->asz()
            ->whereRaw('find_in_set(concat(asztip,"-",aszcod), ?)', [$lista_codici_aspettative]);

        return $asz;
    }
}
