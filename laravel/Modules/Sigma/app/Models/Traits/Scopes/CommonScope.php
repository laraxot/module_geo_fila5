<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Scopes;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Date;

trait CommonScope
{
    // ------ SCOPES --------

    /**
     * Get from field name.
     */
    protected function getFromFieldAttribute(): string
    {
        return $this->from_field ?? 'dal';
    }

    /**
     * Get to field name.
     */
    protected function getToFieldAttribute(): string
    {
        return $this->to_field ?? 'al';
    }

    protected function scopeOfQuarter(Builder $query, int $quarter, int $year): Builder
    {
        $m_from = (($quarter - 1) * 3) + 1;
        $from = Date::create($year, $m_from, 1, 0, 0, 0);
        $to = Date::create($year, $m_from, 1, 0, 0, 0);
        if (! $from instanceof Carbon) {
            throw new Exception('$from==null');
        }

        if (! $to instanceof Carbon) {
            throw new Exception('$to==null');
        }

        $to = $to->addMonths(3)->subDay();
        $sql =
            ''
            .$this->from_field
            .' >= '
            .$from->format('Ymd')
            .' and
            '
            .$this->to_field
            .' <= '
            .$to->format('Ymd')
            .'';

        return $query->whereRaw($sql);
    }

    protected function scopeOfFourMonthPeriod(Builder $query, int $fourMonthPeriod, int $year): Builder
    {
        $m_from = (($fourMonthPeriod - 1) * 4) + 1;
        $from = Date::create($year, $m_from, 1, 0, 0, 0);
        $to = Date::create($year, $m_from, 1, 0, 0, 0);
        if (! $from instanceof Carbon) {
            throw new Exception('$from==null');
        }

        if (! $to instanceof Carbon) {
            throw new Exception('$to==null');
        }

        $to = $to->addMonths(3)->subDay();
        $sql =
            ''
            .$this->from_field
            .' >= '
            .$from->format('Ymd')
            .' and
            '
            .$this->to_field
            .' <= '
            .$to->format('Ymd')
            .'';

        return $query->whereRaw($sql);
    }

    /**
     * Scope per filtrare per anno.
     */
    protected function scopeOfYear(Builder $query, int $year): Builder
    {
        // If the model has an 'anno' column, use that for filtering
        if (isset($this->getAttributes()['anno'])) {
            return $query->where('anno', $year);
        }

        // Otherwise, use the date range fields
        $from_field = $this->from_field ?? 'dal';
        $to_field = $this->to_field ?? 'al';

        return $query->where(static function ($q) use ($year, $from_field, $to_field) {
            $q->where($from_field, '<=', ($year * 10000) + 1231)->where(static function ($q2) use ($year, $to_field) {
                $q2->where($to_field, '>=', ($year * 10000) + 101)->orWhere($to_field, '=', 0);
            });
        });
    }

    protected function scopeOfEnteYear(Builder $query, int $ente, int $year): Builder
    {
        $query = $query->where('ente', $ente)->whereRaw('quaann=""');

        // Delegate to scopeOfYear without chaining on Builder
        return $this->scopeOfYear($query, $year);
    }

    protected function scopeOfEnte(Builder $query, int $ente): Builder
    {
        return $query->where('ente', $ente);

        // ->whereRaw('quaann=""');
    }

    protected function scopeOfDate(Builder $query, int $date): Builder
    {
        $sql =
            '(
            ('
            .$date
            .' between '
            .$this->from_field
            .' and '
            .$this->to_field
            .' ) or
            ('
            .$date
            .' >= '
            .$this->from_field
            .' and '
            .$this->to_field
            .'=0 )
        )';

        return $query->whereRaw($sql);
    }

    /**
     * Scope a query to only include records within a date range.
     *
     * @param  int  $date_start  Start date in Ymd format
     * @param  int  $date_end  End date in Ymd format (0 means no end date)
     */
    protected function scopeOfRangeDate(Builder $query, int $date_start, int $date_end): Builder
    {
        /*
         * if (is_object($date_start)) {
         * $date_start = $date_start->format('Ymd');
         * }
         */

        if ($date_end === 0) {
            $sql = '(('.$this->to_field.' >= '.$date_start.') or ('.$this->to_field.' =0))';

            return $query->whereRaw($sql);
        }

        $sql =
            '
        (
            (
                ('
            .$date_start
            .' between '
            .$this->from_field
            .' and '
            .$this->to_field
            .' ) or
                ('
            .$date_start
            .' >= '
            .$this->from_field
            .' and '
            .$this->to_field
            .'=0 )
            ) or
            (
                ('
            .$date_end
            .' between '
            .$this->from_field
            .' and '
            .$this->to_field
            .' ) or
                ('
            .$date_end
            .' >= '
            .$this->from_field
            .' and '
            .$this->to_field
            .'=0 )
            ) or

                ('
            .$this->from_field
            .' between '
            .$date_start
            .' and '
            .$date_end
            .' )


        )';

        return $query->whereRaw($sql);
    }

    protected function scopeWithDays(Builder $query, int $date_min, int $date_max): Builder
    {
        $days =
            'greatest(datediff(if('
            .$this->to_field
            .'=0 or '
            .$this->to_field
            .'>'
            .$date_max
            .','
            .$date_max
            .','
            .$this->to_field
            .'),
            if('
            .$this->from_field
            .'<'
            .$date_min
            .','
            .$date_min
            .','
            .$this->from_field
            .'))+1,0) ';

        return $query->selectRaw(sprintf('*,%s AS days', $days));
    }
}
