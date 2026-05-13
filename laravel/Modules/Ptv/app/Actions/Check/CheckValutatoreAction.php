<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Check;

use Spatie\QueueableAction\QueueableAction;

/**
 * Action per verificare quali righe Organizzativa non hanno valutatore_id valorizzato.
 */
class CheckValutatoreAction
{
    use QueueableAction;

    /**
     * Esegue il check e restituisce le righe senza valutatore_id.
     *
     * @param string $year Anno di riferimento
     * @param string $type Tipo di scheda (es. 'dip')
     *
     * @return array<int, array{id: int, matr: int|null, cognome: string|null, nome: string|null, stabi: int|null, repar: int|null}> Lista righe senza valutatore
     */
    public function execute(string $class, string $year, string $type): array
    {
        $rows = $class::query()
            ->where([
                'anno' => $year,
                'type' => $type,
            ])
            ->whereNull('valutatore_id')
            ->get(['id', 'matr', 'cognome', 'nome', 'stabi', 'repar', 'ha_diritto','valutatore_id']);

        $result = [];
        foreach ($rows as $row) {
            $result[] = [
                'id' => $row->id,
                'ha_diritto' => $row->ha_diritto,
                'matr' => $row->matr,
                'cognome' => $row->cognome,
                'nome' => $row->nome,
                'stabi' => $row->stabi,
                'repar' => $row->repar,
                'valutatore_id' => $row->valutatore_id,
            ];
        }
        echo '<h1>CheckValutatoreAction</h1><pre>';
        print_r($result);
        echo '</pre>';
        return $result;
    }
}
