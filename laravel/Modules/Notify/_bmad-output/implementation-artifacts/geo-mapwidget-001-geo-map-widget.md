---
story_id: geo-mapwidget-001
story_key: geo-mapwidget-001
story_title: GeoMapWidget — Widget Mappa GIS Leaflet/Lit per Filament v5
epic: GEO
status: ready-for-dev
created: 2026-04-16
author: bmad-create-story
---

# Story: GeoMapWidget — Widget Mappa GIS Leaflet/Lit per Filament v5

## User Story

Come amministratore Filament del modulo `Geo`,
voglio un widget `GeoMapWidget` basato su Leaflet e su un Web Component Lit,
così da visualizzare e navigare un dataset GeoJSON statico lato client con clustering,
layer multipli e popup ricchi senza dipendere da chiamate server successive al primo caricamento.

## Contesto

Il progetto di riferimento è `CodeforKarlsruhe/farmshops.eu`. Il file `direktvermarkter.js` **è già presente nel modulo Geo** in `laravel/Modules/Geo/resources/js/direktvermarkter.js` — analizzalo prima di scrivere qualsiasi codice.

Il modulo Geo ha già:
- `laravel/Modules/Geo/resources/js/components/geo-latlng-input.js` — componente Lit+Leaflet completo: usa come modello principale
- `laravel/Modules/Geo/resources/js/components/my-map-lit.js` — componente Lit+Leaflet semplice
- `laravel/Modules/Geo/app/Filament/Widgets/OSMMapWidget.php` — pattern widget PHP esistente
- `laravel/Modules/Geo/app/Filament/Widgets/LocationMapWidget.php` — pattern widget PHP con markers
- `laravel/Modules/Geo/app/Filament/Widgets/LatLngWidget.php` — pattern widget PHP con `protected string $view`

**NON reinventare**: eredita i pattern già funzionanti sopra descritti.

---

## Acceptance Criteria

### AC1 — Widget Filament v5 nel modulo Geo

- Esiste `GeoMapWidget` in `Modules\Geo\Filament\Widgets`
- Il widget usa solo view, asset e classi del modulo `Geo`
- Nessuna dipendenza verso moduli diversi da `Geo` (salvo framework/primitive Laravel/Filament)

### AC2 — Web Component Lit isolato

- UI mappa incapsulata in Web Component Lit `geo-map-widget`
- Il Web Component gestisce internamente: Leaflet, layer, popup, selezione
- Il widget PHP/Blade passa solo configurazione JSON e dataset al componente

### AC3 — Dataset GeoJSON statico

- Il widget carica un unico payload GeoJSON (max ~3000 feature puntuali) una sola volta
- Nessun refetch server per zoom, filtri, layer, selezione
- Il dataset viene passato come attributo HTML (JSON serializzato) o via `<script type="application/json">`

### AC4 — Parità funzionale farmshops verificata

- Replicare il pattern core di `direktvermarkter.js`:
  - Mappa Leaflet, dataset GeoJSON, marker cliccabili, clustering, layer base OSM, popup
- **Non copiare letteralmente**: elimina jQuery, script globali legacy, lazy-load dettagli per marker, CDN

### AC5 — Clustering e LOD (Level of Detail)

- `leaflet.markercluster` obbligatorio
- Logica LOD:
  - zoom < 12 → cluster puro (solo contatore)
  - zoom 12–14 → cluster con icone di categoria (come `markerTypen()` in `direktvermarkter.js`)
  - zoom ≥ 15 → marker individuali
- Raggio cluster dinamico: 80 a zoom < 12, 45 a zoom ≥ 12 (pattern farmshops verificato)

### AC6 — Layer manager interno

- Layer disponibili e combinabili:
  - `points` — marker raw
  - `clusters` — MarkerClusterGroup
  - `heatmap` — solo se plugin npm verificato e disponibile
  - `zones` — poligoni GeoJSON
- Toggle layer tramite UI interna al Web Component (pulsanti o checkboxes)
- Stato layer persistente durante zoom/pan/selezione

### AC7 — Interazione feature

- Marker cliccabili → popup con dati dalle proprietà GeoJSON (no AJAX)
- Selezione marker → aggiorna stato interno `selectedFeatureId`
- Filtro client-side per categoria (`feature.properties.p` o campo equivalente)
- Evento custom `geo-map-selection-change` quando cambia selezione (per integrazione Filament/Livewire)

### AC8 — Performance e manutenibilità

- Separazione netta tra: data layer, rendering Leaflet, layer manager, state management UI
- No re-render completi della mappa se cambia solo stato UI
- Iterazioni sul dataset ridotte al minimo (nessun doppio ciclo inutile)
- Memoizzazione risultati filtro (cache locale `_filteredData`)

### AC9 — Build frontend reale (NO CDN)

- Dipendenze via npm solo: `leaflet`, `lit`, `leaflet.markercluster`
- Eventuali plugin aggiuntivi (heatmap) verificati su npmjs.com prima dell'uso
- Asset integrati nella build Vite del progetto Laravel

### AC10 — Qualità e test

- PHPStan livello massimo (verificare con `phpstan.neon.dist` del modulo)
- PHPMD, PHP Insights passanti
- Test Pest presenti per: widget PHP, serializzazione config, costruzione dataset
- Limitazioni test Web Component documentate esplicitamente

---

## Struttura File Obbligatoria

```
laravel/Modules/Geo/
├── app/Filament/Widgets/
│   └── GeoMapWidget.php                    ← Nuovo widget PHP
├── resources/
│   ├── views/filament/widgets/
│   │   └── geo-map-widget.blade.php        ← View Blade
│   └── js/components/
│       └── geo-map-widget.js               ← Lit Web Component (NUOVO)
└── tests/Feature/Filament/
    └── GeoMapWidgetTest.php                ← Test Pest feature
```

**NON creare file fuori dal modulo Geo.**
**NON modificare file esistenti di altri widget** (OSMMapWidget, LocationMapWidget, LatLngWidget).

---

## Requisiti Tecnici Obbligatori

### PHP — GeoMapWidget.php

```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Contracts\View\View;

class GeoMapWidget extends Widget
{
    protected int|string|array $columnSpan = 'full';

    // Configurazione passabile dall'esterno
    public string $height = '500px';
    public float $centerLat = 45.4642;
    public float $centerLng = 9.1900;
    public int $zoom = 10;
    public string $geoJsonPath = ''; // path relativo pubblico al file GeoJSON

    public function render(): View
    {
        /** @var view-string $viewName */
        $viewName = 'geo::filament.widgets.geo-map-widget';
        return view($viewName, $this->getViewData());
    }

    /** @return array<string, mixed> */
    protected function getViewData(): array
    {
        return [
            'config' => $this->buildConfig(),
        ];
    }

    /** @return array<string, mixed> */
    protected function buildConfig(): array
    {
        return [
            'height' => $this->height,
            'center' => ['lat' => $this->centerLat, 'lng' => $this->centerLng],
            'zoom' => $this->zoom,
            'geoJsonPath' => $this->geoJsonPath,
        ];
    }
}
```

**Pattern critico**: usa `/** @var view-string $viewName */` prima di ogni `view()` call — PHPStan lo richiede.

### Blade — geo-map-widget.blade.php

```blade
<x-filament-widgets::widget class="fi-wi-geo-map-widget">
    <div class="p-4">
        <geo-map-widget
            config='@json($config)'
            style="display:block; width:100%; height: {{ $config['height'] }};"
        ></geo-map-widget>
    </div>
</x-filament-widgets::widget>
```

**Pattern critico**: Usa `@json()` per serializzare configurazione PHP → attributo HTML.
Il Web Component leggerà `this.getAttribute('config')` e farà `JSON.parse()`.

### JavaScript — geo-map-widget.js

**Modello obbligatorio**: replica la struttura di `geo-latlng-input.js` già presente nel modulo.

```js
import { LitElement, html, css } from 'lit';
import L from 'leaflet';
import 'leaflet.markercluster';
// Se heatmap verificata: import { HeatLayer } from '...';

export class GeoMapWidget extends LitElement {
    static properties = {
        config: { type: String }, // JSON string → parsato in connectedCallback
    };

    // CRITICO: Light DOM obbligatorio per Leaflet e Tailwind
    createRenderRoot() {
        return this;
    }

    // ...
}

if (!customElements.get('geo-map-widget')) {
    customElements.define('geo-map-widget', GeoMapWidget);
}
```

**Pattern critici da `geo-latlng-input.js`**:
1. `createRenderRoot() { return this; }` — sempre, per compatibilità Leaflet con DOM reale
2. Map init in `firstUpdated()` — non nel costruttore
3. `setTimeout(() => { this._map?.invalidateSize(); }, 100)` — sempre dopo init per resize
4. Guard `if (this._mapInitialized) return;` in `firstUpdated()`
5. Cleanup in `disconnectedCallback()`: `this._map?.remove(); this._map = null;`

### Layer Manager interno

Struttura interna obbligatoria nel Web Component:

```js
// Stato interno
this._map = null;
this._config = {};
this._geoJsonData = null;
this._layers = {
    points: null,      // L.geoJson raw
    clusters: null,    // L.markerClusterGroup
    heatmap: null,     // plugin heatmap (se disponibile)
    zones: null,       // L.geoJson con poligoni
};
this._activeLayers = new Set(['clusters']); // default
this._selectedFeatureId = null;
this._filteredData = null; // cache filtro
this._mapInitialized = false;
```

### LOD (Level of Detail) — Pattern farmshops migliorato

**Da `direktvermarkter.js` verificato**:
```js
// Raggio cluster dinamico (pattern originale farmshops verificato)
const getClusterRadius = (zoom) => zoom < 12 ? 80 : 45;

// Cluster icon con indicatori categoria (pattern markerTypen verificato)
iconCreateFunction(cluster) {
    const markers = cluster.getAllChildMarkers();
    // analizza markers[i].feature.properties.p per ogni tipo
    // restituisce L.divIcon con HTML categorico
}
```

LOD switch su evento `zoomend`:
```js
this._map.on('zoomend', () => this._updateLOD());

_updateLOD() {
    const zoom = this._map.getZoom();
    if (zoom >= 15) {
        // mostra points, nascondi clusters
    } else {
        // mostra clusters, nascondi points
    }
}
```

### GeoJSON — Struttura dati attesa

```js
// Feature minima supportata
{
  "type": "Feature",
  "geometry": { "type": "Point", "coordinates": [lng, lat] },
  "properties": {
    "id": "string",
    "p": "farm|vending_machine|marketplace|beekeeper|...",
    "name": "string",
    // campi popup aggiuntivi liberi
  }
}
```

**Per il layer `zones`**: supportare anche `Polygon` e `MultiPolygon`.

### Popup — Pattern farmshops senza AJAX

**Differenza chiave rispetto a `direktvermarkter.js`**: il popup originale carica dati via `$.getJSON()` on click. Il nuovo widget **NON deve fare AJAX**. I dati popup sono già nelle `feature.properties`.

```js
_buildPopupContent(feature) {
    const p = feature.properties;
    // costruire HTML da p.name, p.p, e altri campi disponibili
    return `<div class="geo-popup"><strong>${p.name ?? ''}</strong>...</div>`;
}
```

---

## Dipendenze npm — Verifica obbligatoria

| Package | npm | Note |
|---------|-----|------|
| `leaflet` | `leaflet@^1.9.4` | già in peerDependencies |
| `lit` | `lit@^3.3.2` | già in peerDependencies |
| `leaflet.markercluster` | `leaflet.markercluster@^1.5.3` | verificato su npm |
| heatmap plugin | **DA VERIFICARE** | `leaflet-heat` (da npm, non CDN) |

Per `leaflet.markercluster` il type import è:
```js
import 'leaflet.markercluster';
import 'leaflet.markercluster/dist/MarkerCluster.css';
import 'leaflet.markercluster/dist/MarkerCluster.Default.css';
```

**NON usare `leaflet.extra-markers`** se non già installato via npm — verificare con `npm list leaflet.extra-markers` prima di aggiungere.

---

## Test Pest — Pattern obbligatorio

### Struttura test

```
laravel/Modules/Geo/tests/Feature/Filament/GeoMapWidgetTest.php
```

```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Feature\Filament;

use Modules\Geo\Filament\Widgets\GeoMapWidget;
use Modules\Geo\Tests\TestCase;

uses(TestCase::class);

it('can instantiate GeoMapWidget', function () {
    $widget = new GeoMapWidget();
    expect($widget)->toBeInstanceOf(GeoMapWidget::class);
});

it('builds correct config array', function () {
    $widget = new GeoMapWidget();
    $widget->centerLat = 45.0;
    $widget->centerLng = 9.0;
    $widget->zoom = 12;
    $widget->height = '400px';

    // Accesso config tramite metodo protetto
    $reflection = new \ReflectionMethod($widget, 'buildConfig');
    $reflection->setAccessible(true);
    $config = $reflection->invoke($widget);

    expect($config)->toHaveKey('height', '400px')
        ->toHaveKey('zoom', 12)
        ->toHaveKey('center');

    expect($config['center'])->toMatchArray(['lat' => 45.0, 'lng' => 9.0]);
});

it('has full column span by default', function () {
    $widget = new GeoMapWidget();
    expect($widget->columnSpan)->toBe('full');
});
```

**Pattern critico**: vedere `laravel/Modules/Geo/tests/Feature/Filament/Forms/Components/MapPickerTest.php` per convenzioni.

---

## Guardrail: Errori da NON commettere

| Errore | Soluzione |
|--------|-----------|
| Import Leaflet via CDN | Solo `import L from 'leaflet'` |
| Shadow DOM in LitElement | `createRenderRoot() { return this; }` |
| Map init nel costruttore | Solo in `firstUpdated()` |
| Mancanza `invalidateSize()` | Sempre `setTimeout(() => map.invalidateSize(), 100)` |
| AJAX in popup (pattern vecchio farmshops) | Popup da `feature.properties` già caricati |
| `/** @var view-string */` mancante | PHPStan fallisce — aggiungilo sempre |
| `declare(strict_types=1)` mancante | Aggiungilo sempre ai file PHP |
| File PHP fuori da `Modules/Geo/` | Tutti i file nel modulo Geo |
| jQuery | Non è disponibile nel progetto (niente `$`) |
| Icone immagini hardcoded (`img/hof.png`) | Usare `L.divIcon` con HTML/CSS puro |

---

## Analisi file di riferimento esistenti

### `direktvermarkter.js` (già nel repo a `resources/js/direktvermarkter.js`)

Pattern verificati da usare (adattati):
- `L.markerClusterGroup({ iconCreateFunction, maxClusterRadius: getClusterRadius, ... })`
- `L.geoJson(data, { pointToLayer, onEachFeature })`
- Analisi tipo marker: `feature.properties.p === 'farm'|'beekeeper'|'marketplace'|'vending_machine'`
- `cluster.getAllChildMarkers()` per costruire icone aggregate

Pattern da NON copiare:
- `$.getJSON(...)` — no AJAX, no jQuery
- `L.Permalink.setup(map)` — opzionale, verificare npm prima di aggiungere
- `L.control.sidebar(...)` — non richiesto nel task
- Script globali non modulari

### `geo-latlng-input.js` (modello primario per Lit+Leaflet)

Tutta la struttura di inizializzazione, layer switching, eventi, e cleanup va replicata da questo file, **non reinventata**.

---

## Integrazione Filament v5

Per registrare il widget in un panel Filament v5:

```php
// In qualsiasi Filament PanelProvider del modulo o dell'app
->widgets([
    \Modules\Geo\Filament\Widgets\GeoMapWidget::class,
])
```

Il widget è autonomo: non richiede una risorsa collegata.

---

## Dev Notes — Build e Asset

Il modulo Geo usa Laravel Mix (`webpack.mix.js`) come build tool storico, ma il progetto principale usa **Vite**. I componenti Lit (`geo-latlng-input.js`, `my-map-lit.js`) sono importati nell'entry point del tema/app principale.

**Verificare come vengono importati** gli altri componenti Lit prima di decidere la strategia:
```bash
grep -r "geo-latlng-input\|my-map-lit" laravel/ --include="*.js" --include="*.ts" -l
```

Il nuovo `geo-map-widget.js` deve seguire lo stesso pattern di import degli esistenti.

---

## Rischi e Note Aperte

1. **Plugin heatmap**: Non è ancora selezionato. Usare `leaflet-heat` (via npm) solo dopo verifica. Se non disponibile, documentare e omettere il layer heatmap.
2. **leaflet.extra-markers**: Usato in `direktvermarkter.js` ma non verificato come installato. Usare `L.divIcon` con HTML/CSS come alternativa sicura.
3. **Build pipeline**: Verificare prima dell'implementazione come il build Vite dell'app principale importa i componenti JS del modulo Geo.
4. **PHPStan baseline**: Esiste `laravel/Modules/Geo/phpstan-baseline.neon` — i nuovi file non devono aggiungere voci alla baseline.
5. **leaflet.markercluster types**: Potrebbe essere necessario installare `@types/leaflet.markercluster` per TypeScript o gestire via `@ts-ignore` localmente.

---

## Definizione di "Completato"

Il lavoro è completato quando:
- [ ] Widget PHP, Blade e Lit creati nei percorsi esatti indicati
- [ ] Mappa Leaflet visibile in pagina Filament con dataset GeoJSON di test
- [ ] Clustering funzionante con LOD zoom-based
- [ ] Toggle layer via UI interna
- [ ] Popup cliccabili con dati da `feature.properties` (no AJAX)
- [ ] Filtro client-side per categoria
- [ ] Test Pest passanti (almeno 3 test per il widget)
- [ ] PHPStan, PHPMD, PHP Insights passanti sui nuovi file
- [ ] Nessuna voce nuova in `phpstan-baseline.neon`
- [ ] Nessun CDN nel codice prodotto
