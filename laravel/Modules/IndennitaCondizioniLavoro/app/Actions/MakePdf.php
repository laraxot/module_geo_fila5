<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Actions;

use Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoro;
use Modules\IndennitaCondizioniLavoro\Models\StabiDirigente;
use Spatie\QueueableAction\QueueableAction;
use Spipu\Html2Pdf\Html2Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MakePdf
{
    use QueueableAction;

    /**
     * @param array<string, mixed> $data
     */
    public function execute(array $data): StreamedResponse
    {
        $filters = $data['anno/valutatore'] ?? $data;

        $rows = CondizioniLavoro::query()
            ->where($filters)
            ->whereHas('indennitaTipoDettaglio')
            ->get();

        $valutatore = StabiDirigente::query()
            // ->where('valutatore_id', $valutatoreId)
            ->whereRaw('id = valutatore_id')
            // ->where('anno', $anno)
            ->where($filters)
            ->first();

        $viewParams = [
            'rows' => $rows,
            'firma' => $valutatore?->nome_diri,
        ];

        $html = view('indennitacondizionilavoro::actions.make-pdf', $viewParams)->render();
        $filename = sprintf('condizioni_lavoro_%s.pdf', implode('_', $filters));

        return response()->streamDownload(
            function () use ($html): void {
                $html2pdf = new Html2Pdf('L', 'A4', 'it');
                $html2pdf->writeHTML($html);
                echo $html2pdf->output('', 'S');
            },
            $filename,
            ['Content-Type' => 'application/pdf'],
        );
    }
}
