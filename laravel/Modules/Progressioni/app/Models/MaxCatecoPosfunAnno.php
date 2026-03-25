<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Modules\Progressioni\Database\Factories\MaxCatecoPosfunAnnoFactory;
use Illuminate\Support\Str;
use Webmozart\Assert\Assert;

/**
 * Modules\Progressioni\Models\MaxCatecoPosfunAnno.
 *
 * @property int $id
 * @property string|null $cateco
 * @property string|null $posfun
 * @property int $anno
 * @property string $max_gg_tot_pond
 * @property int $aventi_diritto
 * @property int $aventi_diritto_perc
 * @property int $aventi_diritto_eff
 * @property Carbon|null $created_at
 * @property string|null $created_by
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property-read Collection<int, Scheda> $schede
 * @property-read int|null $schede_count
 * @method static MaxCatecoPosfunAnnoFactory factory($count = null, $state = [])
 * @method static Builder|MaxCatecoPosfunAnno newModelQuery()
 * @method static Builder|MaxCatecoPosfunAnno newQuery()
 * @method static Builder|MaxCatecoPosfunAnno query()
 * @method static Builder|MaxCatecoPosfunAnno whereAnno($value)
 * @method static Builder|MaxCatecoPosfunAnno whereAventiDiritto($value)
 * @method static Builder|MaxCatecoPosfunAnno whereAventiDirittoEff($value)
 * @method static Builder|MaxCatecoPosfunAnno whereAventiDirittoPerc($value)
 * @method static Builder|MaxCatecoPosfunAnno whereCateco($value)
 * @method static Builder|MaxCatecoPosfunAnno whereCreatedAt($value)
 * @method static Builder|MaxCatecoPosfunAnno whereCreatedBy($value)
 * @method static Builder|MaxCatecoPosfunAnno whereId($value)
 * @method static Builder|MaxCatecoPosfunAnno whereMaxGgTotPond($value)
 * @method static Builder|MaxCatecoPosfunAnno wherePosfun($value)
 * @method static Builder|MaxCatecoPosfunAnno whereUpdatedAt($value)
 * @method static Builder|MaxCatecoPosfunAnno whereUpdatedBy($value)
 * @property-read \Modules\Ptv\Models\Profile|null $creator
 * @property-read \Modules\Ptv\Models\Profile|null $deleter
 * @property-read \Modules\Ptv\Models\Profile|null $updater
 * @mixin \Eloquent
 */
class MaxCatecoPosfunAnno extends BaseModel
{
    protected $table = 'cateco_posfun_max_tot_pond';

    public array $xls_fields = [
        'id', 'cateco', 'posfun', 'anno', 'max_gg_tot_pond',
    ];

    protected $fillable = ['cateco', 'posfun', 'anno', 'max_gg_tot_pond', 'aventi_diritto', 'aventi_diritto_perc', 'aventi_diritto_eff'];

    // ------- relationship -------
    public function schede(): HasMany
    {
        $schedaClass = Str::of(static::class)
            ->beforeLast('\\')
            ->append('\\Scheda')
            ->toString();

        $modelClass = class_exists($schedaClass) ? $schedaClass : Scheda::class;
        Assert::classExists($modelClass);

        // Scheda::updateVincitori(['anno'=>$this->anno]);
        return $this->hasMany($modelClass, 'categoria_ecoval', 'cateco')
            ->where('posfunval', $this->posfun)
            ->where('anno', $this->anno);
    }

    /* deprecated
    public static function filter(array $params){
        $rows = new self();
        extract($params);
        //echo '<pre>';print_r($params);echo '</pre>';
        if (isset($anno)) {
            $rows = $rows->where('anno', $anno);
        }

        return $rows;
    }
    */

    // end search
    // -------- mututators ----
    public function getAventiDirittoAttribute(?int $value): int
    {
        $rows = $this->schede()->select('matr')->where('ha_diritto', 1)->distinct();
        /*
        if($rows->count()>48){

            echo '<pre>'.$rows->toSql().'</pre>';
            echo '<pre>'.count($rows->get()->toArray()).' '.$rows->count().'</pre>';
            echo '<pre>';print_r($rows->get()->toArray()); echo '</pre>';
        }
        */
        $aventi_diritto = is_countable($rows->get()->toArray()) ? \count($rows->get()->toArray()) : 0;
        $this->aventi_diritto = $aventi_diritto;

        if ($this->getKey() !== null) {
            $this->update([
                'aventi_diritto' => $aventi_diritto,
            ]);
        }

        return $aventi_diritto;
    }

    /*
    public function getAventiDirittoPercAttribute(): void {
        if($value!=0) return $value;
        $aventi_diritto_perc=$value;
        if($this->cateco=='B') $aventi_diritto_perc= 50;
        if($this->cateco=='B3') $aventi_diritto_perc= 50;
        if($this->cateco=='C'){
            if($this->posfun==1){$aventi_diritto_perc= 45;
            }else{$aventi_diritto_perc= 40;}
        };
        if($this->cateco=='D'){
            if($this->posfun==1) {$aventi_diritto_perc=35;
            }else{$aventi_diritto_perc=30;}
        }
        if($this->cateco=='D3'){
            if($this->posfun==3) {$aventi_diritto_perc=35;
            }else{$aventi_diritto_perc= 30;}
        }
        $this->aventi_diritto_perc=$aventi_diritto_perc;
        $this->save();
        return $aventi_diritto_perc;
    }
    */
    public function getAventiDirittoEffAttribute(?int $value): int
    {
        $num = $this->aventi_diritto * $this->aventi_diritto_perc / 100;
        if ($num - floor($num) > 0.5) {
            return (int) round($num, 0);
        }

        $aventi_diritto_eff = (int) floor($num);
        $this->aventi_diritto_eff = $aventi_diritto_eff;

        if ($this->getKey() !== null) {
            $this->update([
                'aventi_diritto_eff' => $aventi_diritto_eff,
            ]);
        }

        return (int) $aventi_diritto_eff;
    }
}
