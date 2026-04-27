# Geo Module LLM Wiki

Indice operativo del wiki Geo.

## Struttura canonica (sacra)

- `concepts/`
- `entities/`
- `sources/`
- `comparisons/`
- `decisions/`
- `troubleshooting/`
- `_archive/`
- `_templates/`

## Regole collegate

- [no-docs-archive-rule](./concepts/no-docs-archive-rule.md)
- [wiki-sacred-structure-rule](../../../../../docs/wiki/concepts/wiki-sacred-structure-rule.md)

## Regola Leaflet + Wizard

- [leaflet-wizard-step-invalidate-size](./concepts/leaflet-wizard-step-invalidate-size.md) — MutationObserver per rilevare cambio step wizard; invalidateSize() quando container diventa visibile
- [filament-admin-panel-map-visibility-contract](./concepts/filament-admin-panel-map-visibility-contract.md) — contratto mappa in panel Filament admin (non frontoffice)
- [geo-vite-build-contract](./concepts/geo-vite-build-contract.md) — contratto build Vite modulo Geo (entry reali, buildDirectory, verifica)
- [lit-light-dom-map-controls-and-sync](./concepts/lit-light-dom-map-controls-and-sync.md) — fix controlli mappa Lit + sync lat/lng in Light DOM
- [admin-map-magnifier-and-controls-visibility](./concepts/admin-map-magnifier-and-controls-visibility.md) — fix lente enorme e visibilità controlli mappa in admin
- [admin-map-runtime-500-encryption-key-blocker](./concepts/admin-map-runtime-500-encryption-key-blocker.md) — visual check bloccato da errore bootstrap Laravel (cipher/key), non da rendering mappa
- [reusable-search-ui-component-rule](./concepts/reusable-search-ui-component-rule.md) — il blocco search dei picker va estratto in componente Blade riutilizzabile

## Story 8-56 — map-picker-lit.js admin fix

- [map-picker-lit-admin-fix-8-56](./concepts/map-picker-lit-admin-fix-8-56.md) — 5 bug risolti: vite input mancante, CDN CSS, IntersectionObserver falso amico, SVG senza dimensioni

## Troubleshooting recente

| Pagina | Tipo | Argomento |
|--------|------|-----------|
| [geo-module](./overviews/geo-module.md) | overview | Gerarchia geografica italiana, Address, Comune, geocoding, LeafletMarkerMapInput |
| [static-geo-map-widget-pattern](./concepts/static-geo-map-widget-pattern.md) | concept | Pattern static GeoJSON + Lit + Leaflet + Filament widget |

- [filament-field-wrapper-error-message-missing](./troubleshooting/filament-field-wrapper-error-message-missing.md)

## Karpathy LLM Wiki Standard

- [forbidden-folders-rule](../../../../docs/wiki/concepts/forbidden-folders.md): Strict structural constraints.
- [llm-wiki-standard](../../../../docs/wiki/concepts/karpathy-wiki.md): Repository mapping and knowledge lifecycle.

## Sacred Hierarchy

- [concepts/](./concepts/): Architectural patterns and methodologies.
- [entities/](./entities/): Key models and components.
- [sources/](./sources/): Research data and external links.
- [comparisons/](./comparisons/): Alternative implementations.
- [decisions/](./decisions/): ADL (Architectural Decision Log).
- [troubleshooting/](./troubleshooting/): Known issues and solutions.
- [_archive/](./_archive/): Legacy documentation.
- [_templates/](./_templates/): Standard templates.

## Compiled Pages

| Page | Type | Source | Updated |
|------|------|--------|---------|
| [.gitkeep](./concepts/.gitkeep) | Concept | - | 2026-04-21 |
| [coordinate-picker-field](./concepts/coordinate-picker-field.md) | Concept | - | 2026-04-21 |
| [custom-marker-governance](./concepts/custom-marker-governance.md) | Concept | - | 2026-04-21 |
| [geo-map-widget-farmshops-pattern](./concepts/geo-map-widget-farmshops-pattern.md) | Concept | - | 2026-04-21 |
| [inventage-leaflet-map-reference](./concepts/inventage-leaflet-map-reference.md) | Concept | - | 2026-04-21 |
| [latitudelongitudeinput-runtime-ux](./concepts/latitudelongitudeinput-runtime-ux.md) | Concept | - | 2026-04-21 |
| [latitudelongitudeinput-xotbasefield-rule](./concepts/latitudelongitudeinput-xotbasefield-rule.md) | Concept | - | 2026-04-21 |
| [leaflet-class-selector-governance](./concepts/leaflet-class-selector-governance.md) | Concept | - | 2026-04-21 |
| [leaflet-selector-audit](./concepts/leaflet-selector-audit.md) | Concept | - | 2026-04-21 |
| [lit-web-components-resolution](./concepts/lit-web-components-resolution.md) | Concept | - | 2026-04-21 |
| [lit-web-components](./concepts/lit-web-components.md) | Concept | - | 2026-04-21 |
| [litelement-in-js-only-rule](./concepts/litelement-in-js-only-rule.md) | Concept | - | 2026-04-21 |
| [map-geolocation-fallback-rule](./concepts/map-geolocation-fallback-rule.md) | Concept | - | 2026-04-21 |
| [map-picker-family-architecture](./concepts/map-picker-family-architecture.md) | Concept | - | 2026-04-21 |
| [map-picker-filament-field](./concepts/map-picker-filament-field.md) | Concept | - | 2026-04-21 |
| [map-picker-locationpicker-architecture](./concepts/map-picker-locationpicker-architecture.md) | Concept | - | 2026-04-21 |
| [map-picker-runtime-asset-governance](./concepts/map-picker-runtime-asset-governance.md) | Concept | - | 2026-04-21 |
| [map-picker-address-search-mobile-parity](./concepts/map-picker-address-search-mobile-parity.md) | Concept | prompt map-picker | 2026-04-22 |
| [mappicker-custom-marker-rule](./concepts/mappicker-custom-marker-rule.md) | Concept | - | 2026-04-21 |
| [mappicker-runtime-ux](./concepts/mappicker-runtime-ux.md) | Concept | - | 2026-04-21 |
| [geo-picker-sibling-components-governance](./concepts/geo-picker-sibling-components-governance.md) | Concept | prompt map-picker | 2026-04-22 |
| [geo-components-stories](./concepts/geo-components-stories.md) | Concept | - | 2026-04-22 |
| [geo-fields-zen](./concepts/geo-fields-zen.md) | Concept | - | 2026-04-22 |
| [geo-picker-runtime-stability-best-practices](./concepts/geo-picker-runtime-stability-best-practices.md) | Concept | runtime + wizard verification | 2026-04-23 |
| [playwright-visual-testing](./concepts/playwright-visual-testing.md) | Concept | - | 2026-04-21 |
| [static-geo-map-widget-pattern](./concepts/static-geo-map-widget-pattern.md) | Concept | - | 2026-04-21 |
| [svg-asset-architecture](./concepts/svg-asset-architecture.md) | Concept | - | 2026-04-21 |
| [has-coordinate-picker-dry-boundary-rule](./concepts/has-coordinate-picker-dry-boundary-rule.md) | Concept | recent refactor | 2026-04-23 |
| [psr4-namespace-collision-coordinatepicker](./concepts/psr4-namespace-collision-coordinatepicker.md) | Concept | composer dump-autoload PSR-4 warnings | 2026-04-23 |
| [field-component-lessons-learned](./concepts/field-component-lessons-learned.md) | Concept | merge conflict resolution + EnumSelect fix | 2026-04-23 |
| [geopoint-picker-wizard-visibility](./concepts/geopoint-picker-map-invisible-wizard-fix.md) | Concept | map invisibilità dopo wizard step "Avanti" | 2026-04-23 |

## Lessons Learned — Merge Conflict & Field Components

| Pagina | Tipo | Argomento |
|--------|------|-----------|
| [field-component-lessons-learned](./concepts/field-component-lessons-learned.md) | concept | Best practices, anti-pattern e false friends da merge conflict, EnumSelect fix, `$view` properties |

*Ultimo aggiornamento: 2026-04-23*
