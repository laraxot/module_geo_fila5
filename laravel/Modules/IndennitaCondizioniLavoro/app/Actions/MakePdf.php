<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Actions;

use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;
use Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoro;
use Modules\IndennitaCondizioniLavoro\Models\StabiDirigente;
use Spatie\QueueableAction\QueueableAction;
use Spipu\Html2Pdf\Html2Pdf;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MakePdf
{
    use QueueableAction;

    /**
     * @param  array{'anno/valutatore': array<string, mixed>}  $data
     */
    public function execute(array $data): BinaryFileResponse
    {
        if (! isset($data['anno/valutatore']) || ! is_array($data['anno/valutatore'])) {
            throw new InvalidArgumentException('Parametro "anno/valutatore" mancante o non valido.');
        }

        $filtersInput = $data['anno/valutatore'];
        $anno = isset($filtersInput['anno']) ? (int) $filtersInput['anno'] : null;
        $valutatoreId = isset($filtersInput['valutatore_id']) ? (int) $filtersInput['valutatore_id'] : null;

        if ($anno === null || $valutatoreId === null) {
            throw new InvalidArgumentException('Filtri anno o valutatore non valorizzati.');
        }

        $filters = [
            'anno' => $anno,
            'valutatore_id' => $valutatoreId,
        ];

        $rows = CondizioniLavoro::query()
            ->where($filters)
            ->whereHas('indennitaTipoDettaglio')
            ->get();

        $valutatore = StabiDirigente::query()
            ->where('valutatore_id', $valutatoreId)
            ->whereRaw('id = valutatore_id')
            ->where('anno', $anno)
            ->first();

        $viewParams = [
            'rows' => $rows,
            'firma' => $valutatore?->nome_diri,
        ];

        $html = view('indennitacondizionilavoro::actions.make-pdf', $viewParams)->render();

        $html2pdf = new Html2Pdf('L', 'A4', 'it');
        $html2pdf->writeHTML($html);

        $filename = sprintf('condizioni_lavoro_%d_%d.pdf', $valutatoreId, $anno);
        $path = Storage::disk('cache')->path($filename);
        $html2pdf->output($path, 'F');

        return response()->download($path, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
