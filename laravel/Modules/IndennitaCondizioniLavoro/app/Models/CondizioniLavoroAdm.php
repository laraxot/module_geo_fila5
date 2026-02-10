<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Ptv\Models\Profile;
use Modules\Sigma\Models\Traits\SigmaModelTrait;

/**
 * Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoroAdm.
 *
 * @property int                                     $id
 * @property int|null                                $ente
 * @property int|null                                $matr
 * @property string|null                             $email
 * @property string|null                             $cognome
 * @property string|null                             $nome
 * @property int|null                                $trimestre
 * @property int|null                                $stabi
 * @property string|null                             $stabi_txt
 * @property int|null                                $repar
 * @property string|null                             $repar_txt
 * @property int|null                                $propro
 * @property int|null                                $posfun
 * @property string|null                             $categoria_eco
 * @property int|null                                $posiz
 * @property string|null                             $posiz_txt
 * @property int|null                                $gg_presenza_anno
 * @property int|null                                $gg_presenza_periodo
 * @property int|null                                $gg_assenza_anno
 * @property string|null                             $hh_assenza_anno
 * @property int|null                                $gg_trasferte_anno
 * @property int|null                                $anno
 * @property int|null                                $rep2kd
 * @property int|null                                $rep2ka
 * @property int|null                                $qua2kd
 * @property int|null                                $qua2ka
 * @property \Illuminate\Support\Carbon|null         $dal
 * @property \Illuminate\Support\Carbon|null         $al
 * @property \Illuminate\Support\Carbon|null         $created_at
 * @property \Illuminate\Support\Carbon|null         $updated_at
 * @property string|null                             $created_by
 * @property string|null                             $updated_by
 * @property int                                     $disci1
 * @property string                                  $disci1_txt
 * @property int                                     $codqua
 * @property string                                  $codqua_txt
 * @property int                                     $tot_presenza_periodo_plus_no_timbr
 * @property string                                  $tot
 * @property int|null                                $valutatore_id
 * @property int|null                                $quadrimestre
 * @property Collection<int, IndennitaTipoDettaglio> $indennitaTipoDettaglio
 * @property int|null                                $indennita_tipo_dettaglio_count
 *
 * @method static Builder|CondizioniLavoroAdm newModelQuery()
 * @method static Builder|CondizioniLavoroAdm newQuery()
 * @method static Builder|CondizioniLavoroAdm ofDate(int $date)
 * @method static Builder|CondizioniLavoroAdm ofEnteYear(int $ente, int $year)
 * @method static Builder|CondizioniLavoroAdm ofQuarter(int $quarter, int $year)
 * @method static Builder|CondizioniLavoroAdm ofRangeDate(int $date_start, int $date_end)
 * @method static Builder|CondizioniLavoroAdm ofYear(int $year)
 * @method static Builder|CondizioniLavoroAdm query()
 * @method static Builder|CondizioniLavoroAdm whereAl($value)
 * @method static Builder|CondizioniLavoroAdm whereAnno($value)
 * @method static Builder|CondizioniLavoroAdm whereCategoriaEco($value)
 * @method static Builder|CondizioniLavoroAdm whereCodqua($value)
 * @method static Builder|CondizioniLavoroAdm whereCodquaTxt($value)
 * @method static Builder|CondizioniLavoroAdm whereCognome($value)
 * @method static Builder|CondizioniLavoroAdm whereCreatedAt($value)
 * @method static Builder|CondizioniLavoroAdm whereCreatedBy($value)
 * @method static Builder|CondizioniLavoroAdm whereDal($value)
 * @method static Builder|CondizioniLavoroAdm whereDisci1($value)
 * @method static Builder|CondizioniLavoroAdm whereDisci1Txt($value)
 * @method static Builder|CondizioniLavoroAdm whereEmail($value)
 * @method static Builder|CondizioniLavoroAdm whereEnte($value)
 * @method static Builder|CondizioniLavoroAdm whereGgAssenzaAnno($value)
 * @method static Builder|CondizioniLavoroAdm whereGgPresenzaAnno($value)
 * @method static Builder|CondizioniLavoroAdm whereGgPresenzaPeriodo($value)
 * @method static Builder|CondizioniLavoroAdm whereGgTrasferteAnno($value)
 * @method static Builder|CondizioniLavoroAdm whereHhAssenzaAnno($value)
 * @method static Builder|CondizioniLavoroAdm whereId($value)
 * @method static Builder|CondizioniLavoroAdm whereMatr($value)
 * @method static Builder|CondizioniLavoroAdm whereNome($value)
 * @method static Builder|CondizioniLavoroAdm wherePosfun($value)
 * @method static Builder|CondizioniLavoroAdm wherePosiz($value)
 * @method static Builder|CondizioniLavoroAdm wherePosizTxt($value)
 * @method static Builder|CondizioniLavoroAdm wherePropro($value)
 * @method static Builder|CondizioniLavoroAdm whereQua2ka($value)
 * @method static Builder|CondizioniLavoroAdm whereQua2kd($value)
 * @method static Builder|CondizioniLavoroAdm whereQuadrimestre($value)
 * @method static Builder|CondizioniLavoroAdm whereRep2ka($value)
 * @method static Builder|CondizioniLavoroAdm whereRep2kd($value)
 * @method static Builder|CondizioniLavoroAdm whereRepar($value)
 * @method static Builder|CondizioniLavoroAdm whereReparTxt($value)
 * @method static Builder|CondizioniLavoroAdm whereStabi($value)
 * @method static Builder|CondizioniLavoroAdm whereStabiTxt($value)
 * @method static Builder|CondizioniLavoroAdm whereTot($value)
 * @method static Builder|CondizioniLavoroAdm whereTotPresenzaPeriodoPlusNoTimbr($value)
 * @method static Builder|CondizioniLavoroAdm whereTrimestre($value)
 * @method static Builder|CondizioniLavoroAdm whereUpdatedAt($value)
 * @method static Builder|CondizioniLavoroAdm whereUpdatedBy($value)
 * @method static Builder|CondizioniLavoroAdm whereValutatoreId($value)
 * @method static Builder|CondizioniLavoroAdm withDays(int $date_min, int $date_max)
 *
 * @property Profile|null                                     $creator
 * @property mixed                                            $all_indennita_tipo
 * @property string|null                                      $codice_fiscale
 * @property string                                           $from_field
 * @property int|float                                        $gg_p_time_vert_year
 * @property mixed                                            $gg_parttimevert_anno
 * @property int|null                                         $gg_parttimevert
 * @property mixed                                            $gg_parttimevert_dalal
 * @property mixed                                            $gg_presenza_dalal
 * @property string|null                                      $inail
 * @property \Illuminate\Support\Collection                   $indennita_tipo_dettaglio_all
 * @property mixed                                            $last_data_assunz
 * @property int|float                                        $perc_p_time_daterange
 * @property int|float                                        $perc_p_time_year
 * @property mixed                                            $perc_parttime_anno
 * @property float|null                                       $perc_parttime
 * @property mixed                                            $perc_parttime_dalal
 * @property string|null                                      $sesso
 * @property string|null                                      $titolo_di_studio
 * @property string                                           $to_field
 * @property float|null                                       $tot_x_ptime
 * @property CondizioniLavoroIndennitaTipoDettaglioPivot|null $pivot
 * @property StabiDirigente|null                              $stabiDirigente
 * @property Collection<int, IndennitaTipoDettaglio>          $tipoDettaglio
 * @property int|null                                         $tipo_dettaglio_count
 * @property Profile|null                                     $updater
 *
 * @method static Builder<static>|CondizioniLavoroAdm ofEnte(int $ente)
 * @method static Builder<static>|CondizioniLavoroAdm ofFourMonthPeriod(int $fourMonthPeriod, int $year)
 *
 * @mixin \Eloquent
 */
class CondizioniLavoroAdm extends CondizioniLavoro
{
    // use SigmaModelTrait;

    protected $table = 'condizioni_lavoro';

    public string $from_field = 'dal';

    public string $to_field = 'al';

    /*
    protected $fillable =
        [
            'id',
            'ente', 'matr', 'cognome', 'nome', 'email',
            'stabi', 'stabi_txt', 'repar', 'repar_txt',
            'propro', 'posfun', 'categoria_eco',
            'gg_presenza_anno', 'gg_assenza_anno', 'gg_trasferte_anno',
            'anno', 'trimestre', 'dal', 'al',
            'rep2kd', 'rep2ka', 'qua2kd', 'qua2ka',
            'gg_presenza_periodo',
            'tot_presenza_periodo_plus_no_timbr',
        ];

    protected function casts(): array
    {
        return [
            'dal' => 'datetime',
            'al' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
    */
    // --- relationships ---
    #[\Override]
    public function indennitaTipoDettaglio(): BelongsToMany
    {
        $cross = 'condizioni_lavoro_x_indennita_tipo_dettaglio';
        $pivot_fields = ['gg'];

        $foreignPivotKey = 'condizioni_lavoro_id';
        $relatedPivotKey = null;
        $parentKey = null;
        $relatedKey = null;
        $relation = null;

        return $this->belongsToManyX(IndennitaTipoDettaglio::class, $cross, $foreignPivotKey, $relatedPivotKey, $parentKey, $relatedKey, $relation)
            ->using(CondizioniLavoroIndennitaTipoDettaglioPivot::class)
            ->withPivot($pivot_fields);
    }

    public function days(): int
    {
        /*
        $days = $this
            ->wstr01lx()
            ->ofQuarter($this->trimestre, $this->anno)
            ->get();
        */
        $dal = $this->dal->format('Ymd');
        $al = $this->al->format('Ymd');

        return $this->wstr01lx()
            ->select('wtdata')
            ->distinct('wtdata')
            ->where('wtdata', '>=', $dal)
            ->where('wtdata', '<=', $al)
            ->count();
    }

    /*
    public function scopeOfQuarter(): void {
        $year = $year;
        $m_from = (($quarter - 1) * 3) + 1;
        $from = Carbon::create($year, $m_from, 1, 0, 0, 0);
        $to = Carbon::create($year, $m_from, 1, 0, 0, 0)->addMonths(3)->subDay();
        $sql = ''.$this->from_field.' >= '.$from->format('Ymd').' and
            '.$this->to_field.' <= '.$to->format('Ymd').'';

        return $query->whereRaw($sql);
    }
    */

    // --- mutators ---
    public function getTrimestreAttribute(?int $value): ?int
    {
        if (null !== $value) {
            return $value;
        }

        try {
            $dal_month = $this->dal->month;
        } catch (\ErrorException $e) {
            dddx($this->getAttribute('dal'));
        }
        switch ($dal_month) {
            case 1:
                $value = 1;
                break;
            case 4:
                $value = 2;
                break;
            case 7:
                $value = 3;
                break;
            case 10:
                $value = 4;
                break;
                // default:$value = ''; break;
        }

        $this->trimestre = $value;

        if (null === $this->getKey()) {
            return $value;
        }

        $this->update([
            'trimestre' => $value,
        ]);

        return $value;
    }
}
