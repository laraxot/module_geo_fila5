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
- [phpmd-standalone-phar-rule](../../../../../docs/wiki/concepts/phpmd-standalone-phar-rule.md) — PHPMD del progetto/BMAD va tenuto standalone `.phar`, non via Composer
- [filament custom field state binding modifiers](./concepts/filament-custom-field-state-binding-modifiers-rule.md) — nei custom field usare `applyStateBindingModifiers()` attorno a `wire:model` / `$entangle()` per rispettare `live()` e `defer()`
- [second brain discipline for geo](./concepts/second-brain-geo-module-discipline.md) — nel modulo Geo il second brain accumula contratti field/runtime e falsi amici gia' risolti

## Scopo Mappa in Admin Ticket Create

- [coordinate-picker-purpose](./concepts/coordinate-picker-purpose.md) — scopo mappa in `/fixcity/admin/tickets/create`: selezione precisa luogo, geolocalizzazione, search indirizzo, layer switching
- [map-purpose](./concepts/map-purpose.md) — finalità mappa in wizard admin: lat/lng ticket, fallback geolocazione, UI controls
- [map-picker-location-json-contract](./concepts/map-picker-location-json-contract.md) — `location` come payload JSON canonico con `lat/lng`, bridge legacy per `latitude/longitude`

## Regola Leaflet + Wizard

- [leaflet-wizard-step-invalidate-size](./concepts/leaflet-wizard-step-invalidate-size.md) — MutationObserver per rilevare cambio step wizard; invalidateSize() quando container diventa visibile
- [filament-admin-panel-map-visibility-contract](./concepts/filament-admin-panel-map-visibility-contract.md) — contratto mappa in panel Filament admin (non frontoffice)
- [geo-vite-build-contract](./concepts/geo-vite-build-contract.md) — contratto build Vite modulo Geo (entry reali, buildDirectory, verifica)
- [lit-light-dom-map-controls-and-sync](./concepts/lit-light-dom-map-controls-and-sync.md) — fix controlli mappa Lit + sync lat/lng in Light DOM
- [admin-map-magnifier-and-controls-visibility](./concepts/admin-map-magnifier-and-controls-visibility.md) — fix lente enorme e visibilità controlli mappa in admin
- [admin-map-runtime-500-encryption-key-blocker](./concepts/admin-map-runtime-500-encryption-key-blocker.md) — visual check bloccato da errore bootstrap Laravel (cipher/key), non da rendering mappa
- [reusable-search-ui-component-rule](./concepts/reusable-search-ui-component-rule.md) — il blocco search dei picker va estratto in componente Blade riutilizzabile

## SVG Assets (Filament Way)

- [lit-icons-filament-way](./concepts/lit-icons-filament-way.md) — icone Lit via `geoIcon()` da file SVG in `resources/svg/`, non hardcoded
- [svg-asset-architecture](./concepts/svg-asset-architecture.md) — SVG sempre in `Modules/Geo/resources/svg/`, mai CDN/unpkg
- [blade-icons-registration-rule](./concepts/blade-icons-registration-rule.md) — Blade Icons registrati SOLO da XotBaseServiceProvider, mai nei moduli (evita collisioni prefix)

## Story 8-56 — map-picker-lit.js admin fix

- [map-picker-lit-admin-fix-8-56](./concepts/map-picker-lit-admin-fix-8-56.md) — 5 bug risolti: vite input mancante, CDN CSS, IntersectionObserver falso amico, SVG senza dimensioni

## Troubleshooting recente

| Pagina | Tipo | Argomento |
|--------|------|-----------|
| [geo-module](./overviews/geo-module.md) | overview | Gerarchia geografica italiana, Address, Comune, geocoding, LeafletMarkerMapInput |

## Nuovi documenti 2026-04-27

- [svg-asset-architecture](./concepts/svg-asset-architecture.md) — aggiornato con nuovi file SVG (magnifying-glass, arrows-pointing-out/in, map-pin, squares-2x2, plus, minus)
- [blade-icons-registration-rule](./concepts/blade-icons-registration-rule.md) — collisioni prefix `geo` evitate: auto-registrazione XotBaseServiceProvider gestisce tutto

## Story 8-65 — CoordinatePicker Filament 5 state binding + save fix

- [coordinate-picker-filament5-save-pattern](./concepts/coordinate-picker-filament5-save-pattern.md) — root cause: `dehydrated(false)` blocca salvataggio; fix con `dehydrateStateUsing()` + Eloquent mutator
- [filament5-custom-field-entangle-contract](./concepts/filament5-custom-field-entangle-contract.md) — perché `$applyStateBindingModifiers("\$entangle('{$statePath}')")` è OBBLIGATORIO — prova dal codice vendor Filament 5
- [coordinate-picker-state-binding-rule](./concepts/coordinate-picker-state-binding-rule.md) — **NUOVO**: documentazione completa state binding Filament 5.x: differenza `$applyStateBindingModifiers()` vs `$wire.$entangle()` diretto, gestione modificatori `live()`/`defer()`
