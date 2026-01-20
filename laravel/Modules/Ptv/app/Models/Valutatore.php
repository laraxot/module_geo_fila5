<?php

declare(strict_types=1);

namespace Modules\Ptv\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Modules\Progressioni\Models\Schede;
use Modules\Sigma\Models\Repart;
use Webmozart\Assert\Assert;

/**
 * Modules\Ptv\Models\Valutatore.
 *
 * @property int $id
 * @property int|null $stabi
 * @property int|null $repar
 * @property string|null $nome_stabi
 * @property string|null $stabi_txt
 * @property string|null $repar_txt
 * @property int|null $ente
 * @property int|null $matr
 * @property int|null $anno
 * @property string|null $nome_diri
 * @property string|null $nome_diri_plus
 * @property string|null $budget
 * @property int|null $valutatore_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property string|null $deleted_ip
 * @property string|null $created_ip
 * @property string|null $updated_ip
 * @property-read Collection<int, Schede> $benificiariProgressione
 * @property-read int|null $benificiari_progressione_count
 * @property-read Valutatore|null $boss
 * @property-read Repart|null $repart
 * @property-read Collection<int, Schede> $schede
 * @property-read int|null $schede_count
 *
 * @method static mixed factory($count = null, $state = [])
 * @method static Builder|Valutatore newModelQuery()
 * @method static Builder|Valutatore newQuery()
 * @method static Builder|Valutatore query()
 * @method static Builder|Valutatore whereAnno($value)
 * @method static Builder|Valutatore whereBudget($value)
 * @method static Builder|Valutatore whereCreatedAt($value)
 * @method static Builder|Valutatore whereCreatedBy($value)
 * @method static Builder|Valutatore whereCreatedIp($value)
 * @method static Builder|Valutatore whereDeletedAt($value)
 * @method static Builder|Valutatore whereDeletedBy($value)
 * @method static Builder|Valutatore whereDeletedIp($value)
 * @method static Builder|Valutatore whereEnte($value)
 * @method static Builder|Valutatore whereId($value)
 * @method static Builder|Valutatore whereMatr($value)
 * @method static Builder|Valutatore whereNomeDiri($value)
 * @method static Builder|Valutatore whereNomeDiriPlus($value)
 * @method static Builder|Valutatore whereNomeStabi($value)
 * @method static Builder|Valutatore whereRepar($value)
 * @method static Builder|Valutatore whereReparTxt($value)
 * @method static Builder|Valutatore whereStabi($value)
 * @method static Builder|Valutatore whereStabiTxt($value)
 * @method static Builder|Valutatore whereUpdatedAt($value)
 * @method static Builder|Valutatore whereUpdatedBy($value)
 * @method static Builder|Valutatore whereUpdatedIp($value)
 * @method static Builder|Valutatore whereValutatoreId($value)
 *
 * @property int $n_diritto_excellence
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 *
 * @method static Builder<static>|Valutatore whereNDirittoExcellence($value)
 */
class Valutatore extends BaseModel
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'stabi',
        'repar',
        'nome_stabi',
        'stabi_txt',
        'repar_txt',
        'ente',
        'matr',
        'anno',
        'nome_diri',
        'nome_diri_plus',
        'budget',
        'valutatore_id',
    ];

    // this will use the specified database connection
    protected $table = 'stabi_dirigente';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // ----- relationship ---
    public function repart(): HasOne
    {
        return $this->hasOne(Repart::class, 'stabi', 'stabi')->where('repar', $this->repar)->where('ente', 90);
    }

    public function schede(): HasMany
    {
        $schedeClass = Str::of(self::class)->append('\Models\Schede')->toString();

        /** @phpstan-ignore-next-line */
        return $this->hasMany($schedeClass, 'valutatore_id', 'id');
    }

    public function boss(): hasOne
    {
        return $this->hasOne(self::class, 'valutatore_id', 'id');
    }
    /*
    public function benificiariProgressione(): HasMany
    {
        return $this->schede()->where('benificiario_progressione', 1);
    }
    */
    // --- mutators --

    /**
     * getNomeStabiAttribute.
     *
     * @param  string|null  $value
     */
    public function getNomeStabiAttribute($value): ?string
    {
        if ($value !== null) {
            return $value;
        }
        if (! $this->repart instanceof Repart) {
            return $value;
        }

        return $this->repart->dest1;
    }

    /**
     * getNomeDiriAttribute.
     *
     * @param  string|null  $value
     */
    public function getNomeDiriAttribute($value): ?string
    {
        /*
        if($value==null){
            $conn=$this->getConnection();
            $sql='select concat(conome," ",nome) as nome_diri from generale.ana10f where matr=(
                select matr from generale.qua00f where (
                    ('.$this->anno.' between year(qua2kd) and year(qua2ka) ) or
                    ('.$this->anno.' >= year(qua2kd) and qua2ka=0 )
                ) and quaann=""
                and matr in
                (select matr from generale.rep00f where repst1='.$this->stabi.'
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
                    ('.($this->anno+1).' between year(st2kas) and year(st2kdi) ) or
                    ('.($this->anno+1).' >= year(st2kas) and st2kdi=0 )
                )
                )
                order by propro desc,posfun desc
                limit 1)';
            $res= \DB::select($sql);
            $value=ucwords(strtolower($res[0]->nome_diri)).'';
        }
        */
        return $value;
    }
    /*
    public function budgetAssegnato(): float
    {
        $beneficiari = $this->benificiariProgressione;

        // $res = $beneficiari->sum('costo_fascia_up');
        Assert::float($res = $beneficiari->sum(fn ($item): int|float => $item->costo_fascia_up * $item->ptime));

        return $res;
    }
    */
}
