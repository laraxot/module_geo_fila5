# Geo Wiki Log

## [2026-04-22] fix | CoordinatePicker Alpine x-data e prompt quality bar
- Corretto `coordinate-picker.blade.php`: l'`x-data` usa delimitatori e serializzazione compatibili con stringhe vuote/indirizzi, evitando l'errore Alpine `Unexpected token`.
- Verificato il markup renderizzato della pagina `tests/segnalazione-crea` con `curl`: `address: ''` resta dentro l'oggetto Alpine senza rompere l'attributo.
- Aggiornato `docs/prompts/map-picker.txt` alla v2.3 con quality bar: link operativi, best practices, bad practices, false friends e Definition of Done.
- Rigenerato bundle Vite dopo modifiche JS/CSS del picker.

## [2026-04-22] ingest | MapPicker guide v2.2 complete - mobile-first, i18n, responsive
- Aggiornato `docs/prompts/map-picker.txt` alla v2.2 con sezioni complete:
  - Mobile-first & responsive (breakpoints, touch 44x44px, height strategy)
  - Multilingua (i18n) con chiavi translation per CoordinatePicker
  - Map controls (4 layer, zoom, fullscreen, geolocation)
  - Address search server-side
  - Structured address data (street, number, city, postcode, etc.)
  - Livewire performance (debounce, eventi finali)
  - Accessibilità (aria-label, screen reader)
- Aggiornate traduzioni in `lang/it/geo.php`, `lang/en/geo.php`, `lang/de/geo.php`:
  - `coordinate-picker.search_placeholder`
  - `coordinate-picker.use_my_location`
  - `coordinate-picker.locating`
  - `coordinate-picker.no_position`
  - `coordinate-picker.zoom_in` / `zoom_out`
  - `coordinate-picker.fullscreen` / `close_fullscreen`
  - `coordinate-picker.layers.*`
- Reference: https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html

## [2026-04-22] ingest | MapPicker address search, mobile parity, controls
- Aggiornato `docs/prompts/map-picker.txt` con addendum canonico su mobile-first, multilingua, Design Comuni parity senza Bootstrap Italia, ricerca indirizzo server-side, payload indirizzo strutturato, posizione corrente, pan/zoom, fullscreen e layer switcher a 4 layer.
- Ingestita sintesi riusabile in `docs/wiki/concepts/map-picker-address-search-mobile-parity.md`.
- Aggiornato `docs/wiki/index.md`.

## [2026-04-22] story | 8-44 geo-component-family-philosophy-alignment-and-docs
- **Filosofia/Zen**: documentato il "Contract of Intent" per tutti i 9 componenti in `docs/wiki/concepts/geo-component-family-philosophy.md`.
- **Holy Trinity**: Spirit (Trait) + Body (Blade) + Mind (Lit JS) — ogni componente ha i tre elementi separati.
- **Allineamento PHP**: `dehydrated(false)` mancante in 6 componenti compositi (`LocationPicker`, `PlacePicker`, `MapPositioner`, `MapLocationInput`, `LeafletMarkerMapInput`, `GeopointPicker`) — da correggere.
- **Allineamento Lit**: `place-picker-lit.js` usa CDN marker/`L.Icon.Default` (violazione critica); 4 componenti emettono `location-changed` anziché `coords-changed` canonico.
- **Quality gate**: estendere `CoordinatePickerRefactorTest.php` con 6 test sui compositi mancanti.
- **Ingest**: nuovi docs wiki da indicizzare in context-mode MCP.

## [2026-04-22] ingest | Geo Fields Zen e component stories
- Ingestiti `docs/wiki/concepts/geo-fields-zen.md`, `docs/wiki/concepts/geo-components-stories.md` e `docs/wiki/concepts/geo-picker-sibling-components-governance.md`.
- Consolidata filosofia: ogni picker Geo e un "Contract of Intent"; condivide `HasCoordinatePicker`, ma mantiene identita, Blade e Lit separati.
- Regole operative incluse: branch sempre `dev`; file dismessi rinominati `.old`, non rimossi con `rm`; Shadow DOM preferibile ma Light DOM ammesso se Leaflet lo richiede.

## [2026-04-22] refactor | story 8-43 geo-map-picker-family-complete-production-refactor
- **HasCoordinatePicker trait**: rimosso `dehydrated(false)` da `setUpCoordinatePicker()`; aggiunti alias `getLatitude()`/`getLongitude()` come sinonimi di `getCenterLatitude()`/`getCenterLongitude()`.
- **MapPicker / CoordinatePicker**: `dehydrated(false)` ora chiamato esplicitamente in `setUp()` di ciascuna classe composita.
- **LatitudeLongitudeInput**: NON chiama `dehydrated(false)` — corretto per field diretto.
- **geo-latlng-input.js**: marker Leaflet sostituito con `createMapPickerLeafletIcon(L)` da `map-picker-marker-config.js`; eliminato default `L.marker`.
- **Blade files** (`coordinate-picker`, `map-picker`, `latitude-longitude-input`): bridge Alpine canonico `$wire.$watch` + `$wire.$set` + `_suppressUpdate`; eliminato `wire:entangle`.
- **Test quality gate**: `CoordinatePickerRefactorTest.php` — 12 test, gerarchia classi, trait contract, dehydrated isolation.
- PHPStan level 8: nessun errore.

## [2026-04-22] governance | branch dev permanente per MapPicker prompt
- Aggiornato `docs/prompts/map-picker.txt`: vietato creare o cambiare branch per questo workflow; si lavora sempre su `dev`.
- Corretto il falso amico architetturale: `MapPickerField`/custom field Geo devono estendere `XotBaseField`, non `Filament\Forms\Components\Field`.

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
