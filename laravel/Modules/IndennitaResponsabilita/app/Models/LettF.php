<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Models;

use Validator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\IndennitaResponsabilita\Models\Traits\FunctionTrait;
use Modules\IndennitaResponsabilita\Models\Traits\RelationshipTrait;
use Modules\Ptv\Models\BaseScheda;
use Modules\Rating\Models\Traits\HasRatingsTrait;
use Modules\Sigma\Models\Anag;
use Modules\Sigma\Models\Codici;
use Modules\Sigma\Models\Qua00f;
use Modules\Sigma\Models\Rep00f;

/**
 * @property Carbon|null           $dalf
 * @property Carbon|null           $alf
 * @property ImportiCategoria|null $importi
 */
class LettF extends BaseScheda
{
    use FunctionTrait;
    use RelationshipTrait;
    use HasRatingsTrait;

    /** @var class-string */
    public static $logModel = MyLog::class;

    public string $from_field = 'dal';

    public string $to_field = 'al';

    protected $table = 'indennita_responsabilita';

    /** @var list<string> */
    protected $fillable = [
        'id', 'ente', 'matr', 'stabi', 'repar', 'rep2kd', 'rep2ka', 'anno',
        'email', 'posizione_lavoro',
        'complessita', 'coordinamento', 'responsabilita',
        'tot', 'valore_economico_calcolato', 'valore_economico_attribuito',
        'propro', 'posfun', 'categoria_eco', 'posiz', 'posiz_txt',
        'cognome', 'nome',
        'dal', 'al', 'dalf', 'alf', 'dali', 'ali',
    ];

    public array $rules = [
        'posizione_lavoro' => 'required',
        'email' => 'required',
        'complessita' => 'required|numeric|min:0|max:40',
        'coordinamento' => 'required|numeric|min:0|max:30',
        'responsabilita' => 'required|numeric|min:0|max:30',
    ];

    public array $xls_fields = [
        'ente', 'matr',
        'cognome', 'nome',
        'email',
        'stabi', 'stabi_txt',
        'repar', 'repar_txt',
        'propro',
        'posfun', 'categoria_eco',
        'dalf', 'alf',
        'posizione_lavoro',
        'complessita',
        'coordinamento',
        'responsabilita',
        'tot',
        'valore_economico_calcolato',
        'valore_economico_attribuito',
    ];

    public array $messages = [
        'posizione_lavoro.required' => 'campo obbligatorio, non lasciare vuoto',
        'complessita.numeric.max' => 'deve essere compreso fra 0 e 40',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'dalf' => 'date:Y-m-d',
            'alf' => 'date:Y-m-d',
            'dal' => 'datetime',
            'al' => 'datetime',
            'dali' => 'datetime',
            'ali' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * @param array<string, mixed> $data
     */
    public function validate(array $data): void
    {
        $validator = Validator::make($data, $this->rules, $this->messages);
        $validator->validate();
    }

    public function importi(): ?HasOne
    {
        $query = $this->hasOne(ImportiCategoria::class, 'ente', 'ente')
            ->where('anno', $this->anno)
            ->whereRaw('find_in_set("'.$this->propro.'",lista_propro)');

        if (0 === $query->count()) {
            $rowOld = ImportiCategoria::where('ente', $this->ente)
                ->where('anno', $this->anno - 1)
                ->whereRaw('find_in_set("'.$this->propro.'",lista_propro)');

            if (1 !== $rowOld->count()) {
                return null;
            }

            /** @var ImportiCategoria|null $firstRow */
            $firstRow = $rowOld->first();
            if (null === $firstRow) {
                return null;
            }
            $row = $firstRow->replicate();
            /** @var int|null $anno */
            $anno = $this->anno;
            if (null !== $anno) {
                $row->anno = $anno;
            }
            $row->save();
        }

        return $query;
    }

    public function stabiDirigente(): HasOne
    {
        /** @var int|string|null $repar */
        $repar = $this->repar ?? null;
        /** @var int|null $anno */
        $anno = $this->anno ?? null;
        $query = $this->hasOne(StabiDirigente::class, 'stabi', 'stabi');
        if (null !== $repar) {
            $query = $query->where('repar', $repar);
        }
        if (null !== $anno) {
            $query = $query->where('anno', $anno);
        }

        return $query;
    }

    public function mailInviate(): HasMany
    {
        return $this->hasMany(MyLog::class, 'id_tbl', 'id')
            ->where('tbl', $this->getTable())
            ->where('note', 'sendMailLettF');
    }

    public function Rep00f(): HasMany
    {
        /** @var int|null $anno */
        $anno = $this->anno ?? null;
        if (null === $anno) {
            return $this->hasMany(Rep00f::class, 'matr', 'matr')
                ->where('ente', $this->ente)
                ->whereRaw('repann=""')
                ->whereRaw('1=0'); // Return empty result if anno is null
        }

        return $this->hasMany(Rep00f::class, 'matr', 'matr')
            ->where('ente', $this->ente)
            ->whereRaw('repann=""')
            ->ofYear($anno);
    }

    public function Qua00f(): HasMany
    {
        if (null === $this->dalf) {
            $this->dalf = Carbon::createFromDate($this->anno, 1, 1);
        }

        if (null === $this->alf) {
            $this->alf = Carbon::createFromDate($this->anno, 12, 31);
        }

        $dal = $this->dalf->format('Ymd');
        $al = $this->alf->format('Ymd');

        $sql = '(
            ('.$dal.' between qua2kd and qua2ka) OR
            ('.$dal.' >= qua2kd AND qua2ka=0) OR
            ('.$al.' between qua2kd and qua2ka) OR
            ('.$al.' >= qua2kd AND qua2ka=0) OR
            (qua2kd between '.$dal.' and '.$al.') OR
            (qua2ka between '.$dal.' and '.$al.')
        )';

        return $this->hasMany(Qua00f::class, 'matr', 'matr')
            ->where('ente', $this->ente)
            ->whereRaw('quaann=""')
            ->whereRaw($sql);
    }

    /**
     * @param Carbon|string|null $value
     */
    public function setDalfAttribute($value): void
    {
        if (\is_string($value)) {
            // @phpstan-ignore-next-line
            $value = Carbon::createFromFormat('d/m/Y', $value);
            if (! ($value instanceof Carbon)) {
                return;
            }
        }
        $this->attributes['dalf'] = $value;
    }

    /**
     * @param Carbon|string|null $value
     */
    public function setAlfAttribute($value): void
    {
        if (\is_string($value)) {
            // @phpstan-ignore-next-line
            $value = Carbon::createFromFormat('d/m/Y', $value);
            if (! ($value instanceof Carbon)) {
                return;
            }
        }
        $this->attributes['alf'] = $value;
    }

    /**
     * @param float|int|string|null $value
     */
    public function getTotAttribute(mixed $value): float
    {
        /** @var float|int|string|null $complessita */
        $complessita = $this->complessita ?? 0;
        /** @var float|int|string|null $coordinamento */
        $coordinamento = $this->coordinamento ?? 0;
        /** @var float|int|string|null $responsabilita */
        $responsabilita = $this->responsabilita ?? 0;

        $complessitaNum = is_numeric($complessita) ? (float) $complessita : 0.0;
        $coordinamentoNum = is_numeric($coordinamento) ? (float) $coordinamento : 0.0;
        $responsabilitaNum = is_numeric($responsabilita) ? (float) $responsabilita : 0.0;

        $newValue = $complessitaNum + $coordinamentoNum + $responsabilitaNum;
        /** @var float|int|string|null $valueNum */
        $valueNum = $value;
        $valueFloat = is_numeric($valueNum) ? (float) $valueNum : 0.0;
        if ($newValue != $valueFloat) {
            // ✅ Persist con update chirurgico (salva SOLO questo campo, previene loop)
            if (null !== $this->getKey()) {
                $this->update(['tot' => $newValue]);
            }
        }

        return $newValue;
    }

    /**
     * @param float|int|string|null $value
     */
    public function getValoreEconomicoCalcolatoAttribute(mixed $value): float
    {
        /** @var ImportiCategoria|null $importi */
        $importi = $this->importi;
        if (null === $importi) {
            return 0.0;
        }

        /** @var float|int|string|null $importoMax */
        $importoMax = $importi->max ?? 0;
        $importoMaxNum = is_numeric($importoMax) ? (float) $importoMax : 0.0;
        /** @var float|int $tot */
        $tot = $this->tot ?? 0.0;
        $totNum = is_numeric($tot) ? (float) $tot : 0.0;
        $newValue = $totNum * $importoMaxNum / 100;
        /** @var float|int|string|null $valueNum */
        $valueNum = $value;
        $valueFloat = is_numeric($valueNum) ? (float) $valueNum : 0.0;
        if ($newValue != $valueFloat) {
            // ✅ Persist con update chirurgico (salva SOLO questo campo, previene loop)
            if (null !== $this->getKey()) {
                $this->update(['valore_economico_calcolato' => $newValue]);
            }
        }

        return $newValue;
    }

    public function getValoreEconomicoEffettivoAttribute(): float
    {
        /** @var Carbon|null $alf */
        $alf = $this->alf;
        /** @var Carbon|null $dalf */
        $dalf = $this->dalf;
        if (null === $alf || null === $dalf) {
            return 0.0;
        }
        $gg = $alf->diffInDays($dalf, true) + 1;
        /** @var float|int $valoreEconomicoAttribuito */
        $valoreEconomicoAttribuito = $this->valore_economico_attribuito ?? 0.0;

        return round($valoreEconomicoAttribuito * $gg / 365, 2);
    }

    /**
     * @param float|int|string|null $value
     */
    public function getValoreEconomicoAttribuitoAttribute(mixed $value): float
    {
        /** @var ImportiCategoria|null $importi */
        $importi = $this->importi;
        if (null === $importi) {
            return 0.0;
        }

        /** @var float|int|string|null $importoMin */
        $importoMin = $importi->min ?? 0;
        $importoMinNum = is_numeric($importoMin) ? (float) $importoMin : 0.0;
        /** @var float|int|string|null $valueNum */
        $valueNum = $value;
        $valueFloat = is_numeric($valueNum) ? (float) $valueNum : 0.0;
        $newValue = max($valueFloat, $importoMinNum);
        if ($newValue != $valueFloat) {
            // ✅ Persist con update chirurgico (salva SOLO questo campo, previene loop)
            if (null !== $this->getKey()) {
                $this->update(['valore_economico_attribuito' => $newValue]);
            }
        }

        return $newValue;
    }

    public function getPosizTxtAttribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }

        // ✅ Check: record deve esistere prima di save()
        if ($this->getKey() === null) {
            return null;
        }

        /** @var int|string|null $posiz */
        $posiz = $this->posiz ?? null;
        if ($posiz === null) {
            return null;
        }

        /** @var Codici|null $row */
        $row = Codici::where('tipo', 19)->where('codice', $posiz)->first();
        if ($row === null) {
            return null;
        }

        /** @var string|null $desc1 */
        $desc1 = $row->desc1 ?? null;
        if ($desc1 === null) {
            return null;
        }

        /** @var int|string|null $primaryKey */
        $primaryKey = $this->getKey();
        if (null === $primaryKey) {
            /** @var string|null $result */
            $result = $this->attributes['posiz_txt'] ?? $desc1;
            return is_string($result) ? $result : null;
        }

        $this->update(['posiz_txt' => $desc1]);

        /** @var string|null $result */
        $result = $this->attributes['posiz_txt'] ?? $desc1;
        return is_string($result) ? $result : null;
    }

    public function getEmailAttribute(?string $value): ?string
    {
        if (null !== $value && '' !== $value) {
            return $value;
        }

        /** @var Anag|null $anag */
        $anag = $this->anag;
        if ($anag instanceof Anag) {
            /** @var string|null $emailFromAnag */
            $emailFromAnag = $anag->email ?? null;
            if (null !== $emailFromAnag && '' !== $emailFromAnag) {
                $this->attributes['email'] = $emailFromAnag;

                return $emailFromAnag;
            }
        }

        return '';
    }

    // ... [resto del codice] ...
}
