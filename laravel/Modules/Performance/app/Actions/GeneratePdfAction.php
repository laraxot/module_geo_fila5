<?php

declare(strict_types=1);

namespace Modules\Performance\Actions;

use Barryvdh\DomPDF\Facade\Pdf as DomPDF;
use Illuminate\Support\Facades\View;
use Spatie\QueueableAction\QueueableAction;

class GeneratePdfAction
{
    use QueueableAction;

    /**
     * Genera un PDF per il modello specificato.
     *
     * @param  object  $model  Il modello per cui generare il PDF
     * @param  array<string, mixed>  $options  Opzioni per la generazione del PDF
     * @return string Contenuto del PDF generato
     */
    public function execute(object $model, array $options): string
    {
        $view = View::make('performance::admin.pdf.scheda', [
            'row' => $model,
            'options' => $options,
        ]);

        $pdf = DomPDF::loadHTML($view->render())
            ->setPaper('a4', (string) ($options['pdforientation'] ?? 'portrait'));

        return $pdf->output();
    }
}
