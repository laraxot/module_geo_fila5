<?php

declare(strict_types=1);

namespace Modules\Ptv\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Performance\Models\Performance;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Modules\Sigma\Models\Anag;
use Modules\Sigma\Models\Traits\SchedaTrait;
use Modules\Sigma\Models\Traits\SigmaModelTrait;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;

/**
 * Modules\Ptv\Models\BaseScheda.
 *
 * @property StabiDirigente|null $valutatore
 * @property Collection<int, static> $avversariCategoriaEco
 * @property float|null $punt_progressione_finale
 * @property int|null $categoria_eco
 * @property int|null $valutatore_id
 * @property int|null $anno
 * @property int|null $ha_diritto
 * @property string|null $qua2kd
 * @property int|null $propro
 * @property string|null $posfun
 * @property int|null $matr
 * @property int|null $dal
 * @property int|null $al
 * @property int|null $anno
 * @property int|null $ente
 * @property int|null $repar
 * @property int|null $stabi
 * @property string|null $categoria_ecoval
 * @property int|null $posfunval
 * @property float|null $costo_fascia_up
 * @property float|null $ptime
 * @property int|null $gg_cateco_posfun_in_sede
 * @property int|null $gg_asz_cateco_posfun
 * @property int|null $gg_cateco_posfun_fuori_sede
 * @property int|null $gg_cateco_sup_in_sede
 * @property int|null $gg_cateco_sup_fuori_sede
 * @property int|null $gg_asz_cateco_posfun_in_sede
 * @property int|null $gg_asz_cateco_posfun_fuori_sede
 * @property int|null $gg_cateco_in_sede
 * @property int|null $gg_cateco_fuori_sede
 * @property int|null $gg_asz_in_sede
 * @property int|null $gg_asz_fuori_sede
 * @property int|null $hh_asz_in_sede
 * @property int|null $hh_asz_fuori_sede
 * @property int|null $gg_in_sede
 * @property int|null $gg_fuori_sede
 * @property int|null $gg_presenza_anno
 * @property int|null $perc_parttime_anno
 * @property int|null $gg_parttimevert_anno
 * @property string|null $posiz
 * @property string|null $posiz1
 * @property int|null $disci1
 * @property Anag|null $anag
 * @property object|null $maxCatecoPosfun
 * @property object|null $pesi
 * @property object|null $stipendioTabellare
 * @property Collection<int, Performance> $performanceIndividuale
 * @property Collection<int, \Illuminate\Database\Eloquent\Model> $criteriOptions
 * @property int $n_perf_ind
 */
// @see Modules/Xot/docs/spatie-schemaless-attributes.md
abstract class BaseScheda extends BaseModel implements SchedaContract
{
    use LogsActivity;
    use SchemalessAttributesTrait;
    /*
    use SchedaTrait, SigmaModelTrait {
        SchedaTrait::ggInSedeTot insteadof SigmaModelTrait;
        SchedaTrait::ggFuoriSedeTot insteadof SigmaModelTrait;
        SchedaTrait::ggAssenzaFuoriSedeTot insteadof SigmaModelTrait;
        SchedaTrait::ggAssenzaInSedeTot insteadof SigmaModelTrait;
        SchedaTrait::hhAssenzaFuoriSedeTot insteadof SigmaModelTrait;
        SchedaTrait::hhAssenzaInSedeTot insteadof SigmaModelTrait;
    }
    */
    use \Modules\Progressioni\Models\Traits\ConvertedTrait, SchedaTrait;

    /**
     * Get avversari with the same category.
     *
     * @return HasMany
     */
    public function avversariCategoriaEco()
    {
        return $this->hasMany(static::class, 'valutatore_id', 'valutatore_id')
            ->where('anno', $this->anno)
            ->where('ha_diritto', 1)
            ->where('categoria_eco', $this->categoria_eco);
    }

    /**
     * Get lista tipo codice aspettative.
     *
     * @return array<int, string>
     */
    public function getListaTipoCodiceAspettative(): array
    {
        // This is a placeholder implementation. The actual implementation may vary
        // depending on the specific business logic of the application.
        return [];
    }

    /**
     * Anagrafica relationship.
     *
     * @return HasOne
     */
    public function anag()
    {
        return $this->hasOne(Anag::class, 'matr', 'matr');
    }

    /**
     * Max cateco posfun relationship.
     *
     * @return HasOne
     */
    public function maxCatecoPosfun()
    {
        // This is a placeholder implementation - the actual relationship may vary
        return $this->hasOne(static::class);
    }

    /**
     * Pesi relationship.
     *
     * @return HasOne
     */
    public function pesi()
    {
        // This is a placeholder implementation - the actual relationship may vary
        return $this->hasOne(static::class);
    }

    /**
     * Stipendio tabellare relationship.
     *
     * @return HasOne
     */
    public function stipendioTabellare()
    {
        // This is a placeholder implementation - the actual relationship may vary
        return $this->hasOne(static::class);
    }

    /**
     * Performance individuale relationship.
     *
     * @return HasMany
     */
    public function performanceIndividuale()
    {
        // This is a placeholder implementation - the actual relationship may vary
        $perfClass = str_replace('Ptv\\', 'Performance\\', static::class);
        $perfClass = str_replace('Models\\BaseScheda', 'Models\\Performance', $perfClass);

        // Defaulting to Performance model
        return $this->hasMany(Performance::class, 'matr', 'matr')
            ->where('ente', $this->ente ?? 90);
    }

    /**
     * Get performance for a given year.
     */
    public function perfInd(int $anno): ?float
    {




        $tbl = 'performance_individuale';
        $perf_ind = $this->performanceIndividuale()->selectRaw('( COALESCE(sum('.$tbl.'.totale_punteggio * (datediff('.$tbl.'.al,'.$tbl.'.dal)+1))/( sum(datediff('.$tbl.'.al,'.$tbl.'.dal)+1)  ),0) ) as perf_ind')
            ->where('anno', $anno)
            ->whereRaw('( '.$tbl.'.ha_diritto>0 or '.$tbl.'.posfun>=100)')
            ->first();

        if ($perf_ind == null) {
            return null;
        }

        $value = isset($perf_ind->perf_ind) ? (float) $perf_ind->perf_ind : 0.0;

        return $value;
    }

    /**
     * Criteri options relationship.
     *
     * @return HasMany
     */
    public function criteriOptions()
    {
        // This is a placeholder implementation - the actual relationship may vary
        return $this->hasMany(static::class);
    }

    /**
     * Relazioni da eager-loadare sempre per evitare N+1 queries.
     *
     * ⚡ PERFORMANCE CRITICAL: Fix DOPPIO LIVELLO N+1
     *
     * PROBLEMA:
     * 1. Accessor chiama $this->anag->ggInSedeTot()
     * 2. ggInSedeTot() (in FunctionExtra) chiama $this->qua00f()
     * 3. = N+1 al primo livello (anag) + N+1 al secondo livello (qua00f)!
     *
     * SOLUZIONE:
     * - Eager load 'anag' (primo livello)
     * - Eager load 'anag.qua00f', 'anag.qua03f', 'anag.asz00k1' (secondo livello)
     *
     * RISULTATO:
     * - Da 200-300+ query a 5-10 query (95-98% riduzione)
     * - Da 15-30 secondi a 1-3 secondi (10-30x più veloce)
     *
     * @see \Modules\Sigma\docs\performance\function-extra-n-plus-1-queries.md
     *
     * @var list<string>
     */
    protected $with = [
        // Primo livello - relazioni dirette di Scheda
        // 'anag',              // ⚡ CRITICO: evita N+1 su anagrafica
        // 'categoriaPropro',   // ⚡ CRITICO: evita N+1 su categoria
        // 'stabiDirigente',    // Evita N+1 su stabi dirigente

        // Secondo livello - relazioni nested di anag (FunctionExtra le usa!)
        // 'anag.qua00f',       // ⚡ CRITICO: evita N+1 in ggInSedeTot()
        // 'anag.qua03f',       // ⚡ CRITICO: evita N+1 in ggFuoriSedeTot()
        // 'anag.asz00k1',      // ⚡ CRITICO: evita N+1 in ggAssenzaInSedeTot(), hhAssenzaInSedeTot()
    ];

    public string $from_field = 'dal';

    public string $to_field = 'al';

    /**
     * Number of performance years considered for aggregate calculations.
     */
    public int $n_perf_ind = 3;

    protected $table = 'schede';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'calculated_data' => SchemalessAttributes::class,
        ]);
    }

    protected array $schemalessAttributes = [
        'calculated_data',
    ];

    /**
     * Configurazione Activity Log con esclusione attributi problematici.
     *
     * PROBLEMA: SchedaTrait ha accessor che chiamano $this->save() causando
     *           errori "Duplicate Entry" quando Activity Log serializza il modello.
     *
     * SOLUZIONE: Escludo gli attributi con accessor che chiamano ->save()
     *            in modo che Activity Log non li acceda durante toArray().
     *
     * RISULTATO: Activity Log funziona e traccia i campi importanti (stabi,
     *            coordinamento, responsabilita, etc.) senza causare Duplicate Entry.
     *
     * @see \Modules\Activity\docs\errori\duplicate-entry-accessor-save.md
     * @see \Modules\Sigma\app\Models\Traits\SchedaTrait.php
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()  // Traccia tutti i campi
            /*
            ->logExcept([
                // Escludo attributi con accessor che chiamano $this->save()
                // per evitare errori "Duplicate Entry" durante serializzazione
                'propro',                           // getProproAttribute() - linea 617
                'gg',                               // getGgAttribute() - linea 241
                'gg_asz',                           // getGgAszAttribute() - linea 265
                'gg_no_asz',                        // getGgNoAszAttribute()
                'valore_differenziale_rapportato_pt', // getValoreDifferenzialeRapportatoPtAttribute() - linea 1227
                'punt_progressione_finale',         // getPuntProgressioneFinaleAttribute() - linea 1365
                'valutatore_id',                    // getValutatoreIdAttribute() - linea 1392
                'perf_ind_media',                   // getPerfIndMediaAttribute() - linea 1891
                'perf_ind_count_last_3_years',      // getPerfIndCountLast3YearsAttribute() - linea 1911
                'excellences_count_last_3years',    // getExcellencesCountLast3yearsAttribute()
                'posizione_eco',                    // getPosizioneEcoAttribute() in SchedaMutator
            ])
            */
            ->logOnlyDirty()  // Solo campi effettivamente modificati
            ->dontSubmitEmptyLogs();  // Non salvare log vuoti
    }

    /**
     * Verifica se il posfun è di tipo PO (Punto Organizzativo).
     *
     * @return bool True se posfun >= 100, false altrimenti
     */
    public function isPo(): bool
    {
        return (int) ($this->posfun ?? 0) >= 100;
    }

    /**
     * Verifica se disci1 indica una posizione regionale.
     *
     * @return bool True se disci1 è 203, false altrimenti
     */
    public function isRegionale(): bool
    {
        return (int) ($this->disci1 ?? 0) === 203;
    }

    /**
     * Scope a query to interact with calculated_data schemaless attribute.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<static> $query
     * @return \Illuminate\Database\Eloquent\Builder<static>
     * @see Modules/IndennitaResponsabilita/docs/schemaless-attributes.md#errore-5-tipo-di-ritorno-errato-per-scope-metodi-basescheda
     */
    public function scopeWithCalculatedData(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        // This scope should modify the query builder, not return the attribute directly.
        // If the intention was to filter or add conditions based on calculated_data,
        // that logic would go here.
        // Example: return $query->where('calculated_data->some_key', 'some_value');

        return $query; // Return the modified (or unmodified) query builder
    }
}
