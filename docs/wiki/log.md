# Geo Wiki Log

## [2026-04-27] refactor | story 8-62 — search ui picker estratta in componente riutilizzabile
- estratto blocco search (`input + loading + risultati`) da `coordinate-picker.blade.php` in `filament/components/address-search-input.blade.php`.
- il coordinate picker ora include il componente riusabile con `@include('geo::filament.components.address-search-input')`.
- aggiunta regola wiki: `concepts/reusable-search-ui-component-rule.md`.

## [2026-04-27] verifica | story 8-61 — admin map visual check bloccato da runtime 500
- eseguito controllo visuale con strumenti browser e screenshot su route admin ticket create.
- evidenza: pagina in `Internal Server Error` con `Unsupported cipher or incorrect key length` (bootstrap encryption), prima del render mappa.
- confermata assenza nel DOM di `coordinate-picker-lit`/`map-picker-lit` in questo stato.
- nuova pagina: `concepts/admin-map-runtime-500-encryption-key-blocker.md`.

## [2026-04-27] fix | story 8-57 — geopoint-picker-lit.js (5 bug)
- BUG 1: aggiunto `geopoint-picker-lit.js` in `vite.config.js` (non era bundlato)
- BUG 2: rimosso CDN unpkg Leaflet CSS, aggiunto `import 'leaflet/dist/leaflet.css'`
- BUG 3: `mapPickerStylesText` (stringa) invece di `mapPickerStyles` (CSSResult); `z-index: 1000 !important` su `.layer-controls-overlay` e `.search-box` — `:host` vars ignorati in Light DOM
- BUG 4: MutationObserver depth 15 in `firstUpdated()` per rilevare `class="hidden"` wizard
- BUG 5: creato `geo-heroicons.js` — `geoIcon('name')` per icone Lit (Filament way)
- `AdminPanelProvider.php`: aggiunto `geopoint-picker` asset
- BUILD: `npm run build && npm run copy` OK
- REGOLE: `lit-icons-filament-way.md`, `translation-navigation-placeholder-rule.md`

## [2026-04-27] fix | admin route lens oversize + controls hidden
- in `coordinate-picker.blade.php` sostituita lente search con SVG inline a dimensione fissa per evitare scaling anomalo.
- in `coordinate-picker-lit.js` rafforzata visibilità controlli mappa (top/right, z-index, sizing bottoni e icone).
- in `coordinate-picker-lit.js` corretto `dragend` marker usando `e.target.getLatLng()` con guard.
- in `map-picker-lit.js` corretto style binding da `mapPickerStyles` a `mapPickerStylesText`.
- eseguiti `npm run build` + `npm run copy` nel modulo Geo con esito OK.
- nuova pagina `concepts/admin-map-magnifier-and-controls-visibility.md`.

## [2026-04-27] fix | lit light-dom css + immutable state sync
- consolidato `CoordinatePicker` Lit per contesto Light DOM: `mapPickerStylesText` usato nel `<style>` inline del componente.
- in `coordinate-picker.blade.php` aggiornamento stato portato a pattern immutabile (`this.state = { ... }`) per rendere affidabile il refresh di latitude/longitude.
- rieseguiti `npm run build` e `npm run copy` da `laravel/Modules/Geo` con esito positivo.
- aggiunta pagina `concepts/lit-light-dom-map-controls-and-sync.md`.

## [2026-04-27] fix | story 8-56 — map-picker-lit.js admin panel (5 bug)
- BUG 1 FIXED: aggiunto `map-picker-lit.js` agli input di `vite.config.js` (era assente → custom element non registrato)
- BUG 2 FIXED: rimosso CDN `<link href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">` dal `render()`, aggiunto `import 'leaflet/dist/leaflet.css'` in cima al file
- BUG 3 FIXED: sostituito `IntersectionObserver` (false friend) con `MutationObserver` depth 15 in `connectedCallback()` — rileva correttamente class="hidden" wizard Filament
- BUG 4: marker dragend già presente correttamente — non bug
- BUG 5 FIXED: aggiunto `width="20" height="20"` all'SVG inline in `_renderSearch()` — elimina lente enorme
- ASSET: `AdminPanelProvider.php` aggiornato con registrazione `Js::make('map-picker', ...)` per `map-picker-lit.js`
- BUILD: `npm run build && npm run copy` completato con successo da `laravel/Modules/Geo`
- VERIFICA PENDINGA: Playwright MCP non funziona in questo ambiente (`/opt/google/chrome/chrome` non trovato)
- Nuova pagina: `concepts/map-picker-lit-admin-fix-8-56.md`

## [2026-04-27] fix | SVG assets + Blade icon component + docs study
- Creati file SVG mancanti in `resources/svg/`: `map-pin.svg`, `squares-2x2.svg`, `plus.svg`, `minus.svg`.
- `geo-heroicons.js` già aggiornato: import da `../../svg/*.svg?raw` + `html\`${svg}\`` (Filament Way).
- Creato `resources/views/components/icon.blade.php` per servire SVG via `@include('geo::components.icon')`.
- `address-search-input.blade.php` aggiornato: usa `<img src="{{ asset('modules/geo/svg/...') }}">` invece di `@svg('geo::...')` (Blade UI Kit non supporta set personalizzati).
- Eseguito `php artisan view:clear` per pulire cache viste.
- Studio docs: struttura wiki moduli (`concepts/`, `rules/`, `entities/`, `log.md`, `index.md`) verificata e coerente.

## [2026-04-27] fix | geo npm build broken entries + js syntax
- eseguito `npm run build` da `laravel/Modules/Geo` con errore iniziale su entry Vite inesistente (`resources/css/app.css`).
- corretto `vite.config.js`: `buildDirectory` da `assets/chart` a `assets/geo`, input CSS/JS allineati ai file reali.
- corretto parse error in `resources/js/components/coordinate-picker-lit.js` (constructor non chiuso).
- rieseguito build con esito positivo (`vite build` completato, manifest generato in `public/manifest.json`).
- nuova pagina: `concepts/geo-vite-build-contract.md`.

## [2026-04-27] story | 9-01 map component purpose and business outcome
- Documentato scopo business della mappa in ticket wizard (`/fixcity/admin/tickets/create`)
- Architettura a strati: Fixcity (business logic) → Geo (map runtime) → Sixteen (UI styling)
- Flusso dati: `CoordinatePicker::make('location')` → `coordinate-picker-field.js` → `map-picker-lit.js` → DB
- BMAD story: `_bmad-output/implementation-artifacts/9-01-map-component-purpose.md`
- Nuova pagina: `concepts/map-component-purpose-architecture.md`

## [2026-04-27] governance | Filament admin panel map visibility contract
- aggiunta pagina `concepts/filament-admin-panel-map-visibility-contract.md`.
- chiarito che i fix mappa frontoffice non sono prova sufficiente per route admin panel.
- formalizzate regole su visibility timing, `invalidateSize`, redraw mirato e verifica route reale.
- aggiunta evidenza runtime: `geo-map-widget.js` assente su `public_html/modules/geo/` mentre `geo.js` e' su `public_html/themes/Geo/js/`.
- registrata root-cause loader: fallback `map-picker-component.js` senza alias `map-picker-lit` nel ramo `resp.ok === false`.
- eseguita verifica visuale reale route admin tickets/create con conferma fallback runtime attivo (`themes/Geo/js/map-picker-component.js`).
- fix applicato su provider admin Geo: rimossa registrazione `geo-map-widget.js` (asset non presente).
- fix applicato su loader runtime: bundle primario `themes/Geo/js/geo.js` + fallback coerente.
- fix fallback map-picker component: Leaflet locale-first (`/themes/Geo/...`) con CDN solo come backup.

## [2026-04-23] ops | PSR-4 / namespace collision - CoordinatePicker
- Nuova pagina: `concepts/psr4-namespace-collision-coordinatepicker.md`.
- Documentata la regola: namespace coerente con path (es. `app/Forms/...` => `Modules\\Geo\\Forms\\...`) per evitare classi skip in `composer dump-autoload`.

## [2026-04-23] governance | HasCoordinatePicker come boundary DRY della famiglia picker
- documentata la regola `has-coordinate-picker-dry-boundary-rule`
- nella trait vivono stato/helper condivisi; nelle classi concrete solo comportamento davvero specifico
- aggiunta sezione best practices, bad practices e false friends per evitare nuove duplicazioni tra sibling picker

## [2026-04-23] governance | Geo picker runtime stability
- Documentate best practices, bad practices e false friends per i picker Geo in wizard/frontoffice.
- Fissate le regole su import bundle tema, invalidateSize, flicker control, trait condivisi e divieto di `$view` nei componenti che estendono `XotBaseField`.
- Nuova pagina: `concepts/geo-picker-runtime-stability-best-practices.md`.

## [2026-04-22] fix | Leaflet mappa vuota dopo step wizard — MutationObserver
- **problema**: cliccare "Avanti" nel wizard Filament lasciava la mappa grigia/vuota
- **root cause**: Filament wizard nasconde step con `class="hidden"` (Tailwind); Leaflet vedeva container 0×0 al mount; ResizeObserver e IntersectionObserver non intercettano questo
- **fix**: aggiunto MutationObserver su 6 antenati in `firstUpdated()` di `coordinate-picker-lit.js`; chiama `_refreshMapSize()` con delay 150ms quando `offsetParent !== null`
- **CDN fix**: rimosso `<link unpkg.com/leaflet.css>` dal render(); aggiunto `import 'leaflet/dist/leaflet.css'` in cima al file
- **build**: `cd laravel/Themes/Sixteen && npm run build && npm run copy` — 51 moduli, OK
- **rule**: `bashscripts/ai/.claude/rules/leaflet-wizard-invalidate-size.md`
- **wiki**: `laravel/Modules/Geo/docs/wiki/concepts/leaflet-wizard-step-invalidate-size.md`

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

## [2026-04-27] fix | map-picker-lit.js — MutationObserver depth + refreshMapSize
- Aumentato MutationObserver depth da 15 a 20 in `map-picker-lit.js` per rilevare `class="hidden"` wizard Filament 5.
- Aggiunto metodo `_refreshMapSize()` con delay array `[0, 80, 180, 350, 700, 1200]` per gestire ambienti lenti e transizioni Alpine.
- `_initMap()` ora chiama `this._refreshMapSize()` dopo inizializzazione.
- Rimosso `IntersectionObserver` da `coordinate-picker-lit.js` (false friend — non rileva `class="hidden"` Tailwind).
- Aumentato depth da 15 a 20 anche in `coordinate-picker-lit.js`.
- Build Vite completato: `npm run build && npm run copy` OK.

## [2026-04-27] fix | Blade icon collision — geo:: prefix
- Errore `CannotRegisterIconSet`: il prefix `geo.` collide con il set `default` (prefix `''`).
- Fix: `address-search-input.blade.php` ora usa `<img src="{{ asset('modules/geo/svg/magnifying-glass.svg') }}">` invece di `@svg('geo::magnifying-glass')`.
- Regola: quando il set `default` ha prefix vuoto, non usare `@svg('set::...')` — usare asset diretto.

## [2026-04-27] docs | aggiornamento LLM wiki + regole
- Verificato che `bashscripts/ai/.claude/rules/` contiene tutte le regole attuali (23 file .md).
- Verificato che `laravel/Modules/Geo/docs/wiki/` ha struttura canonica: concepts/, entities/, comparisons/, decisions/, troubleshooting/.
- Verificato che `laravel/Themes/Sixteen/docs/` ha documentazione completa (60+ file .md).
- Aggiornato `log.md` con sessione odierna.
