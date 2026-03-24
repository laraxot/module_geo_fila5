<?php

declare(strict_types=1);

namespace Modules\Performance\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Modules\Performance\Models\Individuale;
use Modules\Sigma\Datas\GgFilterData;

/**
 * @template TModel of Model
 */
trait MutatorTrait
{
    /**
     * Guard against recursive updates from accessors.
     * Prevents "attributeRawValues null" crash with spatie/activitylog:
     * accessor → update() → LogsActivity reads attributes → accessor again → crash.
     */
    private static bool $isUpdatingFromAccessor = false;

    public function getGgAssenzaDalalAttribute(?int $value): ?int
    {
        // /*
        if ($value !== null) {
            return $value;
        }
        // */

        // ✅ Check: record deve esistere prima di save()
        if ($this->getKey() == null) {
            return null;
        }

        $lista_tipo_codice_assenze = $this->listaTipoCodiceAssenze();

        $date_min = $this->dal;
        $date_max = $this->al;

        // Guard: invalid date range prevents SQL errors
        if ($date_min === '' || $date_max === '' || $date_min === null || $date_max === null) {
            return 0;
        }

        // Guard: empty lista_tipo_codice_assenze prevents invalid SQL: IN ()
        if (empty($lista_tipo_codice_assenze)) {
            $int_value = 0;

            // ✅ Persist con update chirurgico (salva SOLO questo campo, previene loop)
            // PHPStan: getKey() può restituire null, ma qui il tipo è già ristretto
            /** @var int|string|null $key */
            $key = $this->getKey();
            if ($key !== null) {
                // Prevent recursive activitylog crash
                if (! static::$isUpdatingFromAccessor) {
                    static::$isUpdatingFromAccessor = true;
                    try {
                        static::withoutEvents(function () use ($int_value): void {
                            $this->update(['gg_assenza_dalal' => $int_value]);
                        });
                    } finally {
                        static::$isUpdatingFromAccessor = false;
                    }
                }
            }

            return $int_value;
        }

        $arr = Arr::map($lista_tipo_codice_assenze, function ($item): string {
            /** @var string $item */
            return "'{$item}'";
        });
        $list = implode(',', $arr);

        $asz00k1s = $this->asz00k1()
            // ->whereIn('aszcod', $lista_tipo_codice_assenze)
            ->whereRaw("CONCAT(asztip, '-', aszcod) IN (".$list.')')
            // ->selectRaw('COALESCE(sum(aszdur*1),0) as aszdur_sum')
            ->selectRaw('COALESCE(sum(CAST(aszdur AS DECIMAL(10,2))),0) as aszdur_sum')
            ->whereBetween('asz2kd', [$date_min, $date_max])
        // ->withDays($date_min, $date_max)
            ->where('aszumi', 'G')

            ->first();
        // ->sum('aszdur')

        // ✅ isset() invece di property_exists() - funziona per attributi magici Eloquent
        $aszdur_sum = (is_object($asz00k1s) && isset($asz00k1s->aszdur_sum)) ? $asz00k1s->aszdur_sum : 0;
        $int_value = (int) $aszdur_sum;

        // ✅ Persist con update chirurgico (salva SOLO questo campo, previene loop)
        // PHPStan: getKey() può restituire null, ma qui il tipo è già ristretto
        /** @var int|string|null $key */
        $key = $this->getKey();
        if ($key !== null) {
            // Prevent recursive activitylog crash
            if (! static::$isUpdatingFromAccessor) {
                static::$isUpdatingFromAccessor = true;
                try {
                    static::withoutEvents(function () use ($int_value): void {
                        $this->update(['gg_assenza_dalal' => $int_value]);
                    });
                } finally {
                    static::$isUpdatingFromAccessor = false;
                }
            }
        }

        return $int_value;
    }

    public function getHhAssenzaDalalAttribute(?float $value): ?float
    {
        if ($value !== null) {
            return $value;
        }

        // ✅ Check: record deve esistere prima di save()
        if ($this->getKey() == null) {
            return null;
        }

        $lista_tipo_codice_assenze = $this->listaTipoCodiceAssenze();

        $aszdur = "(hour(replace(aszdur,'.',':')))+((minute(replace(aszdur,'.',':')))/60)";

        $date_min = $this->dal;
        $date_max = $this->al;

        if ($date_min === '') {
            return 0;
        }

        // Guard: empty lista_tipo_codice_assenze prevents invalid SQL: IN ()
        if (empty($lista_tipo_codice_assenze)) {
            $float_value = 0.0;
            $this->hh_assenza_dalal = $float_value;

            // PHPStan: getKey() può restituire null, ma qui il tipo è già ristretto
            /** @var int|string|null $key */
            $key = $this->getKey();
            if ($key !== null) {
                // Prevent recursive activitylog crash
                if (! static::$isUpdatingFromAccessor) {
                    static::$isUpdatingFromAccessor = true;
                    try {
                        static::withoutEvents(function () use ($float_value): void {
                            $this->update([
                                'hh_assenza_dalal' => $float_value,
                            ]);
                        });
                    } finally {
                        static::$isUpdatingFromAccessor = false;
                    }
                }
            }

            return $float_value;
        }

        $arr = Arr::map($lista_tipo_codice_assenze, function ($item): string {
            /** @var string $item */
            return "'{$item}'";
        });
        $list = implode(',', $arr);

        $value = $this->asz00k1()
            // ->whereIn('aszcod', $lista_tipo_codice_assenze)
            ->whereRaw("CONCAT(asztip, '-', aszcod) IN (".$list.')')
            // ->selectRaw('sum('.$aszdur.') as aszdur_sum')
            ->selectRaw('COALESCE(sum(CAST(aszdur AS DECIMAL(10,2))),0) as aszdur_sum')
            ->whereBetween('asz2kd', [$date_min, $date_max])
        // ->withDays($date_min, $date_max)
            ->where('aszumi', 'O')
            ->first();
        // ->sum('aszdur')
        // ✅ isset() invece di property_exists() - funziona per attributi magici Eloquent
        $aszdur_sum = (is_object($value) && isset($value->aszdur_sum)) ? $value->aszdur_sum : 0;
        if (empty($aszdur_sum)) {
            $float_value = 0.0;
        } else {
            $float_value = (float) $aszdur_sum;
        }

        $this->hh_assenza_dalal = $float_value;

        // PHPStan: getKey() può restituire null, ma qui il tipo è già ristretto
        /** @var int|string|null $key */
        $key = $this->getKey();
        if ($key === null) {
            return $float_value;
        }

        // Prevent recursive activitylog crash
        if (! static::$isUpdatingFromAccessor) {
            static::$isUpdatingFromAccessor = true;
            try {
                static::withoutEvents(function () use ($float_value): void {
                    $this->update([
                        'hh_assenza_dalal' => $float_value,
                    ]);
                });
            } finally {
                static::$isUpdatingFromAccessor = false;
            }
        }

        return $float_value;
    }

    public function getTotalePunteggio(): ?float
    {
        if ($this->getKey() == null) {
            return null;
        }

        $value = 0;
        $criteri_valutazione = $this->criteriValutazione->where('post_type', $this->type);
        $tmp = [];
        foreach ($criteri_valutazione as $v) {
            // ✅ isset() invece di property_exists() - funziona per attributi magici Eloquent
            $nomeField = is_object($v) && isset($v->nome) && is_string($v->nome) ? $v->nome : '';
            if ($nomeField === '') {
                continue;
            }
            /** @var float $val */
            $val = (float) ($this->getAttribute($nomeField) ?? 0);
            /** @var float $peso */
            $peso = (float) $this->getPeso($nomeField);

            $value += ((float) $val * (float) $peso) / 4;
            $tmp[] = [
                'nome' => $nomeField,
                'val' => $val,
                'peso' => $peso,
                'value' => $value,
            ];
        }
        dddx($value);

        return $value;
    }

    public function getTotalePunteggioAttribute(?float $value): ?float
    {
        if ($this->getKey() == null) {
            return null;
        }

        if ($value !== null && $value >= 1) {
            return $value;
        }

        $value = 0;
        $criteri_valutazione = $this->criteriValutazione->where('post_type', $this->type);
        $tmp = [];
        foreach ($criteri_valutazione as $v) {
            // ✅ isset() invece di property_exists() - funziona per attributi magici Eloquent
            $nomeField = is_object($v) && isset($v->nome) && is_string($v->nome) ? $v->nome : '';
            if ($nomeField === '') {
                continue;
            }
            /** @var float $val */
            $val = (float) ($this->getAttribute($nomeField) ?? 0);
            /** @var float $peso */
            $peso = (float) $this->getPeso($nomeField);

            $value += ((float) $val * (float) $peso) / 4;
            $tmp[] = [
                'nome' => $nomeField,
                'val' => $val,
                'peso' => $peso,
                'value' => $value,
            ];
        }

        if ($value <= 0.001 && $this->ha_diritto > 0) {
            $where = [
                'ente' => $this->ente,
                'matr' => $this->matr,
                'anno' => $this->anno,
            ];
            $row = Individuale::where($where)->where('ha_diritto', '>', 0)
                ->where('esperienza_acquisita', '>', 0)
                ->first();
            if ($row !== null) {
                $up = [];
                foreach ($criteri_valutazione as $v) {
                    // ✅ isset() invece di property_exists() - funziona per attributi magici Eloquent
                    $nomeField = is_object($v) && isset($v->nome) && is_string($v->nome) ? $v->nome : '';
                    if ($nomeField === '') {
                        continue;
                    }
                    $rowValue = $row->getAttribute($nomeField);
                    if ($rowValue !== null) {
                        $up[$nomeField] = $rowValue;
                    }
                }
                // ⚠️ DO NOT call update() inside accessor - causes infinite loop
                // Just set the attributes directly without triggering events
                foreach ($up as $key => $val) {
                    $this->attributes[$key] = $val;
                }
            }
        }
        /*
        if (0.001 >= $value) {
            $tot = 0;
            $gg = 0;

            $voti = $this->criteriValutazione->pluck('nome')->toArray();
            $voti[] = 'totale_punteggio';

            $tot = [];
            foreach ($this->otherWinnerRows as $otherWinnerRow) {
                foreach ($voti as $voto) {
                    if (! isset($tot[$voto])) {
                        $tot[$voto] = 0;
                    }
                    $tot[$voto] += ($otherWinnerRow->attributes[$voto] * $otherWinnerRow->attributes['gg_presenza_dalal']);
                }

                // $tot += $otherWinnerRow->attributes['totale_punteggio'] * $otherWinnerRow->attributes['gg_presenza_dalal'];
                $gg += $otherWinnerRow->attributes['gg_presenza_dalal'];
            }

            if (0 !== $gg) {
                foreach ($voti as $voto) {
                    $tot[$voto] = $tot[$voto] / $gg;
                }
                // Prevent recursive activitylog crash
                if (! static::$isUpdatingFromAccessor) {
                    static::$isUpdatingFromAccessor = true;
                    try {
                        static::withoutEvents(function () use ($tot): void {
                            $this->update($tot);
                        });
                    } finally {
                        static::$isUpdatingFromAccessor = false;
                    }
                }
                $value = $tot['totale_punteggio'];
            }
        }
        // */

        // ⚠️ DO NOT call update() inside accessor - causes infinite loop
        // Set the raw attribute value without triggering events
        $this->attributes['totale_punteggio'] = $value;

        return $value;
    }

    /*
     public function getGgPresenzaAnnoAttribute(?int $value): ?int
    {
        if ($value !== null && ! request()->input('refresh', false)) {
            return $value;
        }


        $anno = $this->anno;
        $dal = $anno * 10000 + 101;
        $al = $anno * 10000 + 1231;
        $parz = [
            'date_min' => $dal,
            'date_max' => $al,
        ];
        $anag = $this->anag;
        if ($anag === null) {
            return null;
        }
        $data = GgFilterData::from($parz);

        $value = $anag->ggInSedeTot($data);
        $this->gg_presenza_anno = $value;
        $this->save();

        return $value;
    }
    */
    /*
    public function getGgAssenzaAnnoAttribute(?int $value): ?int
    {
        if ($value !== null && ! request()->input('refresh', 0)) {
            return $value;
        }
        if ($this->matr == null) {
            return null;
        }
        if ($this->qua2kd == null) {
            return null;
        }

        // dddx($this->anno);
        // dddx($this->criteriEsclusione->pluck('value', 'name')['data_presenza_al']);
        // $data_presenza_al = ($this->criteriEsclusione->data_presenza_al);
        // $anno = $data_presenza_al->year;
        $anno = $this->anno;
        $dal = $anno * 10000 + 101;
        $al = $anno * 10000 + 1231;
        $value = $this->anag?->ggAssenzaInSedeTot(
            [
                'date_min' => $dal,
                'date_max' => $al,
            ]
        );
        $this->gg_assenza_anno = $value;
        $this->save();

        return $value;
    }
    */
    public function setTypeAttribute(string|\Modules\Ptv\Enums\WorkerType|null $value): void
    {
        // Convert enum to string value
        $stringValue = $value instanceof \Modules\Ptv\Enums\WorkerType ? $value->value : $value;

        // Auto-detect type if not provided or when refreshing
        if ($stringValue === null || (app()->has('request') && request()->exists('refresh'))) {
            if ($this->isRegionale()) {
                $stringValue = 'regionale';
            } elseif ($this->isDirigente()) {
                $stringValue = 'dirigente';
            } elseif ($this->isPo()) {
                $stringValue = 'po';
            } else {
                $stringValue = 'dip';
            }
        }

        $this->attributes['type'] = $stringValue;

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() === null) {
            return;
        }

        // Persist the value - prevent recursive activitylog crash
        if (! static::$isUpdatingFromAccessor) {
            static::$isUpdatingFromAccessor = true;
            try {
                static::withoutEvents(function () use ($stringValue): void {
                    $this->update([
                        'type' => $stringValue,
                    ]);
                });
            } finally {
                static::$isUpdatingFromAccessor = false;
            }
        }
    }
}
