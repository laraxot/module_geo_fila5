<?php

declare(strict_types=1);

namespace Modules\Performance\Models;

// ---------- models -------
// ----------traits ---
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Modules\Ptv\Models\BaseScheda;
use Modules\Ptv\Models\Profile;
use Modules\Sigma\Models\Ana02f;
use Modules\Sigma\Models\Ana10f;
use Modules\Sigma\Models\Anag;
use Modules\Sigma\Models\Asz00f;
use Modules\Sigma\Models\Asz00k1;
use Modules\Sigma\Models\Qua00f;
use Modules\Sigma\Models\Qua03f;
use Modules\Sigma\Models\Rep00f;
use Modules\Sigma\Models\Repart;
use Modules\Sigma\Models\Sto00f;
use Modules\Sigma\Models\Tqu00f;
use Modules\Sigma\Models\Wstr01lx;

// ---- services ---
// passare ad arrayservice

// ------ ext models---
/**
 * Modules\Performance\Models\Performance.
 *
 * @property int $id
 * @property string|null $type
 * @property string|null $post_type
 * @property int $ente
 * @property int|null $matr
 * @property string|null $cognome
 * @property string|null $nome
 * @property string|null $email
 * @property int|null $stabi
 * @property int|null $repar
 * @property int|null $stabival
 * @property int|null $reparval
 * @property string|null $stabi_txt
 * @property string|null $repar_txt
 * @property int|null $disci
 * @property string|null $disci_txt
 * @property int|null $rep2kd
 * @property int|null $rep2ka
 * @property int|null $posiz
 * @property int|null $propro
 * @property int|null $posfun
 * @property string|null $categoria_eco
 * @property int|null $qua2kd
 * @property int|null $qua2ka
 * @property int|null $dal
 * @property int|null $al
 * @property int|null $anno
 * @property int|null $giornitempodet
 * @property int $ha_diritto
 * @property string|null $motivo
 * @property string|null $esperienza_acquisita
 * @property string|null $risultati_ottenuti
 * @property string|null $arricchimento_professionale
 * @property string|null $impegno
 * @property string|null $qualita_prestazione
 * @property float|null $totale_punteggio
 * @property string|null $lista_auth
 * @property float|null $peso_esperienza_acquisita
 * @property float|null $peso_risultati_ottenuti
 * @property float|null $peso_arricchimento_professionale
 * @property float|null $peso_impegno
 * @property float|null $peso_qualita_prestazione
 * @property string|null $datemod
 * @property string|null $note
 * @property string|null $oree
 * @property string|null $oret
 * @property float|null $perc_parttime
 * @property string|null $perc_parttimepond
 * @property int|null $gg_parttimevert
 * @property string|null $ore_assenza
 * @property string|null $giorni_assenza
 * @property string|null $giorni_presenza
 * @property string|null $categ_coeff
 * @property string|null $quota_teorica
 * @property string|null $budget_assegnato
 * @property string|null $quota_effettiva
 * @property string|null $resti
 * @property string|null $resti_pond
 * @property string|null $importo_totale
 * @property string|null $gg_totale_sigma
 * @property string|null $gg_validi_sigma
 * @property string|null $gg_assenz_sigma
 * @property string|null $decurtazione_perc
 * @property int $gg_tempo_determinato
 * @property int|null $gg_posiz_1_in_sede
 * @property int $gg_assenza_anno
 * @property int $gg_presenza_anno
 * @property string|null $ore_assenza_anno
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $posiz_txt
 * @property int|null $clafun
 * @property int|null $disci1
 * @property string|null $disci1_txt
 * @property int $gg_ruolo
 * @property int|null $last_data_assunz
 * @property string|null $perc_parttime_anno
 * @property string|null $perc_parttime_dalal
 * @property int|null $gg_parttimevert_anno
 * @property int|null $gg_parttimevert_dalal
 * @property float|null $perc_parttimepond_anno
 * @property string|null $perc_parttimepond_dalal
 * @property int|null $gg_presenza_dalal
 * @property int|null $gg_assenza_dalal
 * @property float|null $hh_assenza_anno
 * @property float|null $hh_assenza_dalal
 * @property string|null $lang
 * @property int|null $excellence
 * @property string|null $codqua
 * @property mixed $cont
 * @property mixed $tipco
 * @property string|null $posizione_eco
 * @property float $gg_anno
 * @property-read Collection<int, Sto00f> $Sto00fYear
 * @property-read int|null $sto00f_year_count
 * @property-read Collection<int, Ana02f> $ana02f
 * @property-read int|null $ana02f_count
 * @property-read Ana10f|null $ana10f
 * @property-read Anag|null $anag
 * @property-read Collection<int, Asz00f> $asz00f
 * @property-read int|null $asz00f_count
 * @property-read Collection<int, Asz00k1> $asz00k1
 * @property-read int|null $asz00k1_count
 * @property-read Collection<int, Asz00k1> $asz00k1Year
 * @property-read int|null $asz00k1_year_count
 * @property-read Collection<int, Individuale> $cards
 * @property-read int|null $cards_count
 * @property-read Collection<int, IndividualeAssenze> $codiciAssenze
 * @property-read int|null $codici_assenze_count
 * @property-read Collection<int, CriteriEsclusione> $criteriEsclusione
 * @property-read int|null $criteri_esclusione_count
 * @property-read CriteriMaggiorazione|null $criteriMaggiorazione
 * @property-read Collection<int, CriteriOption> $criteriOptions
 * @property-read int|null $criteri_options_count
 * @property-read Collection<int, CriteriValutazione> $criteriValutazione
 * @property-read int|null $criteri_valutazione_count
 * @property-read int|float $gg_p_time_vert_year
 * @property-read int|float $perc_p_time_daterange
 * @property-read int|float $perc_p_time_year
 * @property-read mixed $titolo_di_studio
 * @property-read Collection<int, MyLog> $mailInviate
 * @property-read int|null $mail_inviate_count
 * @property-read Collection<int, MyLog> $myLogs
 * @property-read int|null $my_logs_count
 * @property-read Collection<int, Option> $options
 * @property-read int|null $options_count
 * @property-read Collection<int, Performance> $otherWinnerRows
 * @property-read int|null $other_winner_rows_count
 * @property-read IndividualePesi|null $peso
 * @property-read IndividualePoPesi|null $pesoPo
 * @property-read Collection<int, Qua00f> $qua00f
 * @property-read int|null $qua00f_count
 * @property-read Collection<int, Qua00f> $qua00fDaterange
 * @property-read int|null $qua00f_daterange_count
 * @property-read Collection<int, Qua00f> $qua00fYear
 * @property-read int|null $qua00f_year_count
 * @property-read Collection<int, Qua03f> $qua03f
 * @property-read int|null $qua03f_count
 * @property-read Collection<int, Rep00f> $rep00f
 * @property-read int|null $rep00f_count
 * @property-read Collection<int, Repart> $reparts
 * @property-read int|null $reparts_count
 * @property-read StabiDirigente|null $stabiDirigente
 * @property-read Collection<int, Sto00f> $sto00f
 * @property-read int|null $sto00f_count
 * @property-read IndividualeTotStabi|null $totStabi
 * @property-read Tqu00f|null $tqu00f
 * @property-read Collection<int, Wstr01lx> $wstr01lx
 * @property-read int|null $wstr01lx_count
 * @property-read Collection<int, Wstr01lx> $wstr01lxYear
 * @property-read int|null $wstr01lx_year_count
 * @method static Builder|Performance newModelQuery()
 * @method static Builder|Performance newQuery()
 * @method static Builder|Performance ofDate(int $date)
 * @method static Builder|Performance ofEnteYear(int $ente, int $year)
 * @method static Builder|Performance ofQuarter(int $quarter, int $year)
 * @method static Builder|Performance ofRangeDate(int $date_start, int $date_end)
 * @method static Builder|Performance ofYear(int $year)
 * @method static Builder|Performance query()
 * @method static Builder|Performance whereAl($value)
 * @method static Builder|Performance whereAnno($value)
 * @method static Builder|Performance whereArricchimentoProfessionale($value)
 * @method static Builder|Performance whereBudgetAssegnato($value)
 * @method static Builder|Performance whereCategCoeff($value)
 * @method static Builder|Performance whereCategoriaEco($value)
 * @method static Builder|Performance whereClafun($value)
 * @method static Builder|Performance whereCodqua($value)
 * @method static Builder|Performance whereCognome($value)
 * @method static Builder|Performance whereCont($value)
 * @method static Builder|Performance whereCreatedAt($value)
 * @method static Builder|Performance whereCreatedBy($value)
 * @method static Builder|Performance whereDal($value)
 * @method static Builder|Performance whereDatemod($value)
 * @method static Builder|Performance whereDecurtazionePerc($value)
 * @method static Builder|Performance whereDisci($value)
 * @method static Builder|Performance whereDisci1($value)
 * @method static Builder|Performance whereDisci1Txt($value)
 * @method static Builder|Performance whereDisciTxt($value)
 * @method static Builder|Performance whereEmail($value)
 * @method static Builder|Performance whereEnte($value)
 * @method static Builder|Performance whereEsperienzaAcquisita($value)
 * @method static Builder|Performance whereExcellence($value)
 * @method static Builder|Performance whereGgAnno($value)
 * @method static Builder|Performance whereGgAssenzSigma($value)
 * @method static Builder|Performance whereGgAssenzaAnno($value)
 * @method static Builder|Performance whereGgAssenzaDalal($value)
 * @method static Builder|Performance whereGgParttimevert($value)
 * @method static Builder|Performance whereGgParttimevertAnno($value)
 * @method static Builder|Performance whereGgParttimevertDalal($value)
 * @method static Builder|Performance whereGgPosiz1InSede($value)
 * @method static Builder|Performance whereGgPresenzaAnno($value)
 * @method static Builder|Performance whereGgPresenzaDalal($value)
 * @method static Builder|Performance whereGgRuolo($value)
 * @method static Builder|Performance whereGgTempoDeterminato($value)
 * @method static Builder|Performance whereGgTotaleSigma($value)
 * @method static Builder|Performance whereGgValidiSigma($value)
 * @method static Builder|Performance whereGiorniAssenza($value)
 * @method static Builder|Performance whereGiorniPresenza($value)
 * @method static Builder|Performance whereGiornitempodet($value)
 * @method static Builder|Performance whereHaDiritto($value)
 * @method static Builder|Performance whereHhAssenzaAnno($value)
 * @method static Builder|Performance whereHhAssenzaDalal($value)
 * @method static Builder|Performance whereId($value)
 * @method static Builder|Performance whereImpegno($value)
 * @method static Builder|Performance whereImportoTotale($value)
 * @method static Builder|Performance whereLang($value)
 * @method static Builder|Performance whereLastDataAssunz($value)
 * @method static Builder|Performance whereListaAuth($value)
 * @mixin Model
 * @property-read Profile|null $creator
 * @property-read mixed $aventi_diritto
 * @property-read mixed $aventi_diritto_eff
 * @property-read string|null $categoria_ecoval
 * @property-read string|null $codice_fiscale
 * @property-read float|null $eta
 * @property-read int|null $excellences_count_last3years
 * @property-read int|null $gg_asz
 * @property-read int|null $gg_asz_cateco
 * @property-read int|null $gg_asz_cateco_fuori_sede
 * @property-read int|null $gg_asz_cateco_in_sede
 * @property-read int|null $gg_asz_cateco_posfun
 * @property-read int|null $gg_asz_cateco_posfun_fuori_sede
 * @property-read int|null $gg_asz_cateco_posfun_in_sede
 * @property-read int|null $gg_asz_fuori_sede
 * @property-read int|null $gg_asz_in_sede
 * @property-read int|null $gg_asz_tip_cod_escluso_subito
 * @property-read int|null $gg
 * @property-read int|null $gg_cateco
 * @property-read int|null $gg_cateco_fuori_sede
 * @property-read int|null $gg_cateco_in_sede
 * @property-read int|null $gg_cateco_no_asz
 * @property-read int|null $gg_cateco_no_posfun_no_asz
 * @property-read int|null $gg_cateco_posfun
 * @property-read int|null $gg_cateco_posfun_fuori_sede
 * @property-read int|null $gg_cateco_posfun_in_sede
 * @property-read int|null $gg_cateco_posfun_in_sede_no_asz
 * @property-read int|null $gg_cateco_posfun_no_asz
 * @property-read int|null $gg_cateco_sup
 * @property-read int|null $gg_cateco_sup_fuori_sede
 * @property-read int|null $gg_cateco_sup_in_sede
 * @property-read int|null $gg_fuori_sede
 * @property-read float|null $gg_fuori_sede_no_asz
 * @property-read int|null $gg_in_sede
 * @property-read float|null $gg_in_sede_no_asz
 * @property-read float|null $gg_no_asz
 * @property-read int|null $gg_posiz1_in_sede
 * @property-read int|null $hh_asz
 * @property-read int|null $hh_asz_fuori_sede
 * @property-read int|null $hh_asz_in_sede
 * @property-read float|null $importo_stipendio_annuo
 * @property-read string|null $inail
 * @property-read string|null $lista_propro
 * @property-read string|null $lista_propro_sup
 * @property-read float|null $perf_ind2014
 * @property-read float|null $perf_ind2015
 * @property-read float|null $perf_ind2016
 * @property-read float|null $perf_ind2017
 * @property-read float|null $perf_ind2018
 * @property-read float|null $perf_ind2019
 * @property-read float|null $perf_ind2020
 * @property-read float|null $perf_ind2021
 * @property-read float|null $perf_ind2022
 * @property-read float|null $perf_ind2023
 * @property-read float|null $perf_ind2024
 * @property-read float|null $perf_ind2025
 * @property-read float|null $perf_ind2026
 * @property-read float|null $perf_ind2027
 * @property-read float|null $perf_ind2028
 * @property-read float|null $perf_ind2029
 * @property-read float|null $perf_ind2030
 * @property-read int|null $perf_ind_count_last3_years
 * @property-read float|null $perf_ind_media
 * @property-read int $posfunval
 * @property-read int $posizione
 * @property-read float|null $ptime
 * @property float|null $punt_progressione_finale
 * @property-read string|null $sesso
 * @property-read float|null $totale_pond
 * @property-read float|null $valore_differenziale_rapportato_pt
 * @property-read int|null $valutatore_id
 * @property-read string|null $valutatore_txt
 * @property-read Profile|null $updater
 * @property-read mixed $valutatore
 * @property-read mixed $avversariCategoriaEco
 * @property-read mixed $categoriaPropro
 * @property-read mixed $maxCatecoPosfun
 * @property-read mixed $costo_fascia_up
 * @property-read mixed $pesi
 * @property-read mixed $totale
 * @property-read mixed $schedaCriteri
 * @property-read mixed $stipendioTabellare
 * @property-read mixed $to_field
 * @property-read mixed $from_field
 * @method static Builder<static>|Performance ofEnte(int $ente)
 * @method static Builder<static>|Performance ofFourMonthPeriod(int $fourMonthPeriod, int $year)
 * @method static Builder<static>|Performance withDays(int $date_min, int $date_max)
 * @method static Builder<static>|Performance withTotPunt()
 * @method array getListaTipoCodiceAspettative()
 * @method array criteriOptionsArr()
 * @method mixed maxCatecoPosfun()
 * @method mixed convertedIn()
 * @method mixed hhAssenzaFuoriSedeTot()
 * @method mixed ggAssenzaInSedeTot()
 * @method mixed ggAssenzaFuoriSedeTot()
 * @method mixed ggInSedeTot()
 * @method mixed ggFuoriSedeTot()
 * @method mixed ggAssenzaInSedeTot()
 * @method static Builder ofYear(int $year)
 * @method static Builder ofRangeDate(int $date_start, int $date_end)
 * @property-read Collection<int, \Modules\Activity\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Collection<int, \Modules\Progressioni\Models\Scheda> $avversari
 * @property-read int|null $avversari_count
 * @property-read int|null $avversari_categoria_eco_count
 * @property-read Profile|null $deleter
 * @property-read float $gg_cateco_posfun_rapportato_max10_valutatore
 * @property-read int|null $gg_esperienza_no_asz
 * @property-read float|null $gg_integ_params_asz
 * @property-read Collection<int, \Modules\Sigma\Models\Integparam> $integParams
 * @property-read int|null $integ_params_count
 * @property-read Collection<int, Performance> $performanceIndividuale
 * @property-read int|null $performance_individuale_count
 * @method static \Modules\Performance\Database\Factories\PerformanceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Performance withCalculatedData()
 * @mixin \Eloquent
 */
class Performance extends BaseScheda
{
    /** @var string */
    protected $table = 'performance';

    /** @var list<string> */
    protected $fillable = [
        'type',
        'post_type',
        'ente',
        'matr',
        'cognome',
        'nome',
        'email',
        'stabi',
        'repar',
        'stabival',
        'reparval',
        'stabi_txt',
        'repar_txt',
        'disci',
        'disci_txt',
        'rep2kd',
        'rep2ka',
        'posiz',
        'propro',
        'posfun',
        'categoria_eco',
        'qua2kd',
        'qua2ka',
        'dal',
        'al',
        'anno',
        'giornitempodet',
        'ha_diritto',
        'motivo',
        'esperienza_acquisita',
        'risultati_ottenuti',
        'arricchimento_professionale',
        'impegno',
        'qualita_prestazione',
        'totale_punteggio',
        'lista_auth',
        'peso_esperienza_acquisita',
        'peso_risultati_ottenuti',
        'peso_arricchimento_professionale',
        'peso_impegno',
        'peso_qualita_prestazione',
        'datemod',
        'note',
        'oree',
        'oret',
        'perc_parttime',
        'perc_parttimepond',
        'gg_parttimevert',
        'ore_assenza',
        'giorni_assenza',
        'giorni_presenza',
        'categ_coeff',
        'quota_teorica',
        'budget_assegnato',
        'quota_effettiva',
        'resti',
        'resti_pond',
        'importo_totale',
        'gg_totale_sigma',
        'gg_validi_sigma',
        'gg_assenz_sigma',
        'decurtazione_perc',
        'gg_tempo_determinato',
        'gg_posiz_1_in_sede',
        'gg_assenza_anno',
        'gg_presenza_anno',
        'ore_assenza_anno',
        'posiz_txt',
        'clafun',
        'disci1',
        'disci1_txt',
        'gg_ruolo',
        'last_data_assunz',
        'perc_parttime_anno',
        'perc_parttime_dalal',
        'gg_parttimevert_anno',
        'gg_parttimevert_dalal',
        'perc_parttimepond_anno',
        'perc_parttimepond_dalal',
        'gg_presenza_dalal',
        'gg_assenza_dalal',
        'hh_assenza_anno',
        'hh_assenza_dalal',
        'lang',
        'excellence',
        'codqua',
        'cont',
        'tipco',
        'posizione_eco',
        'gg_anno',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'ente' => 'integer',
            'matr' => 'integer',
            'stabi' => 'integer',
            'repar' => 'integer',
            'stabival' => 'integer',
            'reparval' => 'integer',
            'disci' => 'integer',
            'rep2kd' => 'integer',
            'rep2ka' => 'integer',
            'posiz' => 'integer',
            'propro' => 'integer',
            'posfun' => 'integer',
            'qua2kd' => 'integer',
            'qua2ka' => 'integer',
            'dal' => 'integer',
            'al' => 'integer',
            'anno' => 'integer',
            'giornitempodet' => 'integer',
            'ha_diritto' => 'integer',
            'totale_punteggio' => 'float',
            'peso_esperienza_acquisita' => 'float',
            'peso_risultati_ottenuti' => 'float',
            'peso_arricchimento_professionale' => 'float',
            'peso_impegno' => 'float',
            'peso_qualita_prestazione' => 'float',
            'perc_parttime' => 'float',
            'gg_parttimevert' => 'integer',
            'gg_tempo_determinato' => 'integer',
            'gg_posiz_1_in_sede' => 'integer',
            'gg_assenza_anno' => 'integer',
            'gg_presenza_anno' => 'integer',
            'clafun' => 'integer',
            'disci1' => 'integer',
            'gg_ruolo' => 'integer',
            'last_data_assunz' => 'integer',
            'gg_parttimevert_anno' => 'integer',
            'gg_parttimevert_dalal' => 'integer',
            'perc_parttimepond_anno' => 'float',
            'gg_presenza_dalal' => 'integer',
            'gg_assenza_dalal' => 'integer',
            'hh_assenza_anno' => 'float',
            'hh_assenza_dalal' => 'float',
            'excellence' => 'integer',
            'codqua' => 'integer',
            'cont' => 'integer',
            'tipco' => 'integer',
            'gg_anno' => 'float',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'ente' => ['required', 'integer', 'exists:ente,id'],
            'matr' => ['required', 'integer', 'exists:performance_individuale,matr'],
            'anno' => ['required', 'integer', 'min:2000', 'max:2100'],
            'stabi' => ['required', 'integer', 'exists:stabilimento,id'],
            'repar' => ['required', 'integer', 'exists:reparto,id'],
            'stabival' => ['required', 'integer', 'exists:stabilimento,id'],
            'reparval' => ['required', 'integer', 'exists:reparto,id'],
            'disci' => ['required', 'integer', 'exists:disciplina,id'],
            'rep2kd' => ['required', 'integer', 'exists:reparto,id'],
            'rep2ka' => ['required', 'integer', 'exists:reparto,id'],
            'posiz' => ['required', 'integer', 'exists:posizione,id'],
            'propro' => ['required', 'integer', 'exists:profilo_professionale,id'],
            'posfun' => ['required', 'integer', 'exists:posizione_funzionale,id'],
            'categoria_eco' => ['required', 'string', 'max:255'],
            'qua2kd' => ['required', 'integer', 'exists:qualifica,id'],
            'qua2ka' => ['required', 'integer', 'exists:qualifica,id'],
            'dal' => ['required', 'integer', 'min:20000101', 'max:21001231'],
            'al' => ['required', 'integer', 'min:20000101', 'max:21001231'],
            'giornitempodet' => ['required', 'integer', 'min:0', 'max:365'],
            'ha_diritto' => ['required', 'integer', 'in:0,1'],
            'motivo' => ['required', 'string', 'max:255'],
            'esperienza_acquisita' => ['required', 'string', 'max:1000'],
            'risultati_ottenuti' => ['required', 'string', 'max:1000'],
            'arricchimento_professionale' => ['required', 'string', 'max:1000'],
            'impegno' => ['required', 'string', 'max:1000'],
            'qualita_prestazione' => ['required', 'string', 'max:1000'],
            'totale_punteggio' => ['required', 'numeric', 'min:0', 'max:100'],
            'lista_auth' => ['required', 'string', 'max:255'],
            'peso_esperienza_acquisita' => ['required', 'numeric', 'min:0', 'max:100'],
            'peso_risultati_ottenuti' => ['required', 'numeric', 'min:0', 'max:100'],
            'peso_arricchimento_professionale' => ['required', 'numeric', 'min:0', 'max:100'],
            'peso_impegno' => ['required', 'numeric', 'min:0', 'max:100'],
            'peso_qualita_prestazione' => ['required', 'numeric', 'min:0', 'max:100'],
            'datemod' => ['required', 'string', 'max:255'],
            'note' => ['required', 'string', 'max:1000'],
            'oree' => ['required', 'string', 'max:255'],
            'oret' => ['required', 'string', 'max:255'],
            'perc_parttime' => ['required', 'numeric', 'min:0', 'max:100'],
            'perc_parttimepond' => ['required', 'string', 'max:255'],
            'gg_parttimevert' => ['required', 'integer', 'min:0', 'max:365'],
            'ore_assenza' => ['required', 'string', 'max:255'],
            'giorni_assenza' => ['required', 'string', 'max:255'],
            'giorni_presenza' => ['required', 'string', 'max:255'],
            'categ_coeff' => ['required', 'string', 'max:255'],
            'quota_teorica' => ['required', 'string', 'max:255'],
            'budget_assegnato' => ['required', 'string', 'max:255'],
            'quota_effettiva' => ['required', 'string', 'max:255'],
            'resti' => ['required', 'string', 'max:255'],
            'resti_pond' => ['required', 'string', 'max:255'],
            'importo_totale' => ['required', 'string', 'max:255'],
            'gg_totale_sigma' => ['required', 'string', 'max:255'],
            'gg_validi_sigma' => ['required', 'string', 'max:255'],
            'gg_assenz_sigma' => ['required', 'string', 'max:255'],
            'decurtazione_perc' => ['required', 'string', 'max:255'],
            'gg_tempo_determinato' => ['required', 'integer', 'min:0', 'max:365'],
            'gg_posiz_1_in_sede' => ['required', 'integer', 'min:0', 'max:365'],
            'gg_assenza_anno' => ['required', 'integer', 'min:0', 'max:365'],
            'gg_presenza_anno' => ['required', 'integer', 'min:0', 'max:365'],
            'ore_assenza_anno' => ['required', 'string', 'max:255'],
            'posiz_txt' => ['required', 'string', 'max:255'],
            'clafun' => ['required', 'integer', 'exists:classe_funzionale,id'],
            'disci1' => ['required', 'integer', 'exists:disciplina,id'],
            'disci1_txt' => ['required', 'string', 'max:255'],
            'gg_ruolo' => ['required', 'integer', 'min:0', 'max:365'],
            'last_data_assunz' => ['required', 'integer', 'min:20000101', 'max:21001231'],
            'perc_parttime_anno' => ['required', 'string', 'max:255'],
            'perc_parttime_dalal' => ['required', 'string', 'max:255'],
            'gg_parttimevert_anno' => ['required', 'integer', 'min:0', 'max:365'],
            'gg_parttimevert_dalal' => ['required', 'integer', 'min:0', 'max:365'],
            'perc_parttimepond_anno' => ['required', 'string', 'max:255'],
            'perc_parttimepond_dalal' => ['required', 'string', 'max:255'],
            'gg_presenza_dalal' => ['required', 'integer', 'min:0', 'max:365'],
            'gg_assenza_dalal' => ['required', 'integer', 'min:0', 'max:365'],
            'hh_assenza_anno' => ['required', 'numeric', 'min:0', 'max:8760'],
            'hh_assenza_dalal' => ['required', 'numeric', 'min:0', 'max:8760'],
            'lang' => ['required', 'string', 'max:255'],
            'excellence' => ['required', 'integer', 'in:0,1'],
            'codqua' => ['required', 'integer', 'exists:qualifica,id'],
            'cont' => ['required', 'integer', 'exists:contratto,id'],
            'tipco' => ['required', 'integer', 'exists:tipo_contratto,id'],
            'posizione_eco' => ['required', 'string', 'max:255'],
            'gg_anno' => ['required', 'numeric', 'min:0', 'max:365'],
        ];
    }
}
