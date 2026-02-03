# Performance Module

## 📖 Scopo

Il modulo Performance gestisce il sistema di valutazione delle performance per il personale dell'organizzazione.

## 🎯 Funzionalità Principali

- Valutazione performance individuali
- Schede di valutazione organizzativa
- Report e statistiche performance
- Integration con modulo User per valutatori

## 🚀 Quick Start

### Modelli Principali

- `PerformanceIndividuale` - Valutazioni individuali
- `PerformanceOrganizzativa` - Valutazioni organizzative
- `Valutatore` - Gestione valutatori

### Resources Filament

- `PerformanceIndividualeResource` - CRUD valutazioni individuali
- `PerformanceOrganizzativaResource` - CRUD valutazioni organizzative

## 📂 Struttura

```
Modules/Performance/
├── app/
│   ├── Filament/Resources/  # Resources Filament
│   ├── Models/              # Modelli Eloquent
│   ├── Actions/             # Business logic
│   └── Datas/               # DTO (Data Transfer Objects)
├── database/migrations/     # Migrazioni database
├── lang/                    # Traduzioni (it, en)
└── docs/                    # Questa documentazione
```

## 🔗 Moduli Correlati

- [Xot](../Xot/docs/README.md) - Framework core e base classes
- [User](../User/docs/README.md) - Gestione utenti e autenticazione

## 📄 Html2Pdf Integration

### Scopo
Il modulo Performance utilizza Html2Pdf per generare PDF di report valutativi, schede individuali e organizzative.

### Libreria Utilizzata
- **spipu/html2pdf** v5.3.3 - Libreria principale per conversione HTML→PDF
- Basata su TCPDF con supporto Unicode completo
- Compatibile PHP 7.2-8.4
- **Aggiornato Gennaio 2026** con nuove funzionalità di sicurezza

### Nuove Funzionalità v5.3.x

#### 🔒 Security Service Avanzato
```php
use Spipu\Html2Pdf\Html2Pdf;

$html2pdf = new Html2Pdf('P', 'A4', 'it');

// Configura host sicuri per risorse esterne
$html2pdf->getSecurityService()->addAllowedHost('cdn.performance.trusted.com');
```

#### 📄 Classe html2pdf-same-page
```blade
{{-- Previene divisione tabelle valutazioni --}}
<div class="html2pdf-same-page">
    <table>
        <tr><td>Valutazioni che non devono dividersi</td></tr>
        <!-- Questa sezione rimane sempre insieme -->
    </table>
</div>
```

#### 📝 Supporto Readonly Attributes
```blade
{{-- Campi readonly ora supportati --}}
<input type="text" name="anno" value="{{ $performance->anno }}" readonly />
```

#### 🎨 CSS con Variabili di Pagina
```blade
<style>
    {{-- Styling dinamico per pagina corrente --}}
    .performance-header-[[page_cu]] {
        border-bottom: 2px solid #0066CC;
    }
</style>
```

### Configurazione Standard

```php
use Spipu\Html2Pdf\Html2Pdf;

$html2pdf = new Html2Pdf(
    orientation: 'P',              // Portrait
    format: 'A4',                 // Formato A4
    lang: 'it',                   // Italiano
    unicode: true,                // Supporto Unicode
    encoding: 'UTF-8',            // UTF-8
    margins: [15, 15, 15, 15]     // Margini 15mm
);
```

### Template PDF per Performance

#### Struttura Base Scheda Individuale

```blade
{{-- resources/views/performance::performance_individuale.show.pdf.blade.php --}}
<page backtop="20mm" backbottom="20mm" backleft="20mm" backright="20mm">
    <page_header>
        <table width="100%" style="border-bottom: 1px solid #000; margin-bottom: 10mm;">
            <tr>
                <td width="70%">
                    <h1 style="font-size: 16pt; margin: 0; color: #0066CC;">
                        Sistema Performance Individuale
                    </h1>
                    <p style="font-size: 10pt; margin: 5pt 0 0 0;">
                        Valutazione prestazioni anno {{ $row->anno }}
                    </p>
                </td>
                <td width="30%" align="right">
                    <p style="font-size: 10pt; margin: 0;">
                        Data generazione: [[date_d/m/Y]]<br>
                        Ora: [[time_H:i]]
                    </p>
                </td>
            </tr>
        </table>
    </page_header>

    <h1 style="font-size: 18pt; text-align: center; margin: 15mm 0; color: #333;">
        Scheda Valutazione Individuale
    </h1>

    {{-- Dati valutatore --}}
    <div style="margin: 10mm 0;">
        <h2 style="font-size: 14pt; color: #0066CC; border-bottom: 1px solid #CCC; padding-bottom: 3pt;">
            Valutatore
        </h2>
        <table style="width: 100%; border-collapse: collapse; margin-top: 5mm;">
            <tr>
                <td style="border: 1px solid #CCC; padding: 5pt; background-color: #F9F9F9; font-weight: bold; width: 25%;">
                    Nome:
                </td>
                <td style="border: 1px solid #CCC; padding: 5pt; width: 75%;">
                    {{ $row->valutatore?->nome ?? 'N/A' }}
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #CCC; padding: 5pt; background-color: #F9F9F9; font-weight: bold;">
                    Cognome:
                </td>
                <td style="border: 1px solid #CCC; padding: 5pt;">
                    {{ $row->valutatore?->cognome ?? 'N/A' }}
                </td>
            </tr>
        </table>
    </div>

    {{-- Valutazioni --}}
    <div style="margin: 10mm 0;">
        <h2 style="font-size: 14pt; color: #0066CC; border-bottom: 1px solid #CCC; padding-bottom: 3pt;">
            Valutazioni
        </h2>
        <table style="width: 100%; border-collapse: collapse; margin-top: 5mm;">
            <thead>
                <tr style="background-color: #E0E0E0;">
                    <th style="border: 1px solid #CCC; padding: 8pt; text-align: left; font-weight: bold;">
                        Criterio
                    </th>
                    <th style="border: 1px solid #CCC; padding: 8pt; text-align: center; font-weight: bold; width: 15%;">
                        Punteggio
                    </th>
                    <th style="border: 1px solid #CCC; padding: 8pt; text-align: left; font-weight: bold;">
                        Note
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($row->valutazioni ?? [] as $valutazione)
                <tr>
                    <td style="border: 1px solid #CCC; padding: 5pt;">
                        {{ $valutazione->criterio }}
                    </td>
                    <td style="border: 1px solid #CCC; padding: 5pt; text-align: center;">
                        {{ $valutazione->punteggio }}
                    </td>
                    <td style="border: 1px solid #CCC; padding: 5pt;">
                        {{ $valutazione->note ?? '-' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <page_footer>
        <table width="100%" style="border-top: 1px solid #000; margin-top: 30pt;">
            <tr>
                <td width="60%">
                    <p style="font-size: 8pt; margin: 0; color: #666;">
                        Documento riservato - Sistema Performance Individuale
                    </p>
                </td>
                <td width="40%" align="right">
                    <p style="font-size: 8pt; margin: 0; color: #666;">
                        Pagina [[page_cu]] di [[page_nb]]
                    </p>
                </td>
            </tr>
        </table>
    </page_footer>
</page>
```

#### CSS Inline Richiesto

**IMPORTANTE:** Html2Pdf NON supporta tag `<style>`. Tutto deve essere CSS inline:

```blade
{{-- ✅ CORRETTO - Tutto inline --}}
<div style="font-family: Arial; font-size: 12pt; color: #333;">
    <h1 style="font-size: 18pt; text-align: center;">Titolo</h1>
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="border: 1px solid #000; padding: 5pt;">Cella</td>
        </tr>
    </table>
</div>

{{-- ❌ ERRATO - Tag style causano HtmlParsingException --}}
<style>
    .title { font-size: 18pt; }
    .table { border-collapse: collapse; }
</style>
```

### Errori Comuni e Soluzioni

#### 1. HtmlParsingException: Tag Style

**Sintomi:**
```
Spipu\Html2Pdf\Exception\HtmlParsingException
Too many tag closures found for [style]
```

**Causa:** Tag `<style>` presenti nel template

**Soluzione:** Rimuovi tutti i tag `<style>` e usa solo CSS inline

#### 2. Tabelle Non Chiuse

**Sintomi:**
```
Tags are closed in a wrong order for [table]
```

**Causa:** Tag tabella non bilanciati

**Soluzione:**
```blade
{{-- ✅ CORRETTO --}}
<table>
    <thead>
        <tr><th>Header</th></tr>
    </thead>
    <tbody>
        <tr><td>Data</td></tr>
    </tbody>
</table>
```

#### 3. Immagini Rotte

**Sintomi:** Quadrati grigi invece delle immagini

**Soluzione:**
```blade
{{-- ✅ SICURO - Base64 --}}
<img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logo.png'))) }}" />

{{-- ❌ RISCHIOSO - Path relativo --}}
<img src="../images/logo.png" />
```

### Metodi Utili Html2Pdf

```php
// Debug dettagliato
$html2pdf->setModeDebug();

// Disabilita controllo immagini esistenti
$html2pdf->setTestIsImage(false);

// Permette contenuto tabelle su più pagine
$html2pdf->setTestTdInOnePage(false);

// Imposta immagine fallback
$html2pdf->setFallbackImage('/path/to/fallback.png');
```

### Integrazione con Actions

```php
<?php

namespace Modules\Performance\Actions\Pdf;

use Modules\Xot\Actions\Pdf\GetPdfContentByRecordAction;
use Modules\Performance\Models\PerformanceIndividuale;

class GeneratePerformancePdfAction
{
    public function execute(PerformanceIndividuale $performance, array $options = []): string
    {
        // Usa l'action standard di Laraxot
        return app(GetPdfContentByRecordAction::class)->execute($performance);
    }
}
```

### Testing PDF Generation

```php
<?php

namespace Tests\Feature\Performance;

use Tests\TestCase;
use Modules\Performance\Models\PerformanceIndividuale;
use Modules\Xot\Actions\Pdf\GetPdfContentByRecordAction;

class PdfGenerationTest extends TestCase
{
    /** @test */
    public function it_generates_valid_pdf_for_performance_individuale()
    {
        $performance = PerformanceIndividuale::factory()->create();

        $pdfAction = app(GetPdfContentByRecordAction::class);
        $pdfContent = $pdfAction->execute($performance);

        // Validazione PDF
        $this->assertStringStartsWith('%PDF', $pdfContent);
        $this->assertGreaterThan(1000, strlen($pdfContent));

        // Verifica contenuto specifico
        $this->assertStringContains((string)$performance->anno, $pdfContent);
    }
}
```

### Best Practices

1. **CSS Inline Only** - Mai usare tag `<style>`
2. **Tag Bilanciati** - Sempre chiudere correttamente tutti i tag
3. **Immagini Base64** - Convertire immagini in base64 per sicurezza
4. **Tabelle per Layout** - Usare tabelle invece di float/position
5. **Testing Regolare** - Testare generazione PDF dopo modifiche template
6. **Validazione HTML** - Verificare che l'HTML sia ben formato

### Troubleshooting

#### Script Validazione Template

```bash
#!/bin/bash
# validate_pdf_templates.sh

echo "🔍 Validazione template PDF Performance..."

find resources/views/performance -name "*pdf*.blade.php" | while read file; do
    echo "📄 Controllo: $file"

    # Verifica tag style vietati
    if grep -q "<style" "$file"; then
        echo "❌ ERRORE: Tag <style> trovato in $file - Usa solo CSS inline!"
    fi

    # Verifica bilanciamento tag
    # (Controlli aggiuntivi possono essere aggiunti)
done
```

#### Debug Mode

```php
// In controller per debug
public function debugPdf($id)
{
    $performance = PerformanceIndividuale::findOrFail($id);

    try {
        $pdfContent = app(GetPdfContentByRecordAction::class)->execute($performance);
        return response($pdfContent)->header('Content-Type', 'application/pdf');
    } catch (\Exception $e) {
        // Mostra HTML invece di PDF per debug
        $viewName = 'performance::performance_individuale.show.pdf';
        $html = view($viewName, ['row' => $performance])->render();
        return response($html)->header('Content-Type', 'text/html');
    }
}
```

### Risorse Utili

- [Documentazione Html2Pdf Ufficiale](https://github.com/spipu/html2pdf)
- [Guida Xot PDF Actions](../../Xot/docs/actions/pdf-actions-overview.md)
- [Esempi TCPDF](https://tcpdf.org/examples/)
- [Performance Individuale Resource](../../app/Filament/Resources/PerformanceIndividualeResource.php)

---

## 📊 **Charts & Visualizzazioni Avanzate**

### Filament Charts per Performance

Il modulo Performance include chart interattivi con esportazione:

#### Chart Valutazioni Individuali
```php
<?php

namespace Modules\Performance\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Performance\Services\PerformanceAnalyticsService;

class PerformanceChart extends ChartWidget
{
    protected static ?string $heading = 'Andamento Valutazioni';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $analytics = app(PerformanceAnalyticsService::class);

        return [
            'datasets' => [
                [
                    'label' => 'Media Valutazioni',
                    'data' => $analytics->getMonthlyAverages(),
                    'borderColor' => '#3B82F6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'tension' => 0.4,
                    'fill' => true,
                ],
                [
                    'label' => 'Target',
                    'data' => array_fill(0, 12, 85), // Target 85%
                    'borderColor' => '#10B981',
                    'borderDash' => [5, 5],
                    'pointRadius' => 0,
                ],
            ],
            'labels' => $analytics->getMonthLabels(),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'annotation' => [
                    'annotations' => [
                        'target_zone' => [
                            'type' => 'box',
                            'yMin' => 80,
                            'yMax' => 90,
                            'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                            'borderColor' => '#10B981',
                            'borderWidth' => 1,
                            'label' => [
                                'content' => 'Zona Target',
                                'enabled' => true,
                            ],
                        ],
                    ],
                ],
                'datalabels' => [
                    'display' => false, // Troppo clutter per line chart
                ],
            ],
            'scales' => [
                'y' => [
                    'min' => 0,
                    'max' => 100,
                    'ticks' => [
                        'callback' => "function(value) { return value + '%'; }"
                    ]
                ]
            ],
        ];
    }
}
```

#### Chart Organizzativo con Zoom
```php
<?php

namespace Modules\Performance\Filament\Widgets;

class OrganizationalChart extends ChartWidget
{
    protected static ?string $heading = 'Performance Organizzativa';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'zoom' => [
                    'zoom' => [
                        'wheel' => ['enabled' => true],
                        'mode' => 'x', // Solo zoom orizzontale
                    ],
                    'pan' => [
                        'enabled' => true,
                        'mode' => 'x',
                    ],
                ],
                'datalabels' => [
                    'display' => true,
                    'color' => 'white',
                    'font' => ['weight' => 'bold'],
                    'formatter' => "function(value) { return value + '%'; }",
                    'anchor' => 'end',
                    'align' => 'top',
                ],
            ],
        ];
    }
}
```

### Servizio Esportazione Chart

```php
<?php

namespace Modules\Performance\Services;

use Modules\Analytics\Services\AdvancedChartExportService;

class PerformanceChartExportService
{
    public function __construct(
        private AdvancedChartExportService $exportService
    ) {}

    /**
     * Esporta chart performance per report
     */
    public function exportPerformanceReport(string $chartId, int $year): array
    {
        return $this->exportService->saveChartForReport($chartId, "performance-{$year}");
    }

    /**
     * Genera report annuale con chart esportati
     */
    public function generateAnnualReport(int $year): string
    {
        // Esporta tutti i chart rilevanti
        $exports = [
            'individual' => $this->exportPerformanceReport('individual-chart', $year),
            'organizational' => $this->exportPerformanceReport('organizational-chart', $year),
            'trends' => $this->exportPerformanceReport('trends-chart', $year),
        ];

        // Genera PDF report con chart inclusi
        return $this->generatePdfReport($exports, $year);
    }

    private function generatePdfReport(array $exports, int $year): string
    {
        $html = view('performance::reports.annual', [
            'year' => $year,
            'chart_exports' => $exports,
        ])->render();

        return app(\Modules\Xot\Actions\Pdf\ContentPdfAction::class)
            ->execute(html: $html, filename: "report-performance-{$year}.pdf");
    }
}
```

---

## 🧪 Qualità & PHPStan
- Le refactor dedicate all’eliminazione dei warning di static analysis sono tracciate in [phpstan-refactor.md](./phpstan-refactor.md).

## 🛠️ Troubleshooting

Per problemi comuni e soluzioni, consultare la documentazione del modulo Xot:
- [Xot Troubleshooting](../Xot/docs/troubleshooting/readme.md)

## 📝 Note

Module attualmente in sviluppo. Documentazione verrà ampliata in base alle necessità.

### Aggiornamento 19/11/2025
- Allineate le traduzioni di navigazione per la risorsa `OrganizzativaCatCoeff` con label e gruppo localizzati (`Performance`) per aderire alla regola “no `.navigation`”.

---

**Ultimo aggiornamento**: Gennaio 2026  
**Maintainer**: Sistema PTVX  
**Status**: Active Development

## 🚀 Release su GitHub
Le release sono basate su tag Git e possono includere release notes generate automaticamente.
Workflow locale: `.github/workflows/release.yml`.
