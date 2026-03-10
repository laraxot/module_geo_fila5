<?php

declare(strict_types=1);

namespace Modules\Performance\Actions\Organizzativa;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Performance\Models\Organizzativa as Scheda;
use Spatie\QueueableAction\QueueableAction;

/**
 * Aggiorna l'importo totale basandosi sui resti ponderati per valutatore_id.
 *
 * Questa Action calcola l'importo totale finale per ogni scheda sommando
 * la quota effettiva con i resti ponderati redistribuiti in base al valutatore_id.
 * È l'ultimo passaggio nella pipeline di distribuzione basata su valutatore_id.
 */
class UpdateImportoTotaleByValutatoreIdAction
{
    use QueueableAction;

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
     * Calcola l'importo totale per ogni scheda.
     *
     * @param  string  $year  Anno di riferimento
     * @param  string  $type  Tipo di performance ('dip' per dipendenti)
     */
    public function execute(string $year, string $type = 'dip'): void
    {
        // Ottieni il nome della tabella
        $tbl = $this->model->getTable();

        // Log dell'inizio dell'operazione
        echo "<br/>Aggiornamento importo totale per valutatore_id, anno: {$year}, tipo: {$type}\n";

        // Prima azzera l'importo totale per tutte le schede dell'anno
        $this->model->where('anno', $year)
            ->where('type', $type)
            ->update(['importo_totale' => 0]);

        // Poi aggiorna l'importo totale per le schede con diritto
        $updated = $this->model->where('anno', $year)
            ->where('type', $type)
            ->where('ha_diritto', '>', 0)
            ->update([
                'importo_totale' => DB::raw('quota_effettiva + resti_pond'),
            ]);

        // Log dell'operazione completata
        echo "Importo totale per valutatore_id aggiornato per {$updated} record, anno: {$year}, tipo: {$type}\n";

        // Verifica la somma totale per assicurare la correttezza
        $sumImportoTotale = $this->model->where('anno', $year)
            ->where('type', $type)
            ->sum('importo_totale');

        $sumBudgetAssegnato = $this->model->where('anno', $year)
            ->where('type', $type)
            ->sum('budget_assegnato');

        $delta = abs($sumImportoTotale - $sumBudgetAssegnato);

        if ($delta > 0.1) {
            echo 'Potenziale discrepanza nella redistribuzione per valutatore_id: '.
                "importo_totale = {$sumImportoTotale}, budget_assegnato = {$sumBudgetAssegnato}, ".
                "delta = {$delta}, anno: {$year}, tipo: {$type}\n";
        } else {
            echo "Verifica passata: somma importo_totale = {$sumImportoTotale}, ".
                "budget_assegnato = {$sumBudgetAssegnato}, ".
                "anno: {$year}, tipo: {$type}\n";
        }
    }
}
