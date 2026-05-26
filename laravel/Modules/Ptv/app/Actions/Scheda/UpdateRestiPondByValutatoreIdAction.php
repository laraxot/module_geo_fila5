<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Scheda;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\QueueableAction\QueueableAction;

/**
 * Ridistribuisce i fondi residui (resti) in base al valutatore_id.
 *
 * Nota: Questa action dipende da modelli specifici di Performance.
 */
class UpdateRestiPondByValutatoreIdAction
{
    use QueueableAction;

    /**
     * @param  class-string<Model>  $class
     */
    public function execute(string $class, string $year, string $type): void
    {
       $totValutatoreIdClass=$class.'TotValutatoreId';

        // Reset dei resti ponderati
        $count = $class::where('anno', $year)
            ->where('type', $type)
            ->update(['resti_pond' => 0]);
        echo "Resettati resti_pond per {$count} record, anno: {$year}, tipo: {$type}\n";

        // Recupera tutti i valutatori con i relativi delta
        $valutatori = $totValutatoreIdClass::where('anno', $year)->get();
        $totalUpdated = 0;

        // Per ogni valutatore, aggiorna i resti_pond dei dipendenti associati
        foreach ($valutatori as $valutatore) {
            if (is_null($valutatore->valutatore_id)) {
                echo 'Valutatore senza ID trovato durante aggiornamento resti_pond';
                continue;
            }

            if (is_null($valutatore->delta_min_punteggio)) {
                echo "Valutatore ID {$valutatore->valutatore_id} ha delta_min_punteggio NULL";
                continue;
            }

            $delta = (float) $valutatore->delta_min_punteggio + 0.00114;

            $updated = $class::where('anno', $year)
                ->where('type', $type)
                ->where('ha_diritto', '>', 0)
                ->where('valutatore_id', $valutatore->valutatore_id)
                ->update([
                    'resti_pond' => DB::raw("quota_effettiva * {$delta}"),
                ]);

            $totalUpdated += $updated;
            echo "<br/>Aggiornati resti_pond per {$updated} dipendenti del valutatore {$valutatore->valutatore_id}, delta: {$delta}\n";
        }

        echo "Aggiornati resti_pond per un totale di {$totalUpdated} dipendenti, anno: {$year}, tipo: {$type}\n";

        // Verifica della somma totale dei resti
        $totResti = (float) $class::where('anno', $year)
            ->where('type', $type)
            ->where('ha_diritto', '>', 0)
            ->sum('resti');
        $totRestiPond = (float) $class::where('anno', $year)
            ->where('type', $type)
            ->where('ha_diritto', '>', 0)
            ->sum('resti_pond');
        $difference = abs($totResti - $totRestiPond);

        echo "<table border='1' cellpadding='4' cellspacing='0' style='border-collapse:collapse; margin:8px 0;'>";
        echo "<tr style='background:#eee;font-weight:bold;'>"
            .'<th>Anno</th>'
            .'<th>Tipo</th>'
            .'<th>Tot Resti</th>'
            .'<th>Tot Resti Pond</th>'
            .'<th>Differenza</th>'
            .'</tr>';
        echo '<tr>'
            .'<td>'.htmlspecialchars($year).'</td>'
            .'<td>'.htmlspecialchars($type).'</td>'
            ."<td style='text-align:right;'>".number_format($totResti, 4, ',', '.').'</td>'
            ."<td style='text-align:right;'>".number_format($totRestiPond, 4, ',', '.').'</td>'
            ."<td style='text-align:right;'>".number_format($difference, 4, ',', '.').'</td>'
            .'</tr>';
        echo "</table>\n";
    }
}
