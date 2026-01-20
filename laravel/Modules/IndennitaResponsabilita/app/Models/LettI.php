<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Routing\Route as IlluminateRoute;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use LogicException;
use Modules\IndennitaResponsabilita\Models\Traits\FunctionTrait;
use Modules\IndennitaResponsabilita\Models\Traits\RelationshipTrait;
// ---- traits ---
use Modules\Ptv\Models\BaseScheda;
use Modules\Ptv\Models\Profile;
// --- services --
use Modules\Rating\Models\Traits\HasRatingsTrait;
// ---- external models ----
use Modules\Sigma\Models\Anag;
use Modules\Sigma\Models\Qua00f;
use Modules\Sigma\Models\Rep00f;
use Modules\Xot\Services\HtmlService;
use RuntimeException;

/**
 * Modules\IndennitaResponsabilita\Models\LettI.
 *
 * @property int|null $id
 * @property int|null $ente
 * @property int|null $matr
 * @property string|null $cognome
 * @property string|null $nome
 * @property string|null $email
 * @property int|null $stabi
 * @property int|null $repar
 * @property string|null $stabi_txt
 * @property string|null $repar_txt
 * @property int|null $rep2kd
 * @property int|null $rep2ka
 * @property int|null $propro
 * @property int|null $posfun
 * @property string|null $despro
 * @property int|null $posiz
 * @property int|null $qua2kd
 * @property int|null $qua2ka
 * @property int|null $tipco
 * @property int|null $codqua
 * @property string|null $qualifica
 * @property int|null $dalx
 * @property int|null $alx
 * @property Carbon|null $dalf dal retribuzione
 * @property Carbon|null $alf al retribuzione
 * @property Carbon|null $dali
 * @property Carbon|null $ali
 * @property int|null $anno
 * @property int|null $id_quale
 * @property string|null $posizione_lavoro
 * @property int|null $complessita
 * @property int|null $coordinamento
 * @property int|null $responsabilita
 * @property int|null $tot
 * @property string|null $valore_economico_calcolato
 * @property string|null $valore_economico_attribuito
 * @property string|null $archivista_informatico
 * @property string|null $relazioni_pubblico
 * @property string|null $protezione_civile
 * @property string|null $formatore_professionale
 * @property string|null $ha_diritto
 * @property string|null $motivo_escluso
 * @property string|null $datemod
 * @property string|null $handle
 * @property int|null $last_stato
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property string|null $deleted_ip
 * @property string|null $created_ip
 * @property string|null $updated_ip
 * @property string $categoria_eco
 * @property string $posiz_txt
 * @property string $lang
 * @property int|null $disci1
 * @property int|null $valutatore_id
 * @property Carbon|null $dal
 * @property Carbon|null $al
 * @property string $dali_ali
 * @property Collection<int, MyLog> $mailInviate
 * @property int|null $mail_inviate_count
 * @property Collection<int, IndennitaResponsabilita> $mails
 * @property int|null $mails_count
 * @property \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Message> $messages
 * @property int|null $messages_count
 * @property Collection<int, MyLog> $myLogs
 * @property int|null $my_logs_count
 * @property Collection<int, Rating> $ratings
 * @property int|null $ratings_count
 * @property StabiDirigente|null $stabiDirigente
 *
 * @method static Builder|LettI newModelQuery()
 * @method static Builder|LettI newQuery()
 * @method static Builder|LettI ofDate(int $date)
 * @method static Builder|LettI ofEnteYear(int $ente, int $year)
 * @method static Builder|LettI ofQuarter(int $quarter, int $year)
 * @method static Builder|LettI ofRangeDate(int $date_start, int $date_end)
 * @method static Builder|LettI ofYear(int $year)
 * @method static Builder|LettI query()
 * @method static Builder|LettI whereAl($value)
 * @method static Builder|LettI whereAlf($value)
 * @method static Builder|LettI whereAli($value)
 * @method static Builder|LettI whereAlx($value)
 * @method static Builder|LettI whereAnno($value)
 * @method static Builder|LettI whereArchivistaInformatico($value)
 * @method static Builder|LettI whereCategoriaEco($value)
 * @method static Builder|LettI whereCodqua($value)
 * @method static Builder|LettI whereCognome($value)
 * @method static Builder|LettI whereComplessita($value)
 * @method static Builder|LettI whereCoordinamento($value)
 * @method static Builder|LettI whereCreatedAt($value)
 * @method static Builder|LettI whereCreatedBy($value)
 * @method static Builder|LettI whereCreatedIp($value)
 * @method static Builder|LettI whereDal($value)
 * @method static Builder|LettI whereDalf($value)
 * @method static Builder|LettI whereDali($value)
 * @method static Builder|LettI whereDalx($value)
 * @method static Builder|LettI whereDatemod($value)
 * @method static Builder|LettI whereDeletedAt($value)
 * @method static Builder|LettI whereDeletedBy($value)
 * @method static Builder|LettI whereDeletedIp($value)
 * @method static Builder|LettI whereDespro($value)
 * @method static Builder|LettI whereDisci1($value)
 * @method static Builder|LettI whereEmail($value)
 * @method static Builder|LettI whereEnte($value)
 * @method static Builder|LettI whereFormatoreProfessionale($value)
 * @method static Builder|LettI whereHaDiritto($value)
 * @method static Builder|LettI whereHandle($value)
 * @method static Builder|LettI whereId($value)
 * @method static Builder|LettI whereIdQuale($value)
 * @method static Builder|LettI whereLang($value)
 * @method static Builder|LettI whereLastStato($value)
 * @method static Builder|LettI whereMatr($value)
 * @method static Builder|LettI whereMotivoEscluso($value)
 * @method static Builder|LettI whereNome($value)
 * @method static Builder|LettI wherePosfun($value)
 * @method static Builder|LettI wherePosiz($value)
 * @method static Builder|LettI wherePosizTxt($value)
 * @method static Builder|LettI wherePosizioneLavoro($value)
 * @method static Builder|LettI wherePropro($value)
 * @method static Builder|LettI whereProtezioneCivile($value)
 * @method static Builder|LettI whereQua2ka($value)
 * @method static Builder|LettI whereQua2kd($value)
 * @method static Builder|LettI whereQualifica($value)
 * @method static Builder|LettI whereRelazioniPubblico($value)
 * @method static Builder|LettI whereRep2ka($value)
 * @method static Builder|LettI whereRep2kd($value)
 * @method static Builder|LettI whereRepar($value)
 * @method static Builder|LettI whereReparTxt($value)
 * @method static Builder|LettI whereResponsabilita($value)
 * @method static Builder|LettI whereStabi($value)
 * @method static Builder|LettI whereStabiTxt($value)
 * @method static Builder|LettI whereTipco($value)
 * @method static Builder|LettI whereTot($value)
 * @method static Builder|LettI whereUpdatedAt($value)
 * @method static Builder|LettI whereUpdatedBy($value)
 * @method static Builder|LettI whereUpdatedIp($value)
 * @method static Builder|LettI whereValoreEconomicoAttribuito($value)
 * @method static Builder|LettI whereValoreEconomicoCalcolato($value)
 * @method static Builder|LettI whereValutatoreId($value)
 * @method static Builder|LettI withDays(int $date_min, int $date_max)
 *
 * @property Profile|null $creator
 * @property RatingMorph|null $pivot
 * @property Profile|null $updater
 *
 * @method static Builder<static>|LettI ofEnte(int $ente)
 * @method static Builder<static>|LettI ofFourMonthPeriod(int $fourMonthPeriod, int $year)
 *
 * @mixin \Eloquent
 */
class LettI extends BaseScheda
{
    use FunctionTrait;
    use HasRatingsTrait;
    use RelationshipTrait;

    public string $from_field = 'dal';

    public string $to_field = 'al';

    protected $table = 'indennita_responsabilita';

    /** @var list<string> */
    protected $fillable = [
        'id', 'ente', 'matr', 'stabi', 'repar', 'anno', 'dal', 'al', 'dalf', 'alf', 'dali', 'ali',
        'archivista_informatico', 'relazioni_pubblico', 'protezione_civile', 'formatore_professionale',
    ];

    protected $appends = ['dali__ali'];

    public array $xls_fields = ['ente', 'matr', 'cognome', 'nome', 'email', 'propro', 'posfun',
        'categoria_eco', 'dal', 'al', 'archivista_informatico', 'relazioni_pubblico',
        'protezione_civile', 'formatore_professionale', ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'dal' => 'datetime',
            'al' => 'datetime',
            'dalf' => 'datetime',
            'alf' => 'datetime',
            'dali' => 'datetime',
            'ali' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // --------- relationship ----------
    public function importi(): ?object
    {
        $row = $this->hasOne(ImportiCategoria::class, 'ente', 'ente')->where('anno', $this->anno)->whereRaw('find_in_set('.$this->propro.',lista_propro)');
        if ($row->count() === 0) {
            $rowOld = ImportiCategoria::where('ente', $this->ente)
                ->where('anno', $this->anno - 1)
                ->whereRaw('find_in_set('.$this->propro.',lista_propro)');
            if ($rowOld->count() !== 1) {
                Log::error("qualcosa e' andato storto [".__LINE__.']['.__FILE__.']');
            }

            /** @var ImportiCategoria|null $firstRow */
            $firstRow = $rowOld->first();
            if ($firstRow === null) {
                return null;
            }
            $row = $firstRow->replicate();
            /** @var int|null $anno */
            $anno = $this->anno;
            if ($anno !== null) {
                $row->anno = $anno;
            }
            $row->save();
            $row = $this->hasOne(ImportiCategoria::class, 'ente', 'ente')
                ->where('anno', $this->anno)
                ->whereRaw('find_in_set('.$this->propro.',lista_propro)');
        }

        return $row;
    }

    /*
    public function anag(): HasOne {
        return $this->hasOne(Anag::class, 'matr', 'matr')->where('ente', $this->ente);
    }
    */
    public function stabiDirigente(): HasOne
    {
        return $this->hasOne(StabiDirigente::class, 'stabi', 'stabi')
            ->where('repar', $this->repar)
            ->where('anno', $this->anno);
    }

    // -------------------------------------------------------------------------------------
    public function mailInviate(): HasMany
    {
        return $this->hasMany(MyLog::class, 'id_tbl', 'id')->where('tbl', $this->getTable())->where('note', 'sendMailLettI');
    }

    // --------- mutators ---------
    /**
     * @param  mixed  $value
     */
    public function getDaliAttribute($value): ?Carbon
    {
        /** @var int|null $anno */
        $anno = $this->anno;
        if ($value === null && $anno !== null) {
            $value = Carbon::createFromDate($anno, 1, 1);
        }

        if (\is_string($value)) {
            $value = Carbon::parse($value);
        }

        if ($value instanceof Carbon && $this->getKey() !== null) {
            // ✅ Persist con update chirurgico (salva SOLO questo campo, previene loop)
            $this->update(['dali' => $value]);
        }

        return $value instanceof Carbon ? $value : null;
    }

    /**
     * @param  mixed  $value
     */
    public function getAliAttribute($value): ?Carbon
    {
        /** @var int|null $anno */
        $anno = $this->anno;
        if ($value === null && $anno !== null) {
            $value = Carbon::createFromDate($anno, 12, 31);
        }

        if (\is_string($value)) {
            $value = Carbon::parse($value);
        }

        if ($value instanceof Carbon && $this->getKey() !== null) {
            // ✅ Persist con update chirurgico (salva SOLO questo campo, previene loop)
            $this->update(['ali' => $value]);
        }

        return $value instanceof Carbon ? $value : null;
    }

    /**
     * @param  mixed  $value
     */
    public function getDaliAliAttribute($value): string
    {
        /** @var Carbon|null $ali */
        $ali = $this->ali;
        /** @var Carbon|null $dali */
        $dali = $this->dali;
        if ($ali === null || $dali === null) {
            return '';
        }

        return $ali->format('d/m/Y').' - '.$dali->format('d/m/Y');
    }

    public function setDaliAliAttribute(mixed $value): never
    {
        Log::debug('LettI value', ['value' => $value]);

        throw new LogicException('Cannot set dali_ali attribute directly. This is a computed property.');
    }

    /**
     * @param  Carbon|string|null  $value
     */
    public function setDaliAttribute($value): void
    {
        if (\is_string($value)) {
            // @phpstan-ignore-next-line
            $value = Carbon::createFromFormat('d/m/Y', $value);
            if (! ($value instanceof Carbon)) {
                return;
            }
        }

        // ✅ Persist con update chirurgico (salva SOLO questo campo, previene loop)
        if ($this->getKey() !== null) {
            $this->update(['dali' => $value]);
        }
    }

    /**
     * @return array<string, mixed>
     */
    protected static function getRouteParameters(): array
    {
        if (app()->runningInConsole()) {
            return [];
        }

        $route = Request::route();
        if (! $route instanceof IlluminateRoute) {
            return [];
        }

        $params = $route->parameters();
        if (! is_array($params)) {
            return [];
        }

        /** @var array<string, mixed> $result */
        $result = [];
        foreach ($params as $key => $value) {
            if (is_string($key)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * @param  Carbon|string|null  $value
     */
    public function setAliAttribute($value): void
    {
        if (\is_string($value)) {
            // @phpstan-ignore-next-line
            $value = Carbon::createFromFormat('d/m/Y', $value);
            if (! ($value instanceof Carbon)) {
                return;
            }
        }

        $this->attributes['ali'] = $value;
    }

    public function getEmailAttribute(?string $value): ?string
    {
        if ($value !== null && $value !== '') {
            return $value;
        }

        /** @var Anag|null $anag */
        $anag = $this->anag;
        if ($anag === null) {
            return '';
        }

        /** @var string|null $emailFromAnag */
        $emailFromAnag = $anag->email ?? null;
        if ($emailFromAnag === null || $emailFromAnag === '') {
            return '';
        }

        // ✅ Persist con update chirurgico (salva SOLO questo campo, previene loop)
        if ($this->getKey() !== null) {
            $this->update(['email' => $emailFromAnag]);
        }

        return $emailFromAnag;
    }

    // ---------------------------------------
    // --------- functions ---------
    /**
     * @param  array<string, mixed>  $params
     */
    public static function updateFields(array $params = []): void
    {
        $routeParams = getRouteParameters();
        $params = array_merge($routeParams, $params);
        /** @var int|string|null $annoRaw */
        $annoRaw = $params['anno'] ?? date('Y');
        $anno = is_numeric($annoRaw) ? (int) $annoRaw : (int) date('Y');
        /** @var int|string|null $stabi */
        $stabi = $params['stabi'] ?? null;
        /** @var int|string|null $repar */
        $repar = $params['repar'] ?? null;
        if ($stabi === null || $repar === null) {
            return;
        }
        $sql = '(
    		('.$anno.' between year(rep2kd) and year(rep2ka))
    		or
    		('.$anno.' >= year(rep2kd) and rep2ka=0)
    	)';
        /** @var Builder<Rep00f> $rows0 */
        $rows0 = Rep00f::where('repst1', $stabi)->where('repre1', $repar)->whereRaw($sql)->whereRaw('repann=""');
        foreach ($rows0->get() as $row) {
            $parz = ['ente' => $row->ente,
                'matr' => $row->matr,
                'stabi' => $row->repst1,
                'repar' => $row->repre1,
                'rep2kd' => $row->rep2kd,
                'rep2ka' => $row->rep2ka,
                'anno' => $anno, ];

            $obj = self::firstOrCreate($parz);
            $obj->rep2kd = $row->rep2kd;
            $obj->rep2ka = $row->rep2ka;
            if ($obj->dali === null) {
                $obj->dali = Carbon::createFromDate($anno, 1, 1);
            }

            if ($obj->ali === null) {
                $obj->ali = Carbon::createFromDate($anno, 12, 31);
            }

            if ($obj->dalf === null) {
                $obj->dalf = Carbon::createFromDate($anno, 1, 1);
            }

            if ($obj->alf === null) {
                $obj->alf = Carbon::createFromDate($anno, 12, 31);
            }

            if ($obj->propro === 0 || $obj->propro === null) {
                $sql = '
                (
                    ('.$obj->dalf->format('Ymd').' between qua2kd and qua2ka )
                    or
                    ('.$obj->dalf->format('Ymd').' >= qua2kd and qua2ka=0 )
                    or
                    ('.$obj->alf->format('Ymd').' between qua2kd and qua2ka )
                    or
                    ('.$obj->alf->format('Ymd').' >= qua2kd and qua2ka=0 )
                    or
                    (qua2kd between '.$obj->dalf->format('Ymd').' and '.$obj->alf->format('Ymd').')
                    or
                    (qua2ka between '.$obj->dalf->format('Ymd').' and '.$obj->alf->format('Ymd').')
                )
                ';
                /** @var Anag|null $anag */
                $anag = $obj->anag;
                if ($anag === null) {
                    continue;
                }
                /** @var Builder<Qua00f> $qua00fQuery */
                $qua00fQuery = $anag->qua00f()->select('propro', 'posfun', 'posiz')->distinct()->whereRaw($sql);
                /** @var Collection<int, Qua00f> $qua00fCollection */
                $qua00fCollection = $qua00fQuery->get();
                // echo '<br/>'.$qua00f->count().' - '.$qua00f->first()->propro.'  - '.$qua00f->first()->posfun;
                if ($qua00fCollection->count() === 1) {
                    /** @var Qua00f|null $firstQua00f */
                    $firstQua00f = $qua00fCollection->first();
                    if ($firstQua00f !== null) {
                        $obj->propro = $firstQua00f->propro;
                        $obj->posfun = $firstQua00f->posfun;
                        $obj->posiz = $firstQua00f->posiz;
                    }
                } else {
                    echo '<br/>$qua00f->count() : '.$qua00fCollection->count();
                    echo '<br/>ente :'.$obj->ente;
                    echo '<br/>matr :'.$obj->matr;
                    echo "<br/>qualcosa e' andato storto [".__LINE__.']['.__FILE__.']';
                    echo '<pre>';
                    print_r($qua00fQuery->toSql());
                    /** @var Collection<int, Qua00f> $qua00f */
                    $qua00f = $anag->qua00f()->whereRaw($sql)->orderBy('qua2kd')->get();

                    // foreach($qua00f as $v_qua00f){
                    if ($qua00f->count() < 2) {
                        continue;
                    }
                    /** @var Qua00f|null $firstQua00f */
                    $firstQua00f = $qua00f->get(0);
                    /** @var Qua00f|null $secondQua00f */
                    $secondQua00f = $qua00f->get(1);
                    if ($firstQua00f === null || $secondQua00f === null) {
                        continue;
                    }

                    // Preserve original $obj->al BEFORE any modification (critical for replicate)
                    /** @var Carbon|null $alOld */
                    $alOld = $obj->al;

                    /** @var int|string|null $qua2kd */
                    $qua2kd = $secondQua00f->qua2kd;
                    if ($alOld === null || $qua2kd === null) {
                        continue;
                    }

                    // Update original object
                    $obj->al = Carbon::parse((string) $qua2kd);
                    $obj->save();

                    // Create replicated object with second qualification
                    $obj1 = $obj->replicate();
                    /** @var int|string|null $secondQua2kd */
                    $secondQua2kd = $secondQua00f->qua2kd;
                    if ($secondQua2kd !== null) {
                        $obj1->dal = Carbon::parse((string) $secondQua2kd);
                    }
                    /** @var int|string|null $secondQua2ka */
                    $secondQua2ka = $secondQua00f->qua2ka ?? null;
                    if ($secondQua2ka !== null && $secondQua2ka !== 0) {
                        $obj1->al = Carbon::parse((string) $secondQua2ka);
                    } elseif ($alOld instanceof Carbon) {
                        // Use preserved original value (type-safe check)
                        $obj1->al = $alOld;
                    }
                    // Note: id will be auto-generated on save
                    $obj1->save();
                }
            }

            $obj->save();
        }

        $obj = new self;
        $table = $obj->getTable();
        $conn = $obj->getConnection();
        $where = $table.'.anno="'.$anno.'" ';
        // Anag::massUpdateCognomeNome(['conn' => $conn, 'table' => $table, 'where' => $where]);
        // Anag::massUpdateCategoriaEco(['conn' => $conn, 'table' => $table, 'where' => $where]);
        // Anag::massUpdatePosizTxt(['conn' => $conn, 'table' => $table, 'where' => $where]);
        // Anag::massUpdateStabiTxtReparTxt(['conn' => $conn, 'table' => $table, 'where' => $where]);
    }

    /**
     * Generate PDF content from a view.
     */
    public function content_PDF(string $view): string
    {
        // $view='admin.performance.individuale.pdf';
        /** @var int|null $anno */
        $anno = $this->anno;
        /** @var view-string $viewString */
        $viewString = $view;
        /** @var string $content */
        $content = view($viewString, ['row' => $this, 'anno' => $anno])->render();

        /** @var int|null $id */
        $id = $this->id;
        if ($id === null) {
            throw new RuntimeException('Cannot generate PDF for record without ID');
        }

        /** @var string $result */
        $result = HtmlService::toPdf($content, 'content_PDF', 'L', (string) $id);

        return $result;
    }

    // end content_PDF
}
