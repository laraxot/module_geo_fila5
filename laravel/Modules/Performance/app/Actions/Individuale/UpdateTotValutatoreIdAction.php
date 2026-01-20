<?php

declare(strict_types=1);

namespace Modules\Performance\Actions\Individuale;

use Illuminate\Support\Facades\DB;
use Modules\Performance\Models\Individuale as Schede;
use Modules\Performance\Models\IndividualeTotValutatoreId as TotValutatoreId;
use Spatie\QueueableAction\QueueableAction;

/**
 * Aggrega i totali per ogni valutatore per i calcoli di performance individuale.
 *
 * Questa Action crea e aggiorna i record nella tabella individuale_tot_valutatore_id,
 * calcolando i totali per budget_assegnato, quota_effettiva e resti per ogni valutatore.
 * Inoltre calcola il coefficiente delta necessario per la redistribuzione dei resti.
 */
class UpdateTotValutatoreIdAction
{
    use QueueableAction;

    /**
     * I campi per cui calcolare i totali.
     *
     * @var array<int, string>
     */
    protected array $fields = ['budget_assegnato', 'quota_effettiva', 'resti'];

    /**
     * Il modello Schede per le query.
     */
    protected Schede $model;

    /**
     * Costruttore.
     *
     * @param  Schede  $schedeModel  Il modello Schede
     */
    public function __construct(Schede $schedeModel)
    {
        $this->model = $schedeModel;
    }

    /**
     * Esegue l'aggregazione dei totali per valutatore.
     *
     * @param  string  $year  Anno di riferimento
     * @param  string  $type  Tipo di performance ('dip' per dipendenti)
     */
    public function execute(string $year, string $type = 'dip'): void
    {
        $this->clearExistingRecords($year);
        $this->createRecordsForValutatori($year, $type);
        $this->updateTotals($year, $type);
        $this->calculateDeltas($year);
    }

    protected function clearExistingRecords(string $year): void
    {
        TotValutatoreId::where('anno', $year)->delete();
        echo "Cancellati record aggregati individuali per anno: {$year}<br>\n";
    }

    protected function createRecordsForValutatori(string $year, string $type): void
    {
        $valutatoriIds = $this->model
            ->where('anno', $year)
            ->where('type', $type)
            ->whereNotNull('valutatore_id')
            ->distinct()
            ->pluck('valutatore_id');
        foreach ($valutatoriIds as $valutatoreId) {
            TotValutatoreId::create([
                'valutatore_id' => $valutatoreId,
                'anno' => $year,
            ]);
        }
        echo "Creati record aggregati individuali per valutatori, anno: {$year}<br>\n";
    }

    protected function updateTotals(string $year, string $type): void
    {
        // TODO: Assicurarsi che tutti i totali aggregati per valutatore (budget_assegnato, quota_effettiva, resti) siano già ponderati per il punteggio individuale.
        // 1. Non sommare mai valori non ponderati.
        // 2. Se il punteggio di tutti i dipendenti di un valutatore è 0, i totali devono essere 0.
        // 3. Edge case: divisione per zero nei delta, gestire con fallback a 0.
        // 4. Dopo la modifica, verificare che la somma dei totali per tutti i valutatori sia coerente con la quota individuale del fondo.
        // 5. Aggiornare la documentazione e i test automatici dopo la modifica.
        foreach ($this->fields as $field) {
            $totals = $this->model
                ->where('anno', $year)
                ->where('type', $type)
                ->where('ha_diritto', '>', 0)
                ->whereNotNull('valutatore_id')
                ->select('valutatore_id')
                ->selectRaw("SUM({$field}) as total")
                ->groupBy('valutatore_id')
                ->get();
            foreach ($totals as $total) {
                if (is_null($total->valutatore_id)) {
                    echo 'Valutatore ID null trovato durante aggiornamento totali individuale';

                    continue;
                }
                TotValutatoreId::where('valutatore_id', $total->valutatore_id)
                    ->where('anno', $year)
                    ->update([
                        "tot_{$field}" => $total->total ?? 0,
                        "tot_{$field}_min_punteggio" => $total->total ?? 0,
                    ]);
            }
            echo "Aggregati totali per campo {$field}, anno: {$year} (individuale)<br>\n";
        }
    }

    protected function calculateDeltas(string $year): void
    {
        // Il delta deve essere calcolato su valori già ponderati per punteggio.
        // delta = tot_resti / tot_quota_effettiva
        // delta_min_punteggio = tot_resti_min_punteggio / tot_quota_effettiva_min_punteggio
        $updated = TotValutatoreId::where('anno', $year)
            ->update([
                'delta' => DB::raw('tot_resti / NULLIF(tot_quota_effettiva, 0)'),
                'delta_min_punteggio' => DB::raw('tot_resti_min_punteggio / NULLIF(tot_quota_effettiva_min_punteggio, 0)'),
            ]);
        TotValutatoreId::where('anno', $year)
            ->whereNull('delta')
            ->update(['delta' => 0]);
        TotValutatoreId::where('anno', $year)
            ->whereNull('delta_min_punteggio')
            ->update(['delta_min_punteggio' => 0]);
        echo "Calcolati coefficienti delta per {$updated} valutatori (individuale), anno: {$year}<br>\n";
    }
}
