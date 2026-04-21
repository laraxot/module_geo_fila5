---
type: concept
module: Geo
sources:
  - ../../stories/1-1-map-picker-field.md
  - ../../../../../../docs/quality-tools-setup.md
confidence: high
updated: 2026-04-16
---

# Static Geo Map Widget Pattern

## Intent

Pattern per widget Filament GEO che devono mostrare una mappa Leaflet performante con dataset statico locale, stato client-side persistente e zero round-trip server durante l'interazione ordinaria.

## Struttura

- `Filament Widget` PHP minimale: espone config, dataset e serializzazione JSON
- `Support object` dedicato: parsing GeoJSON, normalizzazione, categorie, statistiche
- `Lit Web Component`: isolamento UI con Shadow DOM reale
- `Leaflet layer manager`: gestione base layers, cluster, points, heatmap, zones
- `GeoJSON statico`: file locale nel modulo, caricato una sola volta lato client

## Regole

- Tutto resta dentro `Modules/Geo`
- Nessuna dipendenza CDN
- Dipendenze reali e verificabili: `leaflet`, `leaflet.markercluster`, `leaflet.heat`, `lit`
- Dataset max ~3000 punti per mantenere il pattern single-load di `farmshops.eu`
- Niente fetch incrementali per popup o dettaglio se il dataset è già sufficiente
- LOD obbligatorio: `cluster` → `aggregate` → `detail`

## Motivazione

Questo pattern replica l'idea chiave di `farmshops.eu`: performance stabili con dataset statico, clustering client-side e UX immediata. La differenza nel modulo Geo è l'incapsulamento rigoroso in Filament v5 + Lit + Vite locale.

## Implementazione corrente

- Widget: `Modules/Geo/app/Filament/Widgets/GeoMapWidget.php`
- Support: `Modules/Geo/app/Support/GeoMapDataset.php`
- View: `Modules/Geo/resources/views/filament/widgets/geo-map-widget.blade.php`
- Web Component: `Modules/Geo/resources/js/widgets/geo-map-widget.js`
- Dataset sample: `Modules/Geo/resources/data/geo-map-widget.geojson`

## Quality Gates

- `phpstan` sul perimetro del widget
- `phpmd` via `php tools/phpmd.phar ...`
- `phpinsights` via `.phar` workflow del progetto
- `pest` per dataset support object e widget config
