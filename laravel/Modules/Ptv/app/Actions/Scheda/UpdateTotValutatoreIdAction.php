<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Scheda;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\QueueableAction\QueueableAction;

/**
 * Aggrega i totali per ogni valutatore per i calcoli di performance.
 *
 * Nota: Questa action dipende da modelli specifici di Performance (OrganizzativaTotValutatoreId).
 */
class UpdateTotValutatoreIdAction
{
    use QueueableAction;

    /**
     * @var array<int, string>
     */
    protected array $fields = ['budget_assegnato', 'quota_effettiva', 'resti'];

    /**
     * @param  class-string<Model>  $class
     */
    public function execute(string $class, string $year, string $type): void
    {
       
        $totValutatoreIdClass=$class.'TotValutatoreId';
        // Cancella i record esistenti per l'anno
        $totValutatoreIdClass::where('anno', $year)->delete();
        echo "Cancellati record esistenti per anno: {$year}\n";

        // Trova tutti i valutatori_id distinti
        $valutatoriIds = $class::where('anno', $year)
            ->where('type', $type)
            ->whereNotNull('valutatore_id')
            ->distinct()
            ->pluck('valutatore_id');

        // Crea record per ogni valutatore
        foreach ($valutatoriIds as $valutatoreId) {
            $totValutatoreIdClass::create([
                'valutatore_id' => $valutatoreId,
                'anno' => $year,
            ]);
        }

        // Aggiorna i totali per ogni campo
        foreach ($this->fields as $field) {
            $totals = $class::where('anno', $year)
                ->where('type', $type)
                ->where('ha_diritto', '>', 0)
                ->whereNotNull('valutatore_id')
                ->select('valutatore_id')
                ->selectRaw("SUM({$field}) as total")
                ->groupBy('valutatore_id')
                ->get();

            foreach ($totals as $total) {
                if (is_null($total->valutatore_id)) {
                    echo 'Valutatore ID null trovato durante aggiornamento totali';
                    continue;
                }

                $totValutatoreIdClass::where('valutatore_id', $total->valutatore_id)
                    ->where('anno', $year)
                    ->update([
                        "tot_{$field}" => $total->total ?? 0,
                        "tot_{$field}_min_punteggio" => $total->total ?? 0,
                    ]);
            }

            echo "Aggiornati totali per campo {$field}, anno: {$year}\n";
        }

        // Calcola i delta
        $updated = $totValutatoreIdClass::where('anno', $year)
            ->update([
                'delta' => DB::raw('tot_resti / NULLIF(tot_quota_effettiva, 0)'),
                'delta_min_punteggio' => DB::raw('tot_resti_min_punteggio / NULLIF(tot_quota_effettiva_min_punteggio, 0)'),
            ]);

        $totValutatoreIdClass::where('anno', $year)
            ->whereNull('delta')
            ->update(['delta' => 0]);

        $totValutatoreIdClass::where('anno', $year)
            ->whereNull('delta_min_punteggio')
            ->update(['delta_min_punteggio' => 0]);

        echo "Calcolati coefficienti delta per {$updated} valutatori, anno: {$year}\n";
    }
}
