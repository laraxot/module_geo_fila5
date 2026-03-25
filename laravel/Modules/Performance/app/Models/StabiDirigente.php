<?php

declare(strict_types=1);

namespace Modules\Performance\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Performance\Database\Factories\StabiDirigenteFactory;
use Modules\Ptv\Models\Profile;
use Modules\Ptv\Models\StabiDirigente as PtvStabiDirigente;
use Modules\Sigma\Models\Repart;

// use Modules\Xot\Traits\Updater;
/**
 * Modules\Performance\Models\StabiDirigente.
 *
 * @property int $id
 * @property int|null $stabi
 * @property int|null $repar
 * @property string|null $nome_stabi
 * @property int|null $ente
 * @property int|null $matr
 * @property string|null $nome_diri
 * @property string|null $anno
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property int|null $n_diritto_excellence
 * @method static Builder|StabiDirigente newModelQuery()
 * @method static Builder|StabiDirigente newQuery()
 * @method static Builder|StabiDirigente query()
 * @method static Builder|StabiDirigente whereAnno($value)
 * @method static Builder|StabiDirigente whereCreatedAt($value)
 * @method static Builder|StabiDirigente whereCreatedBy($value)
 * @method static Builder|StabiDirigente whereEnte($value)
 * @method static Builder|StabiDirigente whereId($value)
 * @method static Builder|StabiDirigente whereMatr($value)
 * @method static Builder|StabiDirigente whereNDirittoExcellence($value)
 * @method static Builder|StabiDirigente whereNomeDiri($value)
 * @method static Builder|StabiDirigente whereNomeStabi($value)
 * @method static Builder|StabiDirigente whereRepar($value)
 * @method static Builder|StabiDirigente whereStabi($value)
 * @method static Builder|StabiDirigente whereUpdatedAt($value)
 * @method static Builder|StabiDirigente whereUpdatedBy($value)
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @method static StabiDirigenteFactory factory($count = null, $state = [])
 * @property int $valutatore_id
 * @property string|null $email
 * @property-read Profile|null $deleter
 * @property-read Repart|null $repart
 * @method static Builder<static>|StabiDirigente whereEmail($value)
 * @method static Builder<static>|StabiDirigente whereValutatoreId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Progressioni\Models\Scheda> $benificiariProgressione
 * @property-read int|null $benificiari_progressione_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Progressioni\Models\Scheda> $scheda
 * @property-read int|null $scheda_count
 * @mixin \Eloquent
 */
class StabiDirigente extends PtvStabiDirigente
{
    protected $connection = 'performance';

    /*
    use Updater;
    protected $connection = 'performance'; // this will use the specified database connection
    protected $dates = [
        'created_at',
        'updated_at',
        //'deleted_at',
    ];

    */
    /*
    protected $table = 'stabi_dirigente';

    protected $fillable = [
        'id', 'stabi', 'repar', 'nome_stabi',
        'ente', 'matr', 'nome_diri', 'anno',
        'n_diritto_excellence',
    ];
    */

    // public $timestamps= false;
    /*
    public static function filter($params)
    {
        $rows = new self();
        extract($params);
        //echo '<pre>';print_r($params);echo '</pre>';
        return $rows;
    }
    */
    // end search
    // -------------------------
    //
    // ---- mutators ----
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
            $this->save();
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
            $this->save();
        }

        return $value;
    }
        */
}
