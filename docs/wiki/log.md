# Geo Wiki Log

## [2026-04-21] story | 8-40 MapPicker front — entangle + map-picker-lit init wizard
- **Blade:** `resources/views/filament/forms/components/map-picker.blade.php` allineato a `coordinate-picker`: `$wire.entangle('statePath').live`, binding reattivo `:latitude` / `:longitude`, evento `coords-changed` → `$wire.$set` + `reverseGeocode` esposto.
- **Lit:** `resources/js/components/map-picker-lit.js` — `IntersectionObserver` per init quando lo step Filament diventa visibile; `updated()` sincronizza marker da props; `geolocate-when-empty` da attributo; cleanup observer.
- **Lang:** `lang/it/map-picker.php`, `lang/en/map-picker.php` — chiavi `status.*`.
- **Tema:** bundle Sixteen non importa più `filament/map-picker.js` (evita conflitto Alpine / CE legacy su front).

## [2026-04-21] fix | GeoServiceProvider — no-CDN asset registration
- Rimossi asset CDN unpkg (Leaflet JS/CSS) da `GeoServiceProvider::registerMapAssets()`.
- Registrati bundle locali pubblicati: `themes/Geo/js/manifest.js`, `vendor.js`, `geo.js` (include map-picker-lit + geoMapPickerField Alpine).
- Leaflet CSS locale: `themes/Geo/css/leaflet.css`.
- Regola rispettata: `map-marker-no-cdn` + `no-absolute-paths-in-config`.
- File: `laravel/Modules/Geo/app/Providers/GeoServiceProvider.php`

## [2026-04-21] fix | map-visual-fix.css — marker z-index e divIcon styles
- Corretto z-index delle panes Leaflet (era tutto z-index:1, i marker erano nascosti sotto i tile).
- Aggiunti stili globali per `.map-picker-marker--custom` e `.map-picker-marker__inner` (divIcon renderizzato fuori Shadow DOM).
- File: `laravel/Themes/Sixteen/resources/css/map-visual-fix.css`

## [2026-04-15] init | wiki bootstrap
- Struttura wiki/log.md inizializzata.
- Layer raw: tutti i file in `docs/` (eccetto `wiki/`).
- Layer wiki: `docs/wiki/` — LLM-maintained, sintesi ad alto riuso.
- Schema: `docs/.schema/WIKI_SCHEMA.md`
- Adozione moduli: `docs/project/llm-wiki-module-adoption.md`

## [2026-04-16] geomapwidget | static geo map widget pattern
- Documentato il pattern `GeoMapWidget` con dataset GeoJSON statico, Lit Web Component e Leaflet layer manager.
- Registrato l'uso corretto di `phpmd.phar` nel flusso qualità del modulo.
- Aggiunti test dedicati a `GeoMapDataset` per normalizzazione, categorie e statistiche.

## [2026-04-21] story | 8-39 geo coordinatepicker family architecture convergence
- Story artifact: `_bmad-output/implementation-artifacts/8-39-geo-coordinatepicker-family-architecture-convergence.md`.
- Scope: convergenza tra `CoordinatePicker`, `MapPicker`, `LatitudeLongitudeInput`, `PlacePicker` con contratto coordinate unico.

## [2026-04-21] fix | filament field-wrapper error-message component missing
- Rimossa chiamata legacy `x-filament-forms::field-wrapper.error-message` da `resources/views/filament/forms/components/coordinate-picker.blade.php`.
- Dettaglio: `docs/wiki/troubleshooting/filament-field-wrapper-error-message-missing.md`.

## [2026-04-21] refactor | LitElement ownership moved to JS layer
- Lit/Web Component registrato via `resources/js/filament/map-picker.js` e import tema dove applicabile.

## [2026-04-21] governance | struttura wiki geo canonica
- Contratto cartelle: `docs/wiki/{concepts,entities,sources,comparisons,decisions,troubleshooting,_archive,_templates}`.

## [2026-04-21] bugfix | MapPicker Filament ViewComponent richiede `$view`
- **Errore**: `Class MapPicker extends ViewComponent but does not have a [$view] property defined` (wizard test segnalazione).
- **Fix**: `protected string $view = 'geo::filament.forms.components.map-picker';` in `app/Filament/Forms/Components/MapPicker.php`.
- **Nota**: proprietà fluent `geolocateWhenEmpty` rinominata in `$geolocateWhenEmptyState` per evitare conflitto col metodo omonimo; trait `HasCoordinatePicker` in `Traits\`.

## [2026-04-21] bugfix | mappicker height alias runtime (storico)
- Errore storico: `BadMethodCallException: MapPicker::height does not exist`; mitigato con supporto height nel trait/component ove presente.

## [2026-04-21] governance | forbidden folders zero tolerance
- Collegamento regola root: `../../../../docs/wiki/concepts/forbidden-folders-zero-tolerance-rule.md`.
