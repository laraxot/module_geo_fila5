<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Pdf;

use function Safe\base64_decode;

use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MakePdfSpatieTestAction
{
    use QueueableAction;

    /**
     * Build a minimal Spatie PDF download response from a generic test view.
     *
     * @param array<string, mixed> $data
     */
    public function execute(
        array $data = [],
        string $filename = 'spatie-pdf-test.pdf',
        string $view = 'xot::pdf.spatie-test',
    ): StreamedResponse {
        $pdf = Pdf::view($view, [
            'title' => 'Spatie PDF Test',
            'generated_at' => now(),
            'payload' => $data,
        ])
            ->format(Format::A4)
            ->name($filename)
            ->download()
            ->withBrowsershot(function (Browsershot $browsershot): void {
                $browsershot->showBackground();

                $nodeBinary = config('laravel-pdf.browsershot.node_binary');
                if (is_string($nodeBinary) && '' !== $nodeBinary) {
                    $browsershot->setNodeBinary($nodeBinary);
                }

                $npmBinary = config('laravel-pdf.browsershot.npm_binary');
                if (is_string($npmBinary) && '' !== $npmBinary) {
                    $browsershot->setNpmBinary($npmBinary);
                }

                $chromePath = config('laravel-pdf.browsershot.chrome_path');
                if (is_string($chromePath) && '' !== $chromePath) {
                    $browsershot->setChromePath($chromePath);
                }
            });

        return new StreamedResponse(
            static function () use ($pdf): void {
                echo base64_decode($pdf->base64());
            },
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            ],
        );
    }
}
