<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Modules\Ptv\Models\Valutatore as PtvValutatore;
use Modules\Sigma\Models\Repart;
use Override;
use Webmozart\Assert\Assert;

/**
 * Modules\Progressioni\Models\Valutatore.
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
 * @property-read Collection<int, Scheda> $benificiariProgressione
 * @property-read int|null $benificiari_progressione_count
 * @property-read Valutatore|null $boss
 * @property-read Repart|null $repart
 * @property-read Collection<int, Scheda> $schede
 * @property-read int|null $schede_count
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
 * @property-read \Modules\Ptv\Models\Profile|null $creator
 * @property-read \Modules\Ptv\Models\Profile|null $deleter
 * @property-read \Modules\Ptv\Models\Profile|null $updater
 * @method static \Modules\Progressioni\Database\Factories\ValutatoreFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class Valutatore extends PtvValutatore
{
    protected $connection = 'progressione';

    public function benificiariProgressione(): HasMany
    {
        return $this->schede()->where('benificiario_progressione', 1);
    }

    /**
     * getNomeStabiAttribute.
     *
     * @param  string|null  $value
     */
    #[Override]
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

    public function budgetAssegnato(): float
    {
        $beneficiari = $this->benificiariProgressione;

        // $res = $beneficiari->sum('costo_fascia_up');
        Assert::float($res = $beneficiari->sum(fn ($item): int|float => $item->costo_fascia_up * $item->ptime));

        return $res;
    }
}
