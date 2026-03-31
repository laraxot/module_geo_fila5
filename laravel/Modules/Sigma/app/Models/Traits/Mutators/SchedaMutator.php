<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Mutators;

use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Modules\Sigma\Models\Codici;
use Modules\Sigma\Models\Traits\Helpers\SchedaHelper;

/**
 * SchedaMutator - Accessor (get*Attribute) per Scheda.
 *
 * Responsabilità: Orchestrazione accessor (cache, guard, delega a helper, persist).
 * Delega calcoli puri a SchedaHelper.
 * Include CommonMutator per mutator generici (delegation cascade).
 *
 * @see SchedaHelper
 * @see CommonMutator
 */
trait SchedaMutator
{
    // Helper puri (calcoli)
    use CommonMutator; // Mutator comuni (delegato da SchedaTrait)
    use EnteMatrAnnoMutator; // Mutator ente+matr+anno (delegato da SchedaTrait)
    use EnteMatrDateRangeMutator; // Mutator ente+matr+daterange (delegato da SchedaTrait)
    use EnteMatrMutator; // Mutator ente+matr (delegato da SchedaTrait)
    use EnteStabiMutator; // ⚡ DELEGATION CASCADE
    use SchedaHelper; // Mutator ente+stabi (delegato da SchedaTrait)

    protected function getCodquaAttribute(): ?string
    {
        // Get the raw value from attributes
        $value = $this->attributes['codqua'] ?? null;
        if ($value !== null) {
            return (string) $value;
        }

        // ✅ Check: record deve esistere prima di save()
        if ($this->getKey() == null) {
            return null;
        }

        $fieldname = 'codqua';

        if ($this->qua2kd === '') {
            return null;
        }

        $qua00f = $this->qua00f->where('qua2kd', $this->qua2kd)->first();
        /*
         * }else{
         * $qua00f = $this->qua00f()->ofYear($this->anno);
         * if($qua00f->count()!=1){
         * dddx('Matricola non trovata nella tabella qua00f aggiornare');
         * }
         * $qua00f=$qua00f->first();
         * $this->qua2kd=$qua00f->qua2kd;
         * $this->qua2ka=$qua00f->qua2ka;
         * $this->save();
         * }
         */
        if (! \is_object($qua00f)) {
            $msg = [
                'qua2kd' => $this->qua2kd,
                'dal' => $this->dal,
            ];

            // dddx($msg);
            return null;
        }

        $value = $qua00f->$fieldname;

        // @phpstan-ignore notIdentical.alwaysTrue
        if ($this->getKey() !== null) {
            $this->update([
                $fieldname => $value,
                'cont' => $qua00f->cont,
                'tipco' => $qua00f->tipco,
            ]);
        }

        return (string) $value;
    }

    protected function getContAttribute(): mixed
    {
        $value = $this->attributes['cont'] ?? null;
        if ($value !== null) {
            return $value;
        }

        // ✅ Check: record deve esistere prima di save()
        if ($this->getKey() == null) {
            return null;
        }

        $fieldname = 'cont';
        if ($this->qua2kd === '') {
            return null;

            /*
             * $qua00f = $this->qua00f()->ofYear($this->anno);
             * if($qua00f->count()!=1){
             * dddx('Matricola non trovata nella tabella qua00f aggiornare');
             * }
             * $qua00f=$qua00f->first();
             * $this->qua2kd=$qua00f->qua2kd;
             * $this->qua2ka=$qua00f->qua2ka;
             * $this->save();
             */
        }

        $qua00f = $this->qua00f->where('qua2kd', $this->qua2kd)->first();
        if (! \is_object($qua00f)) {
            return null;
        }

        $value = $qua00f->$fieldname;
        if (\in_array($fieldname, $this->getFillable(), false)) {
            $this->$fieldname = $value;

            // Guard: modello deve avere PK per salvare
            // @phpstan-ignore notIdentical.alwaysTrue
            if ($this->getKey() !== null) {
                $this->update([$fieldname => $value]);
            }
        }

        return $value;
    }

    protected function getTipcoAttribute(): mixed
    {
        $value = $this->attributes['tipco'] ?? null;
        if ($value !== null) {
            return $value;
        }

        // ✅ Check: record deve esistere prima di save()
        if ($this->getKey() == null) {
            return null;
        }

        $fieldname = 'tipco';
        $qua00f = $this->qua00f->where('qua2kd', $this->qua2kd)->first();
        if (! ($qua00f instanceof \Modules\Sigma\Models\Qua00f)) {
            return null;
        }

        $value = $qua00f->$fieldname ?? null;
        if ($value === null) {
            return null;
        }
        // @phpstan-ignore notIdentical.alwaysTrue
        if ($this->getKey() !== null) {
            $this->update([$fieldname => $value]);
        }

        return is_numeric($value) ? (int) $value : (string) $value;
    }

    protected function getPosizioneEcoAttribute(?string $value): ?string
    {
        if ($value !== null && ! request('refresh', false)) {
            return $value;
        }

        // ✅ Check: record deve esistere prima di save()
        if ($this->getKey() == null) {
            return null;
        }

        $fieldname = 'posizione_eco';
        $tqu00f = $this->tqu00f;
        if (! \is_object($tqu00f)) {
            /*
             * if($this->propro==''){
             * $qua00f = $this->qua00f->where('qua2kd', $this->qua2kd)->first();
             * $this->qua2kd=$qua00f->qua2kd;
             * $this->qua2ka=$qua00f->qua2ka;
             * $this->propro=$qua00f->propro;
             * $this->posfun=$qua00f->posfun;
             * $this->tipco=$qua00f->tipco;
             * $this->cont=$qua00f->cont;
             * $this->codqua=$qua00f->codqua;
             * $this->save();
             * }
             */
            /** @var string $propro */
            $propro = is_numeric($this->propro) ? (string) $this->propro : (string) ($this->propro ?? '');
            /** @var string $posfun */
            $posfun = is_numeric($this->posfun) ? (string) $this->posfun : (string) ($this->posfun ?? '');
            /** @var string $tipco */
            $tipco = is_numeric($this->tipco) ? (string) $this->tipco : (string) ($this->tipco ?? '');
            /** @var string $cont */
            $cont = is_numeric($this->cont) ? (string) $this->cont : (string) ($this->cont ?? '');
            /** @var string $codqua */
            $codqua = is_numeric($this->codqua) ? (string) $this->codqua : (string) ($this->codqua ?? '');
            echo 'propro:['
                .$propro
                    .'] posfun:['
                    .$posfun
                    .'] tipco:['
                    .$tipco
                    .'] cont:['
                    .$cont
                    .'] codqua: ['
                    .$codqua
                    .']';

            return null; // 'propro:['.$this->propro.'] posfun:['.$this->posfun.'] tipco:['.$this->tipco.'] cont:['.$this->cont.'] codqua: ['.$this->codqua.']';
        }

        if (! ($tqu00f instanceof \Modules\Sigma\Models\Tqu00f)) {
            return null;
        }
        $desc1 = $tqu00f->desc1 ?? '';
        $desc2 = $tqu00f->desc2 ?? '';
        $value = str_replace('Posizione economica', '', (string) $desc1);
        $value .= ' ('.$desc2.')';
        /*
         * if (in_array($fieldname, $this->getFillable())) {
         * $this->$fieldname = $value;
         * $this->save();
         * }
         */
        try {
            $this->$fieldname = $value;

            // Guard: modello deve avere PK per salvare
            // @phpstan-ignore notIdentical.alwaysTrue
            if ($this->getKey() !== null) {
                $this->update([$fieldname => $value]);
            }
        } catch (\Exception $e) {
            // Log the error but don't break the application
            Log::warning('Failed to save field in SchedaMutator', [
                'field' => $fieldname,
                'model' => $this::class,
                'error' => $e->getMessage(),
            ]);
        }

        return $value;
    }

    protected function getPercParttimepondAnnoAttribute(?float $value = null): ?float
    {
        // Get raw value if not provided
        $rawValue = $this->attributes['perc_parttime_pond_anno'] ?? null;
        $value = $value ?? ($rawValue !== null && is_numeric($rawValue) ? (float) $rawValue : null);
        if ($value !== null) {
            return $value;
        }

        // ✅ Check: record deve esistere prima di save()
        if ($this->getKey() == null) {
            return null;
        }

        // */
        $value = 0;
        if ($this->gg_presenza_anno != 0) {
            $value = $this->perc_parttime_anno * (1 - ($this->gg_parttimevert_anno / $this->gg_presenza_anno));
        }

        // $value = number_format($value, 3);
        $this->perc_parttimepond_anno = $value;

        // Guard: modello deve avere PK per salvare
        // @phpstan-ignore notIdentical.alwaysTrue
        if ($this->getKey() !== null) {
            $this->update(['perc_parttimepond_anno' => $value]);
        }

        return (float) $value;
    }

    protected function getPercParttimepondDalalAttribute(): ?float
    {
        // Get raw value from attributes
        $rawValue = $this->attributes['perc_parttime_pond_dalal'] ?? null;
        $value = $rawValue !== null && is_numeric($rawValue) ? (float) $rawValue : null;
        if ($value !== null) {
            return $value;
        }

        // ✅ Check: record deve esistere prima di save()
        if ($this->getKey() == null) {
            return null;
        }

        // */
        $value = 0;
        if ($this->gg_presenza_dalal !== 0) {
            $value = $this->perc_parttime_dalal * (1 - ($this->gg_parttimevert_dalal / $this->gg_presenza_dalal));
        }

        // $value = number_format($value, 3);
        $this->perc_parttimepond_dalal = $value;

        // Guard: modello deve avere PK per salvare
        // @phpstan-ignore notIdentical.alwaysTrue
        if ($this->getKey() !== null) {
            $this->update(['perc_parttimepond_dalal' => $value]);
        }

        return $value;
    }

    protected function getDisci1TxtAttribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }

        // ✅ Check: record deve esistere prima di save()
        if ($this->getKey() == null) {
            return null;
        }

        if ($this->disci1 == null) {
            return null;
        }

        $row = Codici::where('tipo', 6)->where('codice', $this->disci1)->first();
        if (! \is_object($row)) {
            return null;
        }

        try {
            $this->disci1_txt = $row->desc1;

            // Guard: modello deve avere PK per salvare
            // @phpstan-ignore notIdentical.alwaysTrue
            if ($this->getKey() !== null) {
                $this->update(['disci1_txt' => $row->desc1]);
            }
        } catch (\Exception) {
            $fieldname = 'disci1_txt';
            if (! Schema::connection($this->getConnectionName())->hasColumn($this->getTable(), $fieldname)) {
                Schema::connection($this->getConnectionName())->table($this->getTable(), static function (\Illuminate\Database\Schema\Blueprint $table) use (
                    $fieldname,
                ): void {
                    $table->string($fieldname);
                });
            }
        }

        return isset($this->attributes['disci1_txt']) && is_string($this->attributes['disci1_txt']) ? $this->attributes['disci1_txt'] : null;
    }

    protected function getPosizTxtAttribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }

        // ✅ Check: record deve esistere prima di save()
        if ($this->getKey() == null) {
            return null;
        }

        if ($this->posiz == null) {
            return null;
        }

        $row = Codici::firstWhere(['tipo' => 19, 'codice' => $this->posiz]);
        if (! \is_object($row)) {
            return null;
        }

        // ⚠️ DO NOT call update() inside accessor - causes infinite loop
        // Just set the raw attribute value without triggering events
        $this->attributes['posiz_txt'] = $row->desc1;

        return isset($this->attributes['posiz_txt']) && is_string($this->attributes['posiz_txt']) ? $this->attributes['posiz_txt'] : null;
    }

    protected function getDisci1Attribute(?int $value): ?int
    {
        if ($value != null && ! request()->input('refresh', false)) {
            return $value;
        }
        $qua00fRelation = $this->qua00fDaterange();
        if ($qua00fRelation === null) {
            return null;
        }
        $qua00f_curr = $qua00fRelation->first();
        if (! ($qua00f_curr instanceof \Modules\Sigma\Models\Qua00f)) {
            return null;
        }

        // Access to disci1 property via getAttribute for type safety
        $value = is_numeric($qua00f_curr->getAttribute('disci1')) ? (int) $qua00f_curr->getAttribute('disci1') : null;
        if ($value === null) {
            return null;
        }

        // ⚠️ DO NOT call update() inside accessor - may causes infinite loop
        // Just set the raw attribute value without triggering events
        $this->attributes['disci1'] = $value;
        if($this->getKey()!=null){
            $this->update(['disci1'=>$value]);
        }

        return $value;
    }

    protected function getCategoriaEcovalAttribute(?string $value): ?string
    {
        if ($value != null && ! request()->input('refresh', false)) {
            return $value;
        }
        if ($this->matr == null) {
            return null;
        }
        if ($this->propro == null) {
            return null;
        }

        $categoria_propro = $this->categoriaPropro;
        $value = $categoria_propro?->getAttribute('categoria');

        // ⚠️ DO NOT call update() inside accessor - causes infinite loop
        // Just set the raw attribute value without triggering events
        $this->attributes['categoria_ecoval'] = $value;

        return $value === null ? null : (string) $value;
    }

    protected function getPosizAttribute(?int $value = null): ?int
    {
        // Get raw value if not provided
        $rawValue = $this->attributes['posiz'] ?? null;
        $value = $value ?? ($rawValue !== null && is_numeric($rawValue) ? (int) $rawValue : null);
        if ($value !== null) {
            return $value;
        }

        // ✅ Check: record deve esistere prima di save()
        if ($this->getKey() == null) {
            return null;
        }

        $qua00f = $this->qua00f;
        if ($qua00f === null) {
            dddx('errore');
        }

        if ($qua00f->count() !== 1) {
            // dddx($qua00f);
            $arr = collect($qua00f)->map(static fn ($item): array => [
                'propro' => $item->propro,
                'posfun' => $item->posfun,
            ]);

            // foreach($arr as $i){
            // }
            // dddx($arr->count());
        }

        $value = $qua00f->first()?->getAttribute('posiz');

        // ⚠️ DO NOT call update() inside accessor - causes infinite loop
        // Just set the raw attribute value without triggering events
        $this->attributes['posiz'] = $value;

        return $value === null ? null : (int) $value;
    }

    protected function getEtaAttribute(?float $value): ?float
    {
        if ($value !== null && $value > 0 && ! request()->input('refresh', 0)) {
            return $value;
        }

        // ✅ Check: record deve esistere prima di save()
        if ($this->getKey() == null) {
            return null;
        }

        $ana02f = $this->ana02f;
        if ($ana02f === null) {
            dddx([
                'get_class' => static::class,
                'this' => $this->toArray(),
                'ana02f' => $this->ana02f(),
            ]);
        }

        if ($ana02f->last() === null) {
            return 0;
        }

        $ana2kd = $ana02f->last()->ana2kd;

        $ana2kd_date = Date::createFromFormat('Ymd', $ana2kd);
        $date_max = $this->criteriOptionsArr('data_presenza_al');

        // Verifica che $date_max sia una Carbon instance
        if (! ($date_max instanceof \Carbon\Carbon)) {
            $this->eta = 0.0;
            if ($this->getKey() != null) {
                $this->update(['eta' => 0.0]);
            }

            return 0.0;
        }

        // floatDiffInYears non esiste, usare diffInYears con calcolo float
        $daysDiff = $date_max->diffInDays($ana2kd_date, true);
        $value = $daysDiff / 365.25; // Conversione giorni in anni con anni bisestili

        // $value è sempre float perché $daysDiff è int e la divisione per float restituisce float
        $valueFloat = abs((float) $value);
        $this->eta = $valueFloat;

        // Guard: modello deve avere PK per salvare
        $key = $this->getKey();
        // @phpstan-ignore-next-line notIdentical.alwaysTrue
        if ($key !== null) {
            $this->update(['eta' => $valueFloat]);
        }

        return $valueFloat;
    }

    /*
     * public function getPosizTxtAttribute(): void {
     * if (null !== $value) {
     * return $value;
     * }
     *
     * $row = Codici::where('tipo', 19)->where('codice', $this->posiz)->first();
     * if (! \is_object($row)) {
     * return null;
     * }
     *
     * $this->attributes['posiz_txt'] = $row->desc1;
     * $this->save();
     *
     * return $this->attributes['posiz_txt'];
     * }
     */
    /* esempio trimestrale
     * public function getDalAttribute(): void {
     * if ($value != '') {
     * return $value;
     * }
     * $value = $this->anno * 10000 + 101;
     * $this->dal=$value;
     * $this->save();
     * return $value;
     * }
     *
     * public function getAlAttribute(): void {
     * if ($value != '') {
     * return $value;
     * }
     * $value = $this->anno * 10000 + 1231;
     * $this->al=$value;
     * $this->save();
     * return $value;
     * }
     */
    // *
    // */
    public function getWorkerType(): string
    {
        
        if ($this->isPo()) {
            return 'po';
        }
        if ($this->isRegionale()) {
            return 'regionale';
        } 
        return 'dip';
    }


    public function getTypeAttribute(?string $value): string
    {
        
        if($value!=null){
           return $value;
        }
        $value=$this->getWorkerType();
       
        if ($this->getKey() !== null) {
            static::withoutEvents(function () use ($value): void {
                //$this->update(['type' => $value]);
                $this->attributes['type'] = $value;
                $this->save();
            });
        }
        return $value;
    }
}
