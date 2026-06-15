<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Modules\Sigma\Models\Traits\Relationships\EnteMatrRelationship;
use Modules\Sigma\Models\Traits\Relationships\Qua00k1Relationship;

class Sto00f extends BaseDateRangeModel
{
    use EnteMatrRelationship;
    use Qua00k1Relationship;
    use Qua00k1Relationship;

    protected $fillable = [
        'id',
        'ente',
        'matr',
        'stass',
        'stdim',
        'stupd',
        'tipass',
        'tipdim',
        'stann',
        'stotia',
        'stotil',
        'stodaa',
        'stodal',
        'stonua',
        'stonul',
        'st2kas',
        'st2kdi',
        'st2ku',
        'sto2ka',
        'sto2kd',
        'matina',
        'sto001',
        'sto002',
        'sto003',
        'sto004',
        'sto005',
    ];

    protected $table = 'sto00f';

    public const FROM_FIELD = 'st2kas';

    public const TO_FIELD = 'st2kdi';

    public const ANN_FIELD = 'stann';

    public function rangeFromField(): string
    {
        return 'st2kas';
    }

    public function rangeToField(): string
    {
        return 'st2kdi';
    }

    public function annFieldName(): string
    {
        return 'stann';
    }

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'st2kas' => 'integer',
            'st2kdi' => 'integer',
        ]);
    }

    public function giorni(?array $params = null): int
    {
        if ($params === null) {
            $params = getRouteParameters();
        }

        $st2kasValue = $this->attributes['st2kas'] ?? null;
        if ($st2kasValue === null || ! is_numeric($st2kasValue)) {
            return 0;
        }
        $st2kasStr = (string) $st2kasValue;
        $st2kas = new Carbon($st2kasStr);

        $anno = $params['anno'] ?? null;
        if (! is_numeric($anno)) {
            throw new \InvalidArgumentException('anno must be numeric');
        }
        /** @var numeric-string $annoStr */
        $annoStr = (string) $anno;

        $st2kdiValue = $this->attributes['st2kdi'] ?? 0;
        $st2kdiInt = is_numeric($st2kdiValue) ? (int) $st2kdiValue : 0;
        if ($st2kdiInt === 0) {
            $st2kdi = new Carbon($annoStr.'1231');
        } else {
            $st2kdiStr = (string) $st2kdiInt;
            $st2kdi = new Carbon($st2kdiStr);
        }

        return (int) ($st2kdi->diffInDays($st2kas, true) + 1);
    }

    public function gg(?array $params = null): int
    {
        if ($params === null) {
            $params = getRouteParameters();
        }

        $date_min = $params['date_min'] ?? null;
        $date_max = $params['date_max'] ?? null;

        if ($date_min === null) {
            throw new Exception('!isset($date_min)');
        }

        if ($date_max === null) {
            throw new Exception('!isset($date_max)');
        }

        $st2kasValue = $this->attributes['st2kas'] ?? null;
        $st2kasInt = is_numeric($st2kasValue) ? (int) $st2kasValue : 0;
        $dateMinInt = is_numeric($date_min) ? (int) $date_min : 0;
        if ($st2kasInt < $dateMinInt) {
            $dateMinStr = (string) $date_min;
            $st2kas = new Carbon($dateMinStr);
        } else {
            $st2kasStr = (string) $st2kasInt;
            $st2kas = new Carbon($st2kasStr);
        }

        $st2kdiValue = $this->attributes['st2kdi'] ?? 0;
        $st2kdiInt = is_numeric($st2kdiValue) ? (int) $st2kdiValue : 0;
        $dateMaxInt = is_numeric($date_max) ? (int) $date_max : 0;
        if ($st2kdiInt === 0 || $st2kdiInt > $dateMaxInt) {
            $dateMaxStr = (string) $date_max;
            $st2kdi = new Carbon($dateMaxStr);
        } else {
            $st2kdiStr = (string) $st2kdiInt;
            $st2kdi = new Carbon($st2kdiStr);
        }

        if ($st2kas > $st2kdi) {
            return 0;
        }

        return (int) ($st2kdi->diffInDays($st2kas, true) + 1);
    }
}