# Wiki Locale - Module Geo

## Schema di Riferimento

Vedi [[../../../../docs/.schema/WIKI_SCHEMA.md|Schema Wiki Globale]]

## Struttura Locale

```
wiki/
├── concepts/       # Pattern e metodologie
├── entities/       # Classi e componenti
├── summaries/      # Sommari documenti
├── comparisons/    # Confronti
└── overviews/     # Panoramiche
```

## Pagine Compilate

| Pagina | Tipo | Argomento |
|--------|------|-----------|
| [geo-module](./overviews/geo-module.md) | overview | Gerarchia geografica italiana, Address, Comune, geocoding, LeafletMarkerMapInput |
| [map-picker-locationpicker-architecture](./concepts/map-picker-locationpicker-architecture.md) | concept | **Architettura unified-state**: MapPicker/LocationPicker con Lit + Leaflet + Alpine/Livewire, contratto dati `{ latitude, longitude }`, flussi sincronizzazione, decisioni architetturali motivate |
| [map-picker-family-architecture](./concepts/map-picker-family-architecture.md) | concept | Architettura condivisa famiglia picker (`LatitudeLongitudeInput`, `MapPicker`, `PlacePicker`, `CoordinatePicker`) con contratto eventi unificato `coords-changed` |
| [leaflet-class-selector-governance](./concepts/leaflet-class-selector-governance.md) | concept | Regola permanente: mount Leaflet via classi locali del componente, mai tramite id globali |
| [leaflet-selector-audit](./concepts/leaflet-selector-audit.md) | concept | Audit selector mappe: scope, priorità operative e distinzione runtime vs legacy/demo |
| [latitudelongitudeinput-xotbasefield-rule](./concepts/latitudelongitudeinput-xotbasefield-rule.md) | concept | Regola strutturale e runtime: `LatitudeLongitudeInput` estende `XotBaseField` e non introduce toggle `showMap()` |
| [mappicker-xotbasefield-rule](./concepts/mappicker-xotbasefield-rule.md) | concept | Regola strutturale: `MapPicker` estende `XotBaseField` e non usa gerarchie sibling per riuso tecnico |
| [mappicker-runtime-ux](./concepts/mappicker-runtime-ux.md) | concept | Regola runtime: quando lat/lng iniziali sono null, `MapPicker` usa la posizione corrente e sincronizza stato |
| [latitudelongitudeinput-runtime-ux](./concepts/latitudelongitudeinput-runtime-ux.md) | concept | Regola runtime: autolocate automatico su coordinate null e controlli mappa sempre visibili |
| [map-picker-filament-field](./concepts/map-picker-filament-field.md) | concept | Pattern `MapPicker` / `LocationPicker` Filament con Lit + Leaflet + Alpine/Livewire su stato `{ latitude, longitude }` (v2 refactored) |
| [coordinate-picker-field](./concepts/coordinate-picker-field.md) | concept | Campo Filament `CoordinatePicker` con stato composito `coordinates`, bridge Alpine minimale e mapping esplicito verso colonne DB |
| [map-picker-runtime-asset-governance](./concepts/map-picker-runtime-asset-governance.md) | concept | Governance runtime asset marker (legacy + custom), anti-404 e checklist regressione browser |
| [geo-map-widget-farmshops-pattern](./concepts/geo-map-widget-farmshops-pattern.md) | concept | Dataset statico GeoJSON, Lit + Leaflet, cluster, layer manager, LOD |
| [inventage-leaflet-map-reference](./concepts/inventage-leaflet-map-reference.md) | concept | Analisi repo [@inventage/leaflet-map](https://github.com/inventage/leaflet-map): LeafletMap.ts, eventi, lifecycle, confronto con `map-picker-lit` |

## Raw Sources

Vedi [[../raw/index|Lista Sorgenti Grezzi]]

## Index Globale

Vedi [[../../../../docs/wiki/index|Index Globale Wiki]]

---

*Ultimo aggiornamento: 2026-04-20 (mappicker runtime ux)*
