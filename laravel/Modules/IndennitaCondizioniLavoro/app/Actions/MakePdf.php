<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Actions;

use Spipu\Html2Pdf\Html2Pdf;
use InvalidArgumentException;
use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Modules\IndennitaCondizioniLavoro\Models\StabiDirigente;
use Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoro;

class MakePdf
{
    use QueueableAction;

    /**
     * @param  array<string, mixed>  $data
     */
    public function execute(array $data): StreamedResponse
    {
        $filters = $data['anno/valutatore'] ?? $data;
        

        $rows = CondizioniLavoro::query()
            ->where($filters)
            ->whereHas('indennitaTipoDettaglio')
            ->get();

        $valutatore = StabiDirigente::query()
            //->where('valutatore_id', $valutatoreId)
            ->whereRaw('id = valutatore_id')
            //->where('anno', $anno)
            ->where($filters)
            ->first();

        $viewParams = [
            'rows' => $rows,
            'firma' => $valutatore?->nome_diri,
        ];

        $html = view('indennitacondizionilavoro::actions.make-pdf', $viewParams)->render();
        $filename = sprintf('condizioni_lavoro_%s.pdf',implode('_',$filters));

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
