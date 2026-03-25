<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Extras;

use Carbon\Carbon;
use Modules\Sigma\Datas\GgFilterData;
use Modules\Sigma\Models\Anag;
use Modules\Sigma\Models\Asz00k1;
use Modules\Sigma\Models\Qua00f;
use Modules\Sigma\Models\Qua03f;
use Modules\Sigma\Models\Rep00f;


trait FunctionExtra
{
    /**
     * Calculate the intersection of two ranges.
     *
     * @param  int  $a  Start of first range
     * @param  int  $b  End of first range
     * @param  int  $c  Start of second range
     * @param  int  $d  End of second range
     * @return array{0: int, 1: int}|false
     */
    private static function rangeIntersect(int $a, int $b, int $c, int $d): array|bool
    {
        $maxStart = max($a, $c);
        $minEnd = min($b, $d);

        if ($maxStart <= $minEnd) {
            return [$maxStart, $minEnd];
        }

        return false;
    }

    public static function getCoalesceDateRange(GgFilterData $data): string
    {
        $date_min = $data->date_min;
        $date_max = $data->date_max;
        $from_field = (string) ($data->from_field ?? 'from_field'); // Default fallback
        $to_field = (string) ($data->to_field ?? 'to_field'); // Default fallback

        if ($date_min instanceof Carbon) {
            /** @var string $date_min_int */
            $date_min_int = $date_min->format('Ymd');
            $dal =
                'if('
                .$from_field
                .'=0 or '
                .$from_field
                .'<'
                .$date_min_int
                .' ,'
                .$date_min_int
                .','
                .$from_field
                .')';
        } else {
            $dal = $from_field;
        }

        if ($date_max instanceof Carbon) {
            /** @var string $date_max_int */
            $date_max_int = $date_max->format('Ymd');
            $al =
                'if('
                .$to_field
                .'=0 or '
                .$to_field
                .'>'
                .$date_max_int
                .' ,'
                .$date_max_int
                .','
                .$to_field
                .')';
        } else {
            $al = $to_field;
        }

        /** @var string $dalTyped */
        $dalTyped = $dal;
        /** @var string $alTyped */
        $alTyped = $al;

        return 'COALESCE(sum(greatest(datediff('.$alTyped.','.$dalTyped.')+1,0)),0)';
    }

    public static function getCoalesceDateRangeByArray(array $params): string
    {
        $date_min = $params['date_min'] ?? null;
        $date_max = $params['date_max'] ?? null;
        $from_field = (string) ($params['from_field'] ?? 'from_field'); // Default fallback
        $to_field = (string) ($params['to_field'] ?? 'to_field'); // Default fallback

        if (\is_object($date_min) && $date_min instanceof Carbon) {
            $date_min = $date_min->format('Ymd');
        }

        if (\is_object($date_max) && $date_max instanceof Carbon) {
            $date_max = $date_max->format('Ymd');
        }

        if (isset($date_min) && is_string($date_min)) {
            $dal =
                'if('
                .$from_field
                .'=0 or '
                .$from_field
                .'<'
                .$date_min
                .' ,'
                .$date_min
                .','
                .$from_field
                .')';
        } else {
            $dal = $from_field;
        }

        if (isset($date_max) && is_string($date_max)) {
            $al = 'if('.$to_field.'=0 or '.$to_field.'>'.$date_max.' ,'.$date_max.','.$to_field.')';
        } else {
            $al = $to_field;
        }

        return 'COALESCE(sum(greatest(datediff('.$al.','.$dal.')+1,0)),0)';
    }

    public function ggInSedeTot(GgFilterData $data): ?int
    {
        $date_min = $data->date_min;
        $date_max = $data->date_max;
        $lista_propro = $data->lista_propro;
        $lista_propro_sup = $data->lista_propro_sup;
        $posfun = $data->posfun;
        $posiz = $data->posiz;

        // @phpstan-ignore-next-line function.alreadyNarrowedType - Method exists on some models (e.g. Asz00k1) but not all
        if (! method_exists($this, 'qua00f')) {
            return null;
        }
        /** @var \Illuminate\Database\Eloquent\Relations\HasMany<Qua00f, static> $qua00fRelation */
        $qua00fRelation = $this->qua00f();
        /** @var \Illuminate\Database\Eloquent\Builder<Qua00f> $qua00f */
        $qua00f = $qua00fRelation;

        if (is_string($lista_propro)) {
            if (is_string($lista_propro_sup)) {
                if (is_string($posfun)) {
                    $qua00f->whereRaw('(
                        (FIND_IN_SET( propro,"'
                    .(string) $lista_propro
                    .'") AND SUBSTR(posfun,-1)='
                    .substr((string) $posfun, -1)
                    .')
                        or  FIND_IN_SET(propro,"'
                    .(string) $lista_propro_sup
                    .'")
                    )');
                } else {
                    // non c'e' posfun
                    $qua00f->whereRaw('find_in_set(propro,"'.(string) $lista_propro.','.(string) $lista_propro_sup.'")');
                }
            } elseif (is_string($posfun)) {
                // non c'e' sup ma c'e' posfun
                $qua00f->whereRaw('find_in_set(propro,"'.(string) $lista_propro.'")');
                $qua00f->whereRaw('SUBSTR(posfun,-1)='.substr((string) $posfun, -1));
            } else {
                $qua00f->whereRaw('find_in_set(propro,"'.(string) $lista_propro.'")');
            }
        }

        if (is_string($posiz)) {
            $qua00f->where('posiz', (string) $posiz);
        }

        if ($date_max instanceof Carbon) {
            $qua00f->where('qua2kd', '<=', $date_max->format('Ymd'));
        }

        if ($date_min instanceof Carbon) {
            $qua00f->whereRaw('( qua2ka >='.$date_min->format('Ymd').' or qua2ka=0 )');
        }

        $select = Qua00f::getCoalesceDateRange($data);
        $qua00f->selectRaw($select.' as tot');

        $result = $qua00f->first();
        if ($result === null) {
            return null;
        }

        // Controllare che il risultato abbia la proprietà 'tot' (proprietà dinamica da selectRaw)
        $totRaw = $result->tot ?? null;
        if ($totRaw === null) {
            return null;
        }

        return (int) $totRaw;

        /* -- x debug
         * $tot=0;
         * foreach($qua00f->get() as $row){
         * $dal=$row->qua2kd;
         * if(isset($date_min)){
         * $dal=($row->qua2kd>=$date_min)?$row->qua2kd:$date_min;
         * }
         * if(isset($date_max)){
         * $al=($row->qua2ka>=$date_max || $row->qua2ka==0)?$date_max:$row->qua2ka;
         * }
         * $gg=0;
         * if($dal<=$al){
         * $gg=Carbon::parse($dal.'')->diffInDays($al.'',true)+1;
         * }
         * $tot+=$gg;
         * //echo '<br/>['.$row->qua2kd.' '.$row->qua2ka.']  ['.$dal.' - '.$al.'] ['.$gg.']';
         * }
         * return $tot;
         */
    }

    public function ggInSedeTotByArray(array $params): ?int
    {
        $date_min = $params['date_min'] ?? null;
        $date_max = $params['date_max'] ?? null;
        $lista_propro = $params['lista_propro'] ?? null;
        $lista_propro_sup = $params['lista_propro_sup'] ?? null;
        $posfun = $params['posfun'] ?? null;
        $posiz = $params['posiz'] ?? null;

        if (\is_object($date_min) && $date_min instanceof Carbon) {
            $date_min = $date_min->format('Ymd');
        }

        if (\is_object($date_max) && $date_max instanceof Carbon) {
            $date_max = $date_max->format('Ymd');
        }

        // @phpstan-ignore-next-line function.alreadyNarrowedType - Method exists on some models (e.g. Asz00k1) but not all
        if (! method_exists($this, 'qua00f')) {
            return null;
        }
        /** @var \Illuminate\Database\Eloquent\Relations\HasMany<Qua00f, static> $qua00fRelation */
        // @phpstan-ignore-next-line method.notFound - Method checked above with method_exists
        $qua00fRelation = $this->qua00f();
        /** @var \Illuminate\Database\Eloquent\Builder<Qua00f> $qua00f */
        $qua00f = $qua00fRelation;

        if (isset($lista_propro) && is_string($lista_propro)) {
            if (isset($lista_propro_sup) && is_string($lista_propro_sup)) {
                if (isset($posfun) && is_string($posfun)) {
                    $qua00f->whereRaw('(
                        (FIND_IN_SET( propro,"'
                    .$lista_propro
                    .'") AND SUBSTR(posfun,-1)='
                    .substr((string) $posfun, -1)
                    .')
                        or  FIND_IN_SET(propro,"'
                    .$lista_propro_sup
                    .'")
                    )');
                } else {
                    // non c'e' posfun
                    $qua00f->whereRaw('find_in_set(propro,"'.$lista_propro.','.$lista_propro_sup.'")');
                }
            } elseif (isset($posfun) && is_string($posfun)) {
                // non c'e' sup ma c'e' posfun
                $qua00f->whereRaw('find_in_set(propro,"'.$lista_propro.'")');
                $qua00f->whereRaw('SUBSTR(posfun,-1)='.substr((string) $posfun, -1));
            } else {
                $qua00f->whereRaw('find_in_set(propro,"'.$lista_propro.'")');
            }
        }

        if (isset($posiz) && is_string($posiz)) {
            $qua00f->where('posiz', $posiz);
        }

        if (isset($date_max) && is_string($date_max)) {
            $qua00f->where('qua2kd', '<=', $date_max);
        }

        if (isset($date_min) && is_string($date_min)) {
            $qua00f->whereRaw('( qua2ka >='.$date_min.' or qua2ka=0 )');
        }

        $select = Qua00f::getCoalesceDateRangeByArray($params);
        $qua00f->selectRaw($select.' as tot');

        $result = $qua00f->first();
        if ($result === null) {
            return null;
        }

        $totRaw = $result->tot ?? null;
        if ($totRaw === null) {
            return null;
        }

        return (int) $totRaw;
    }

    // ---------------------------------------------------------------------------------------------
    public function ggFuoriSedeTot(array $params): ?int
    {
        // These helper calculations are only valid on Anag instances,
        // which provide the required qua03f() relationship.
        if (! $this instanceof Anag) {
            return null;
        }

        $date_min = $params['date_min'] ?? null;
        $date_max = $params['date_max'] ?? null;
        $lista_propro = $params['lista_propro'] ?? null;
        $posfun = $params['posfun'] ?? null;

        if (\is_object($date_min) && $date_min instanceof Carbon) {
            $date_min = $date_min->format('Ymd');
        }

        if (\is_object($date_max) && $date_max instanceof Carbon) {
            $date_max = $date_max->format('Ymd');
        }

        /** @var \Illuminate\Database\Eloquent\Relations\HasMany<Qua03f, static> $qua */
        $qua = $this->qua03f();
        if (isset($lista_propro) && is_string($lista_propro)) {
            $qua->whereRaw('find_in_set(q3pro,"'.(string) $lista_propro.'")');
        }

        if (isset($posfun) && is_string($posfun)) {
            // if (isset($posfun) && substr($posfun, -1)!=substr($this->attributes['posfun'], -1) ) {
            $qua->whereRaw('SUBSTR(q3fun,-1)='.substr((string) $posfun, -1));
        }

        if (isset($date_max) && is_string($date_max)) {
            $qua->where('q32kd', '<=', (string) $date_max);
        }

        if (isset($date_min) && is_string($date_min)) {
            $qua->where('q32ka', '>=', (string) $date_min);
        }
        $data = GgFilterData::from($params);
        $select = Qua03f::getCoalesceDateRange($data);
        $qua->selectRaw($select.' as tot');

        $result = $qua->first();
        if ($result === null) {
            return null;
        }

        $tot = $result->tot ?? null;

        return $tot !== null ? (int) $tot : null;
    }

    // -------------------------------------------------------------------------------
    public function hhAssenzaInSedeTot(array $params): int
    {
        // These helper calculations are only valid on Anag instances,
        // which provide the required asz00k1() relationship.
        if (! $this instanceof Anag) {
            return 0;
        }

        $date_min = $params['date_min'] ?? null;
        $date_max = $params['date_max'] ?? null;
        $lista_propro = $params['lista_propro'] ?? null;
        $posfun = $params['posfun'] ?? null;
        $lista_tipo_codice = $params['lista_tipo_codice'] ?? null;

        if (\is_object($date_min) && $date_min instanceof Carbon) {
            $date_min = $date_min->format('Ymd');
        }

        if (\is_object($date_max) && $date_max instanceof Carbon) {
            $date_max = $date_max->format('Ymd');
        }

        /** @var \Illuminate\Database\Eloquent\Relations\HasMany<Asz00k1, static> $aszRelation */
        $aszRelation = $this->asz00k1();
        /** @var \Illuminate\Database\Eloquent\Builder<Asz00k1> $asz */
        $asz = $aszRelation;

        if (isset($lista_propro) && is_string($lista_propro)) {
            /*
             * $asz->whereHas('qua00f', function($query) use($lista_propro) {
             * $query->whereRaw('find_in_set(propro,"'.$lista_propro.'")');
             * });
             */
            if (isset($posfun) && is_string($posfun)) {
                /* @phpstan-ignore-next-line method.notFound - Scope method defined in Asz00k1 model */
                $asz->ofListaProproPosfun($lista_propro, $posfun);
            } else {
                /* @phpstan-ignore-next-line method.notFound - Scope method defined in Asz00k1 model */
                $asz->ofListaProproPosfun($lista_propro);
            }
        }

        // dddx($asz->get());

        $asz->where('aszumi', 'O');
        /*
         * if(isset($posfun)){
         * //if (isset($posfun) && substr($posfun, -1)!=substr($this->attributes['posfun'], -1) ) {
         * $qua00f->whereRaw('SUBSTR(posfun,-1)='.substr($posfun,-1));
         * }
         */
        if (isset($lista_tipo_codice) && is_string($lista_tipo_codice)) {
            $asz->whereRaw('find_in_set(concat(asztip,"-",aszcod),"'.(string) $lista_tipo_codice.'")');
        }

        if (isset($date_max) && is_string($date_max)) {
            $asz->where('asz2kd', '<=', (string) $date_max);
        }

        if (isset($date_min) && is_string($date_min)) {
            $asz->whereRaw('( asz2ka >='.(string) $date_min.' or asz2ka=0 )');
        }
        $data = GgFilterData::from($params);
        $select = Asz00k1::getCoalesceDateRange($data);
        $asz->selectRaw($select.' as tot');

        $result = $asz->first();
        if ($result === null) {
            return 0;
        }

        $tot = $result->tot ?? 0;

        return (int) $tot;
    }

    public function ggAssenzaInSedeTot(GgFilterData $data): int
    {
        return 0; // solo adesso per debug perche' sta causando problemi di performance
        // These helper calculations are only valid on Anag instances,
        // which provide the required asz00k1() relationship.
        if (! $this instanceof Anag) {
            return 0;
        }

        $date_min = $data->date_min;
        $date_max = $data->date_max;
        $lista_propro = $data->lista_propro;
        $lista_propro_sup = $data->lista_propro_sup;
        $posfun = $data->posfun;
        $posiz = $data->posiz;
        $lista_tipo_codice = $data->lista_tipo_codice;

        /** @var \Illuminate\Database\Eloquent\Relations\HasMany<Asz00k1, static> $aszRelation */
        $aszRelation = $this->asz00k1();
        /** @var \Illuminate\Database\Eloquent\Builder<Asz00k1> $asz */
        $asz = $aszRelation;

        if (is_string($lista_propro)) {
            /*
             * $asz->whereHas('qua00f', function($query) use($lista_propro) {
             * $query->whereRaw('find_in_set(propro,"'.$lista_propro.'")');
             * });
             */
            if (is_string($posfun)) {
                /* @phpstan-ignore-next-line method.notFound - Scope method defined in Asz00k1 model */
                $asz->ofListaProproPosfun($lista_propro, $posfun);
            } else {
                /* @phpstan-ignore-next-line method.notFound - Scope method defined in Asz00k1 model */
                $asz->ofListaProproPosfun($lista_propro);
            }
        }

        // dddx($asz->get());

        $asz->where('aszumi', 'G');
        /*
         * if(isset($posfun)){
         * //if (isset($posfun) && substr($posfun, -1)!=substr($this->attributes['posfun'], -1) ) {
         * $qua00f->whereRaw('SUBSTR(posfun,-1)='.substr($posfun,-1));
         * }
         */
        if (is_string($lista_tipo_codice)) {
            $asz->whereRaw('find_in_set(concat(asztip,"-",aszcod),"'.(string) $lista_tipo_codice.'")');
        }

        if ($date_max instanceof Carbon) {
            $asz->where('asz2kd', '<=', $date_max->format('Ymd'));
        }

        if ($date_min instanceof Carbon) {
            $asz->whereRaw('( asz2ka >='.$date_min->format('Ymd').' or asz2ka=0 )');
        }
        $select = Asz00k1::getCoalesceDateRange($data);
        $asz->selectRaw($select.' as tot');

        $result = $asz->first();
        if ($result === null) {
            return 0;
        }

        $tot = $result->tot ?? 0;

        return (int) $tot;
    }

    // -------------------------------------------------------------------------------
    /**
     * Stub method for giorni assenza fuori sede.
     * TODO: Implement actual calculation when business logic is defined.
     *
     * @param  array<string, mixed>  $params
     */
    public function ggAssenzaFuoriSedeTot(array $params): int
    {
        return 0; // da fare
    }

    /**
     * Stub method for ore assenza fuori sede.
     * TODO: Implement actual calculation when business logic is defined.
     *
     * @param  array<string, mixed>  $_params
     */
    public function hhAssenzaFuoriSedeTot(array $_params): int
    {
        return 0; // da fare
    }

    // ---------------------------------------------------------------------------------------------
    /**
     * @param  array<string, mixed>  $params
     * @return \Illuminate\Support\Collection<int, array<string, mixed>>
     */
    public static function rep00fQua00fAnnoCollection(array $params): \Illuminate\Support\Collection
    {
        // Avoid using extract() which creates dynamic variables.
        // Instead, access array elements directly.
        $anno = (int) ($params['anno'] ?? 0);

        $rep00f_coll = Rep00f::stabiReparOfYearCollection($params)->groupBy(
            static fn ($item): string => (string) ($item['ente'] ?? '').'-'.(string) ($item['matr'] ?? ''),
        );
        $qua00f_coll = Qua00f::posizioniEconomicheOfYearCollection($params)->groupBy(
            static fn ($item): string => (string) ($item['ente'] ?? '').'-'.(string) ($item['matr'] ?? ''),
        );

        // $rep00f_coll
        // ($rep00f_coll->count());//422 - 424
        // dddx($qua00f_coll->count());//422 - 426
        // dddx($perf_qua_coll);
        $ris = [];
        /** @var \Illuminate\Support\Collection<int, array<string, mixed>>|null $rep00f_collTyped */
        $rep00f_collTyped = $rep00f_coll;
        if ($rep00f_collTyped !== null) {
            foreach ($rep00f_collTyped as $k => $rep) {
                $ris[$k]['rep'] = $rep;
                $ris[$k]['qua'] = $qua00f_coll[$k] ?? null;
            }
        }

        $inizioanno = ($anno * 10000) + 101;
        $fineanno = ($anno * 10000) + 1231;

        // *
        foreach ($ris as $k => $v) {
            $vRep = $v['rep'] ?? null;
            $vQua = $v['qua'] ?? null;
            if ($vRep === null || $vQua === null) {
                continue;
            }
            if (! \is_array($vRep)) {
                continue;
            }
            if ($vQua instanceof \Illuminate\Support\Collection) {
                $vQuaArray = $vQua->all();
            } elseif (\is_array($vQua)) {
                $vQuaArray = $vQua;
            } else {
                continue;
            }
            /** @var array{rep: array<int, array<string, mixed>>, qua: array<int, array<string, mixed>>} $vTyped */
            $vTyped = ['rep' => $vRep, 'qua' => $vQuaArray];
            // if($vTyped['rep']->count()!=1 || $vTyped['qua']->count()!=1){
            foreach ($vTyped['rep'] as &$rep) {
                if (! \is_array($rep)) {
                    continue;
                }
                /** @var array<string, mixed> $repTyped */
                $repTyped = $rep;
                $repTyped['rep2kd'] = isset($repTyped['rep2kd']) ? (int) $repTyped['rep2kd'] : 0;
                $repTyped['rep2ka'] = isset($repTyped['rep2ka']) ? (int) $repTyped['rep2ka'] : 0;
                $repTyped['dal'] = $repTyped['rep2kd'] > $inizioanno ? $repTyped['rep2kd'] : $inizioanno;
                $repTyped['al'] = $repTyped['rep2ka'] < $fineanno && $repTyped['rep2ka'] !== 0 ? $repTyped['rep2ka'] : $fineanno;
                $rep = $repTyped;
                foreach ($vTyped['qua'] as $qua) {
                    if (! \is_array($qua)) {
                        continue;
                    }
                    /** @var array<string, mixed> $quaTyped */
                    $quaTyped = $qua;
                    $quaTyped['qua2kd'] = isset($quaTyped['qua2kd']) ? (int) $quaTyped['qua2kd'] : 0;
                    $quaTyped['qua2ka'] = isset($quaTyped['qua2ka']) ? (int) $quaTyped['qua2ka'] : 0;
                    $quaTyped['dal'] = $quaTyped['qua2kd'] > $inizioanno ? $quaTyped['qua2kd'] : $inizioanno;
                    $quaTyped['al'] = $quaTyped['qua2ka'] < $fineanno && $quaTyped['qua2ka'] !== 0 ? $quaTyped['qua2ka'] : $fineanno;
                    // echo '<hr/>';
                    // echo '<pre>';print_r($repTyped);echo '</pre>';
                    // echo '<pre>';print_r($quaTyped);echo '</pre>';
                    /** @var int $repDal */
                    $repDal = $repTyped['dal'];
                    /** @var int $repAl */
                    $repAl = $repTyped['al'];
                    /** @var int $quaDal */
                    $quaDal = $quaTyped['dal'];
                    /** @var int $quaAl */
                    $quaAl = $quaTyped['al'];
                    $intersect = app(\Modules\Xot\Actions\Array\RangeIntersectAction::class)->execute($repDal, $repAl, $quaDal, $quaAl);
                    // echo '<pre>';print_r($intersect);echo '</pre>';
                    if ($intersect !== false && \is_array($intersect)) {
                        /** @var array<int, int> $intersectTyped */
                        $intersectTyped = $intersect;
                        $tmp = array_merge($repTyped, $quaTyped);
                        unset($tmp['dal'], $tmp['al']);
                        // per visualizzazione per spostarli in ultima posizione
                        $tmp['dal'] = $intersectTyped[0];
                        $tmp['al'] = $intersectTyped[1];
                        if (! isset($ris[$k]['merge'])) {
                            $ris[$k]['merge'] = [];
                        }
                        /** @var array<int, array<string, mixed>> $mergeArray */
                        $mergeArray = $ris[$k]['merge'];
                        $mergeArray[] = $tmp;
                        $ris[$k]['merge'] = $mergeArray;
                        //
                        // if($v['rep']->count()!=1 || $v['qua']->count()!=1){
                        // echo '<br/>Check '.$k.' ';
                        // }
                        // /
                        if ($tmp['dal'] !== $inizioanno || $tmp['al'] !== $fineanno) {
                            // echo '<pre>';print_r($tmp);echo '</pre>';
                        }
                    }
                }
            }

            if (isset($ris[$k]['merge']) && \count($ris[$k]['merge']) !== 1) {
                echo '<br/>Multi Riga '.$k.' ';
            }

            // }
        }

        // */
        /*
         * $ris=collect($ris)->map(
         * function($v) use($inizioanno,$fineanno){
         * $rows=[];
         * foreach ($v['rep'] as $rep) {
         * $rep['rep2kd']=(int)$rep['rep2kd'];
         * $rep['rep2ka']=(int)$rep['rep2ka'];
         * $rep['dal'] = ($rep['rep2kd'] > $inizioanno) ? $rep['rep2kd'] : $inizioanno;
         * $rep['dal'] =(int)$rep['dal'];
         * $rep['al'] = ($rep['rep2ka'] < $fineanno && 0 !== $rep['rep2ka']) ? $rep['rep2ka'] : $fineanno;
         * $rep['al'] =(int)$rep['al'];
         * $items=[];
         * foreach ($v['qua'] as $qua) {
         * $qua['qua2kd']=(int)$qua['qua2kd'];
         * $qua['qua2ka']=(int)$qua['qua2ka'];
         * $qua['dal'] = ($qua['qua2kd'] > $inizioanno) ? $qua['qua2kd'] : $inizioanno;
         * $qua['dal'] =(int)$qua['dal'];
         * $qua['al'] = ($qua['qua2ka'] < $fineanno && 0 !== $qua['qua2ka']) ? $qua['qua2ka'] : $fineanno;
         * $qua['al'] =(int)$qua['al'];
         * $intersect = ArrayService::rangeIntersect($rep['dal'], $rep['al'], $qua['dal'], $qua['al']);
         *
         * //dddx([
         * //    'intersect'=>$intersect,
         * //    'rep'=>$rep['dal'].'-'.$rep['al'].'   -   '.$rep['rep2kd'].'-'.$rep['rep2ka'],
         * //    'qua'=>$qua['dal'].'-'.$qua['al'].'   -   '.$qua['qua2kd'].'-'.$qua['qua2ka'],
         * //]);
         *
         * if (false !== $intersect) {
         * $item=array_merge($rep,$qua);
         * [$item['dal'],$item['al']]=$intersect;
         * $items[]=$item;
         * }
         * }
         * $rows[]=$items;
         * }
         * return $rows;
         * }
         * );
         */
        // dddx($ris);
        // dddx($ris['90-23539']);
        // return $ris;
        $ris2 = [];
        foreach ($ris as $ri) {
            if (isset($ri['merge'])) {
                $ris2 = array_merge_recursive($ris2, $ri['merge']);
            }
        }

        /** @var \Illuminate\Support\Collection<int, array<string, mixed>> $result */
        $result = collect($ris2)->values()->map(static function ($item): array {
            if (! \is_array($item)) {
                return [];
            }
            /** @var array<string, mixed> $itemTyped */
            $itemTyped = $item;

            return $itemTyped;
        });

        return $result;
    }

    // end function
    // ---------------------------------------------------------------------------------------------------------
    public static function updateFieldQuaRepForm(array $params): void
    {
        if (! isset($params['ente'])) {
            $params['ente'] = 90;
        }

        $anno = $params['anno'] ?? null;
        $annoStr = is_null($anno) ? '' : (string) $anno;
        echo '<h3>Anno: '.$annoStr.'</h3>';

        // Instead of using extract, access array elements directly
        $create_force = $params['create_force'] ?? null;
        $delete_force = $params['delete_force'] ?? null;

        $called_class = static::class;
        $self = new $called_class;
        echo '<h3>'.$called_class.'</h3>';
        $count = $self->where('anno', $anno)->count();
        echo '<h3>'.$count.'</h3>';

        // $this->fixRep($params);
        // $this->fixQua($params);
        /** @var array<string, mixed> $paramsTyped */
        $paramsTyped = $params;
        /** @var \Illuminate\Support\Collection<int, array<string, mixed>> $rows_coll */
        $rows_coll = Anag::rep00fQua00fAnnoCollection($paramsTyped);

        $first_row = $rows_coll->first();
        /** @var array<string, mixed>|null $firstRowTyped */
        $firstRowTyped = $first_row;
        /** @var array<int, string> $fields */
        $fields = is_null($firstRowTyped) ? [] : array_keys($firstRowTyped);
        echo '<pre>'.implode(', ', $fields).'</pre>';
        $perf = self::where('anno', $anno)
            // ->select($fields)
            ->get();

        /**
         * se trasformo in array, mi va a prendere tutti i mutators.
         */
        // $perf_coll = collect($perf->toArray())->map(
        $perf_coll = $perf->map(static function ($item) use ($fields): array {
            $tmp = [];
            foreach ($fields as $field) {
                $tmp[$field] = $item->{$field} ?? $item[$field] ?? null;
            }

            return $tmp;

            /* return collect($item)->only($fields)->all(); */
        });
        // dddx($perf_coll);

        // Cannot instantiate abstract class Modules\Performance\Models\BaseIndividualeModel
        // dddx(['get_called_class'=>get_called_class(),
        //    'self'=>new self(),
        //    ]);
        // *

        /** @var array<int, array<string, mixed>> $rowsArray */
        $rowsArray = $rows_coll->all();
        /** @var array<int, array<string, mixed>> $perfArray */
        $perfArray = $perf_coll->all();
        /** @var array<int, array<string, mixed>> $rows_coll_all */
        $rows_coll_all = $rows_coll->all();
        /** @var array<int, array<string, mixed>> $perf_coll_all */
        $perf_coll_all = $perf_coll->all();

        $results = app(\Modules\Xot\Actions\Array\DiffAssocRecursiveAction::class)->execute($rows_coll_all, $perf_coll_all);

        /** @var array<int, array<string, mixed>> $resultsTyped */
        $resultsTyped = \is_array($results) ? $results : [];
        echo '<h3> Fix Add :'.\count($resultsTyped).'</h3>';

        echo '<pre>';
        print_r($results);

        echo '</pre>';

        foreach ($resultsTyped as $v) {
            if (! \is_array($v)) {
                continue;
            }
            /** @var array<string, mixed> $vTyped */
            $vTyped = $v;
            // ------- CREATE SOLO A MANO NON LAVATRICE PER OVII MOTIVI
            // SE DB SIGMA NO AGGIORNATO BAGNO DI SANGUE

            if (isset($create_force) && $create_force === '1') {
                // echo '<h3>FORCE</h3>';
                // $self = new self();
                $called_class = static::class;
                $self = new $called_class;
                $fillable = $self->getFillable();
                /** @var array<string, mixed> $vTypedForKeys */
                $vTypedForKeys = $vTyped;
                $diff = collect(array_keys($vTypedForKeys))->diff($fillable);
                if ($diff->count() > 0) {
                    dddx([
                        'message' => 'mancano campi nei fillable',
                        'class' => $self::class,
                        'fillable mancanti' => $diff,
                    ]);
                }

                /*
                 * dddx([
                 * 'fill'=>$fillable,
                 * 'class'=>get_class($test),
                 * 'v'=>$v,
                 * 'test'=>$test,
                 * ]);
                 */
                $test = self::updateOrCreate($vTyped);

                // dddx(['test'=>$test,'v'=>$v,'test_array'=>$test->toArray()]);
            }

            // Gestisci valori null in modo sicuro
            $v_matr = $v['matr'] ?? null;
            $v_dal = $v['dal'] ?? null;

            if ($v_matr !== null && $v_dal !== null) {
                $i_row = $rows_coll->where('matr', $v_matr)->where('dal', $v_dal)->all();
                $i_perf = $perf_coll->where('matr', $v_matr)->where('dal', $v_dal)->all();

                foreach ($i_row as $i_row0) {
                    foreach ($i_perf as $i_perf0) {
                        $diff = collect($i_row0)->diffAssoc($i_perf0)->all();
                        if ($diff !== []) {
                            echo '<hr/>';
                            echo '<pre>';
                            print_r($i_row0);
                            echo '</pre>';
                            echo '<pre>';
                            print_r($i_perf0);
                            echo '</pre>';
                            echo '<pre>';
                            print_r($diff);
                            echo '</pre>';
                            // dddx($v);
                            // $up = new self();
                            /** @var \Illuminate\Database\Eloquent\Builder<static> $up */
                            $up = static::query();
                            foreach ($i_perf0 as $ku => $vu) {
                                if (! \is_string($ku)) {
                                    continue;
                                }
                                $up = $up->where($ku, $vu);
                            }

                            /** @var array<string, mixed> $diffTyped */
                            $diffTyped = $diff;
                            $up->update($diffTyped);
                        } // end if
                    }
                }
            }

            // dddx($up->get());
        }

        // */

        /** @var array<int, array<string, mixed>> $perfArray2 */
        $perfArray2 = $perf_coll->all();
        /** @var array<int, array<string, mixed>> $rowsArray2 */
        $rowsArray2 = $rows_coll->all();
        $results2 = app(\Modules\Xot\Actions\Array\DiffAssocRecursiveAction::class)->execute($perfArray2, $rowsArray2);
        echo '<h3> Fix Sub :'.\count($results2).'</h3>';
        echo '<pre>';
        print_r($results2);
        echo '</pre>';
        foreach ($results2 as $v2) {
            if (! \is_array($v2)) {
                continue;
            }
            /** @var array<string, mixed> $v2Typed */
            $v2Typed = $v2;
            // ------- DELETE SOLO A MANO NON LAVATRICE PER OVII MOTIVI
            // SE DB SIGMA NO AGGIORNATO BAGNO DI SANGUE
            if (isset($delete_force) && $delete_force === '1') {
                $test = self::where($v2Typed)->limit(1)->delete();
            }

            // Gestisci valori null in modo sicuro
            $v2_matr = $v2Typed['matr'] ?? null;
            $v2_dal = $v2Typed['dal'] ?? null;

            if ($v2_matr !== null && $v2_dal !== null) {
                $i_row = $rows_coll->where('matr', $v2_matr)->where('dal', $v2_dal)->all();
                $i_perf = $perf_coll->where('matr', $v2_matr)->where('dal', $v2_dal)->all();

                foreach ($i_row as $i_row0) {
                    foreach ($i_perf as $i_perf0) {
                        $diff = collect($i_row0)->diffAssoc($i_perf0)->all();
                        if ($diff !== []) {
                            echo '<hr/>';
                            echo '<pre>';
                            print_r($i_row0);
                            echo '</pre>';
                            echo '<pre>';
                            print_r($i_perf0);
                            echo '</pre>';
                            echo '<pre>';
                            print_r($diff);
                            echo '</pre>';

                            // dddx($v);
                            /*
                             * $up=new self;
                             * foreach($i_perf0 as $ku => $vu){
                             * $up=$up->where($ku,$vu);
                             * }
                             * $up->update($diff);
                             * //*/
                        } // end if
                    }
                }
            }

            // dddx($up->get());
        }

        // dddx($fields);
        /** @var array<int, string> $fieldsTyped */
        $fieldsTyped = $fields;
        $double = self::where('anno', $anno)
            ->groupBy($fieldsTyped)
            ->havingRaw('COUNT(*) > 1')
            ->get();
        echo '<h3> Double Sub :'.\count($double).'</h3>';
        foreach ($double as $v) {
            echo '<hr><pre>';
            /** @var array<string, mixed> $onlyFields */
            $onlyFields = [];
            foreach ($fieldsTyped as $field) {
                if (! \is_string($field)) {
                    continue;
                }
                $onlyFields[$field] = $v->{$field} ?? null;
            }
            print_r($onlyFields);
            echo '</pre>';
        }

        // dddx($double);
        // dddx($results);
        echo '<hr/>';
        $url = \Request::fullUrlWithQuery(['create_force' => '1']);
        echo '|<a href="'.$url.'" class="btn btn-danger">
                <i class="fas fa-fist-raised"></i>Force Create
            </a>';
        $url = \Request::fullUrlWithQuery(['delete_force' => '1']);
        echo '|<a href="'.$url.'" class="btn btn-danger">
                <i class="fas fa-fist-raised"></i>Force Delete
            </a>';
        echo '<hr/>';
    }

    // -------------------------------------------------------------------------------------------------------
    public function addTableField(array $params): void
    {
        $table = $this->getTable();
        $conn = $this->getConnection();
        $fieldname = $params['name'] ?? '';
        if (! is_string($fieldname) || $fieldname === '') {
            return;
        }

        if (! \Schema::connection($conn->getName())->hasColumn($table, $fieldname)) {
            $fieldType = $params['type'] ?? 'string';
            if (! is_string($fieldType)) {
                $fieldType = 'string';
            }

            /** @var non-empty-string $fieldNameTyped */
            $fieldNameTyped = $fieldname;
            /** @var string $fieldTypeTyped */
            $fieldTypeTyped = $fieldType;

            // Using a more explicit approach instead of extract() to avoid dynamic variable creation
            \Schema::connection($conn->getName())->table($table, static function (\Illuminate\Database\Schema\Blueprint $table) use ($fieldTypeTyped, $fieldNameTyped): void {
                // Add field based on the type
                switch ($fieldTypeTyped) {
                    case 'string':
                        $table->string($fieldNameTyped);
                        break;
                    case 'integer':
                        $table->integer($fieldNameTyped);
                        break;
                    case 'text':
                        $table->text($fieldNameTyped);
                        break;
                    case 'boolean':
                        $table->boolean($fieldNameTyped);
                        break;
                    case 'date':
                        $table->date($fieldNameTyped);
                        break;
                    case 'datetime':
                        $table->dateTime($fieldNameTyped);
                        break;
                    case 'timestamp':
                        $table->timestamp($fieldNameTyped);
                        break;
                    default:
                        $table->string($fieldNameTyped);
                        break;
                }
            });
        }
    }
} // end class
