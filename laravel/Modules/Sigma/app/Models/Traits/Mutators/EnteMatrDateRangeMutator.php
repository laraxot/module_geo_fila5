<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Mutators;

use Carbon\Carbon;

trait EnteMatrDateRangeMutator
{
    /**
     * Convert date value to integer Ymd format.
     */
    private function dateToYmdInt(Carbon|int|string|null $date): int
    {
        if ($date === null) {
            return 0;
        }

        if ($date instanceof Carbon) {
            return (int) $date->format('Ymd');
        }

        if (is_numeric($date)) {
            return (int) $date;
        }

        try {
            $carbon = Carbon::parse((string) $date);

            return (int) $carbon->format('Ymd');
        } catch (\Throwable) {
            return 0;
        }
    }

    /**
     * Get percentage part-time for date range.
     *
     * @param  mixed  $_value  Unused parameter (required by Laravel accessor pattern)
     */
    protected function getPercPTimeDaterangeAttribute(mixed $_value): int|float
    {
        $rows = $this->qua00fDaterange();
        if ($rows === null) {
            return 0;
        }
        /** @var array<int, array<string, mixed>> $array */
        $array = $rows->get()->toArray();

        // echo '<pre>';print_r($array);echo '</pre>';

        $ore = 0.0;
        $giorni = 0;
        foreach ($array as $v) {
            if (! is_array($v)) {
                continue;
            }
            $oreeRaw = $v['oree'] ?? null;
            $oretRaw = $v['oret'] ?? null;
            $giorniRaw = $v['giorni'] ?? null;

            $oree = is_numeric($oreeRaw) ? (float) $oreeRaw : 0.0;
            $oret = is_numeric($oretRaw) ? (float) $oretRaw : 1.0;
            $giorniVal = is_numeric($giorniRaw) ? (int) $giorniRaw : 0;
            if ($oret !== 0.0) {
                $ore += ($oree / $oret) * (float) $giorniVal;
            }
            $giorni += $giorniVal;
        }

        if ($giorni === 0) {
            return 0;
        }

        // echo '<h3>'.$ris.'</h3>';
        return $ore / $giorni;
    }

    protected function getPercParttimeDalalAttribute(): ?float
    {
        $date_min = $this->dal;
        $date_max = $this->al;
        if ($date_min === null || $date_min === 0 || $date_min === '') {
            return null;
        }
        if ($date_max === null) {
            return null;
        }

        $date_min_int = $this->dateToYmdInt($date_min);
        $date_max_int = $this->dateToYmdInt($date_max);
        if ($date_min_int === 0 || $date_max_int === 0) {
            return null;
        }

        $date_min_int_typed = $date_min_int;
        $date_max_int_typed = $date_max_int;

        $rows = $this->qua00f()
            ->withDays($date_min_int_typed, $date_max_int_typed)
            ->withPercPtime()
            ->having('days', '>', 0)
            // ->sum(\DB::raw('order_product.price * order_product.quantity'));
            ->get();
        $perc = 0.0;
        $peso = 0.0;
        foreach ($rows as $row) {
            // Proprietà dinamiche aggiunte da withDays() e withPercPtime()
            $percPtimeRaw = $row->getAttribute('perc_ptime');
            $daysRaw = $row->getAttribute('days');

            $percPtime = is_numeric($percPtimeRaw) ? (float) $percPtimeRaw : 0.0;
            $days = is_numeric($daysRaw) ? (float) $daysRaw : 0.0;

            $perc += $percPtime * $days;
            $peso += $days;
        }

        if ($peso === 0.0) {
            return null;
        }

        $value = $perc / $peso;
        // $value = number_format($value, 3);
        $this->perc_parttime_dalal = $value;

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() !== null) {
            $this->update(['perc_parttime_dalal' => $value]);
        }

        return $value;
    }

    protected function getGgParttimevertDalalAttribute(): ?float
    {
        $date_min = $this->dal;
        $date_max = $this->al;
        if ($date_min === null || $date_min === 0 || $date_min === '') {
            return null;
        }
        if ($date_max === null) {
            return null;
        }

        $date_min_int = $this->dateToYmdInt($date_min);
        $date_max_int = $this->dateToYmdInt($date_max);
        if ($date_min_int === 0 || $date_max_int === 0) {
            return null;
        }

        $date_min_int_typed = $date_min_int;
        $date_max_int_typed = $date_max_int;

        $value = $this->asz00k1()
            ->where('asztip', 505)
            ->where('aszcod', 97)
            ->withDays($date_min_int_typed, $date_max_int_typed)
            ->get()
            ->sum('days');
        // $value = number_format($value, 3);

        $this->gg_parttimevert_dalal = is_numeric($value) ? (float) $value : null;

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() !== null) {
            $this->update(['gg_parttimevert_dalal' => $value]);
        }

        return is_numeric($value) ? (float) $value : null;
    }

    protected function getGgPresenzaDalalAttribute(): int
    {
        $date_min = $this->dal;
        $date_max = $this->al;
        if ($date_min === null || $date_min === 0 || $date_min === '') {
            return 0;
        }
        if ($date_max === null) {
            return 0;
        }

        $date_min_int = $this->dateToYmdInt($date_min);
        $date_max_int = $this->dateToYmdInt($date_max);
        if ($date_min_int === 0 || $date_max_int === 0) {
            return 0;
        }

        $date_min_int_typed = $date_min_int;
        $date_max_int_typed = $date_max_int;

        $value = $this->qua00f()
            ->withDays($date_min_int_typed, $date_max_int_typed)
            ->get()
            ->sum('days');
        $this->gg_presenza_dalal = is_numeric($value) ? (int) $value : 0;

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() !== null) {
            $this->update(['gg_presenza_dalal' => $value]);
        }

        return is_numeric($value) ? (int) $value : 0;
    }

    protected function getCategoriaEcoAttribute(?string $value): ?string
    {
        if ($value != null) {
            return $value;
        }
        if ($this->matr == null) {
            return null;
        }
        if ($this->qua2kd == null) {
            return null;
        }

        $qua00fRelation = $this->qua00fDaterange();
        if ($qua00fRelation === null) {
            return null;
        }
        $qua00f = $qua00fRelation->first();

        if (! ($qua00f instanceof \Modules\Sigma\Models\Qua00f)) {
            // dddx($this);

            return null;
        }

        $tqu00f = $qua00f->tqu00f;
        if ($tqu00f === null) {
            $rows = $qua00f->tqu00f();
            if (function_exists('rowsToSql')) {
                dddx(['rows' => $rows, 'sql' => rowsToSql($rows), 'qua00f' => $qua00f]);
            }

            return '---';
        }

        $categoria_eco = $tqu00f->desc1;
        $categoria_eco = str_replace('Posizione economica ', '', (string) $categoria_eco);
        $this->categoria_eco = $categoria_eco;

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() == null) {
            return isset($this->attributes['categoria_eco']) && is_string($this->attributes['categoria_eco']) ? $this->attributes['categoria_eco'] : null;
        }

        $this->update(['categoria_eco' => $categoria_eco]);

        return isset($this->attributes['categoria_eco']) && is_string($this->attributes['categoria_eco']) ? $this->attributes['categoria_eco'] : null;
    }
}
