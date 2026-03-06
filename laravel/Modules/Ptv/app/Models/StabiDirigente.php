<?php

declare(strict_types=1);

namespace Modules\Ptv\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Modules\Ptv\Database\Factories\StabiDirigenteFactory;
use Modules\Sigma\Models\Rep00f;
use Modules\Sigma\Models\Repart;

/**
 * Modules\Ptv\Models\StabiDirigente.
 *
 * @property string|null $nome_diri
 * @property string|null $nome_stabi
 * @property Repart|null $repart
 * @method static StabiDirigenteFactory factory($count = null, $state = [])
 * @method static Builder|StabiDirigente newModelQuery()
 * @method static Builder|StabiDirigente newQuery()
 * @method static Builder|StabiDirigente query()
 * @property int $id
 * @property int|null $stabi
 * @property int|null $repar
 * @property int|null $ente
 * @property int|null $matr
 * @property string|null $nome_diri_plus
 * @property string|null $budget
 * @property int|null $valutatore_id
 * @property int|null $anno
 * @property string|null $post_type
 * @property int|null $post_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @method static Builder|StabiDirigente whereAnno($value)
 * @method static Builder|StabiDirigente whereBudget($value)
 * @method static Builder|StabiDirigente whereCreatedAt($value)
 * @method static Builder|StabiDirigente whereCreatedBy($value)
 * @method static Builder|StabiDirigente whereEnte($value)
 * @method static Builder|StabiDirigente whereId($value)
 * @method static Builder|StabiDirigente whereMatr($value)
 * @method static Builder|StabiDirigente whereNomeDiri($value)
 * @method static Builder|StabiDirigente whereNomeDiriPlus($value)
 * @method static Builder|StabiDirigente whereNomeStabi($value)
 * @method static Builder|StabiDirigente wherePostId($value)
 * @method static Builder|StabiDirigente wherePostType($value)
 * @method static Builder|StabiDirigente whereRepar($value)
 * @method static Builder|StabiDirigente whereStabi($value)
 * @method static Builder|StabiDirigente whereUpdatedAt($value)
 * @method static Builder|StabiDirigente whereUpdatedBy($value)
 * @method static Builder|StabiDirigente whereValutatoreId($value)
 * @property Profile|null $creator
 * @property Profile|null $updater
 * @property int $n_diritto_excellence
 * @method static Builder<static>|StabiDirigente whereNDirittoExcellence($value)
 * @property-read \Modules\Ptv\Models\Profile|null $deleter
 * @mixin \Eloquent
 */
class StabiDirigente extends BaseModel
{
    protected $table = 'stabi_dirigente';

    protected $fillable = [
        'stabi', 'repar', 'nome_stabi',
        'ente', 'matr', 'nome_diri', 'nome_diri_plus',
        'budget',
        'valutatore_id',
        'anno',
        // 'quadrimestre',
        'email',
    ];

    #[\Override]
    public function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'email' => 'string',
        ];
    }

    // ----- relationship ---
    public function repart(): HasOne
    {
        return $this->hasOne(Repart::class, 'stabi', 'stabi')
            ->where('repar', $this->repar)
            ->where('ente', 90);
    }

    /*
    public function schede():\Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Schede::class, 'valutatore_id', 'id');
    }

    public function benificiariProgressione(): void {
        return $this->schede()->where('benificiario_progressione', 1);
    }
    */

    // --- mutators --
    public function getNomeStabiAttribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }
        if (! $this->repart instanceof Repart) {
            return $value;
        }

        return $this->repart->dest1;
    }

    public function getStabiAttribute(?int $value): ?int
    {
        if (($value !== null && $value != 0) || $this->getKey() === null) {
            return $value;
        }
        $rep00f = Rep00f::where('ente', $this->ente)
            ->where('matr', $this->matr)
            ->whereRaw('repann=""')
            ->ofYear($this->anno ?? 0)
            ->latest('rep2kd')
            ->first();

        $value = $rep00f?->repst1;
        if ($value == 0 && $rep00f?->repst2 != 0) {
            $value = $rep00f->repst2;
        }
        $this->update(['stabi' => $value]);

        return $value;
    }

    public function getReparAttribute(?int $value): ?int
    {
        if (($value !== null) || $this->getKey() === null) {
            return $value;
        }
        $value = 0;
        $this->update(['repar' => $value]);

        return $value;
    }

    public function getEnteAttribute(?int $value): ?int
    {
        if (($value !== null) || $this->getKey() === null) {
            return $value;
        }
        $value = 90;
        $this->update(['ente' => $value]);

        return $value;
    }

    public function getNomeDiriAttribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }

        /*
         * Se non c'e' il nome prendo quello dell'anno prima.
         */
        if (random_int(1, 10) > 7) {
            $prev = self::where('stabi', $this->stabi)
                ->where('repar', $this->repar)
                ->where('anno', $this->anno - 1)
                ->first();
            if (\is_object($prev)) {
                $value = $prev->nome_diri;
                $this->nome_diri = $value;

                if ($this->getKey() !== null) {
                    $this->update([
                        'nome_diri' => $value,
                    ]);
                }

                return $value;
            }
        }

        // *
        /* @phpstan-ignore-next-line */
        if (empty($value) && $this->stabi !== '' && random_int(1, 10) > 8) {
            // Avoid malformed SQL when model is partially hydrated (e.g. ide-helper reflection).
            if (! is_int($this->anno) || $this->anno <= 0) {
                return $value;
            }

            $conn = $this->getConnection();
            $sql = 'select concat(conome," ",nome) as nome_diri from generale.ana10f where matr=(
                select matr from generale.qua00f where (
                    ('.$this->anno.' between year(qua2kd) and year(qua2ka) ) or
                    ('.$this->anno.' >= year(qua2kd) and qua2ka=0 )
                ) and quaann=""
                and matr in
                (select matr from generale.rep00f where repst1="'.$this->stabi.'"
                 and repann=""
                and (
                    ('.$this->anno.' between year(rep2kd) and year(rep2ka) ) or
                    ('.$this->anno.' >= year(rep2kd) and rep2ka=0 )
                )
                order by rep2kd desc
                )
                and matr in
                (select matr from generale.sto00f where stann=""
                and (
                    ('.($this->anno + 1).' between year(st2kas) and year(st2kdi) ) or
                    ('.($this->anno + 1).' >= year(st2kas) and st2kdi=0 )
                )
                )
                order by propro desc,posfun desc
                limit 1)';

            $res = \DB::select($sql);
            // Type narrowing: ensure result is array and has first element
            if (is_array($res) && isset($res[0]) && is_object($res[0])) {
                $firstResult = $res[0];
                $nomeDiri = isset($firstResult->nome_diri) ? (string) $firstResult->nome_diri : '';
                $value = ucwords(strtolower($nomeDiri)).'';

                $this->nome_diri = $value;

                if ($this->getKey() !== null) {
                    $this->update([
                        'nome_diri' => $value,
                    ]);
                }
            }

            return $value;
        }

        // */
        return $value;
    }

    /*
    public function budgetAssegnato(): void {
        $beneficiari = $this->benificiariProgressione;
        $res = $beneficiari->sum('costo_fascia_up');

        return $res;
    }
    */
    // end budgetAssegnato

    /*
    public function getNomeDiriAttribute(): void {
       if (null !== $value) {
           return $value;
       }
       $row = StabiDirigente::where('stabi', $this->stabi)
           ->where('repar', $this->repar)
           ->first();

       if (is_object($row)) {
           $value = $row->nome_diri;
           $this->nome_diri = $value;

           // Guard: modello deve avere PK per salvare
           if (null != $this->getKey()) {
               $this->save();
           }
       }

       return $value;
    }
    */
    /*
    public function getNomeStabiAttribute(): void {
        if ($value !== null) {
            return $value;
        }

        $stabi = Repart::where('stabi', $this->stabi)
            ->where('repar', 0)
            ->where('ente', 90)
            ->first();

        $repart = Repart::where('stabi', $this->stabi)
            ->where('repar', $this->repar)
            ->where('ente', 90)
            ->first();
        if (\is_object($stabi) && \is_object($repart)) {
            $value = $stabi->dest1.' '.$stabi->dest2.' - '.$repart->dest1.' '.$repart->dest2;
            $this->nome_stabi = $value;

            // Guard: modello deve avere PK per salvare
            if (null != $this->getKey()) {
                $this->save();
            }
        }

        return $value;
    }
        */
}
