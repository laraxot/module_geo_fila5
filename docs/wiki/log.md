# Geo Wiki Log

## [2026-04-20] ui | zoom +/- con icone svg e senza sottolineatura
- sources:
  - `resources/js/components/coordinate-picker-field.js`
- summary:
  - rimossa sottolineatura dei pulsanti zoom Leaflet
  - sostituiti i simboli testuali `+/-` con icone SVG standard
  - mantenuta coerenza visiva con i controlli custom mappa

## [2026-04-20] ui | map controls uniformati su stile comune
- sources:
  - `resources/js/components/coordinate-picker-field.js`
- summary:
  - uniformato stile pulsanti zoom Leaflet (`+/-`) al design dei controlli custom mappa
  - sostituite icone emoji con SVG standard per fullscreen e posizione corrente
  - migliorata coerenza UX: controlli mappa con affordance visive omogenee e familiari

## [2026-04-20] feat | marker mappicker custom ispirato farmshops
- sources:
  - `resources/js/components/map-picker-marker-config.js`
- pages:
  - `docs/wiki/concepts/map-picker-runtime-asset-governance.md` (reference)
- summary:
  - implementato marker custom SVG con `L.divIcon` per `MapPicker`, con silhouette ad alto contrasto e centro leggibile su layer street/satellite
  - mantenuto fallback locale (`map-picker-marker-fallback.svg`) senza dipendenze CDN
  - centralizzata configurazione marker nel file `map-picker-marker-config.js` per mantenere DRY/KISS

## [2026-04-20] rule | marker custom locale per mappicker, no leaflet default
- sources:
  - `resources/views/maps/farmshops/README.md`
  - `docs/wiki/concepts/geo-map-widget-farmshops-pattern.md`
  - `docs/wiki/concepts/map-picker-runtime-asset-governance.md`
- pages:
  - `../../../../docs/wiki/log.md` (updated)
- summary:
  - formalizzata la regola: il `MapPicker` non deve usare il marker default Leaflet come soluzione finale
  - vietato usare URL `unpkg`/CDN per il marker runtime; solo asset locali `svg/png` controllati dal progetto
  - il riferimento corretto e' il principio farmshops-like: marker custom del progetto con config centralizzata e fallback definito

## [2026-04-20] rule | mappicker marker custom locali, no marker default leaflet da cdn
- sources:
  - `https://github.com/CodeforKarlsruhe/farmshops.eu/blob/master/js/direktvermarkter.js`
  - `resources/js/leaflet.extra-markers.min.js`
  - `resources/js/xot-markers.js`
  - `docs/wiki/concepts/map-picker-runtime-asset-governance.md`
- pages:
  - `docs/wiki/concepts/map-picker-runtime-asset-governance.md` (updated)
  - `../../../../_bmad-output/implementation-artifacts/8-26-mappicker-custom-local-marker-assets-farmshops-pattern.md` (new)
- summary:
  - fissata la regola runtime: `MapPicker` non deve dipendere dai marker standard Leaflet caricati da CDN o path impliciti non verificati
  - il pattern di riferimento corretto e marker custom locali owner-side, ispirati a `farmshops.eu`
  - la remediation richiesta include asset SVG/PNG versionati nel repository e pipeline marker controllata dal progetto

## [2026-04-20] rule | coordinate incomplete nel mappicker => geolocalizzazione corrente
- sources:
  - `resources/js/components/coordinate-picker-field.js`
  - `docs/wiki/concepts/map-picker-filament-field.md`
  - `docs/wiki/concepts/latitudelongitudeinput-runtime-ux.md`
- pages:
  - `../../../../docs/wiki/log.md` (updated)
- summary:
  - formalizzata la regola runtime: se `latitude` oppure `longitude` sono null/non numeriche, il `MapPicker` tratta la coppia come incompleta
  - il runtime tenta geolocalizzazione browser e usa la posizione corrente per valorizzare entrambe le coordinate
  - aggiunti helper espliciti nel web component per rendere la regola leggibile nei refactor futuri

## [2026-04-20] rule | mappicker estende xotbasefield
- sources:
  - `app/Filament/Forms/Components/MapPicker.php`
  - `app/Filament/Forms/Components/Traits/HasCoordinatePicker.php`
  - `tests/Unit/Filament/Forms/Components/MapPickerTest.php`
  - `tests/Unit/Filament/Forms/Components/CoordinatePickerTest.php`
- pages:
  - `docs/wiki/concepts/mappicker-xotbasefield-rule.md` (new)
  - `docs/wiki/index.md` (updated)
- summary:
  - applicata regola permanente: `MapPicker` ora estende `XotBaseField` invece di `CoordinatePicker`
  - mantenuto riuso DRY tramite trait `HasCoordinatePicker` e alias `defaultLocation()`
  - aggiunti test di guardia sull'ereditarieta per prevenire regressioni

## [2026-04-20] fix | mappicker overlay controls, address readout and marker initialization
- sources:
  - `resources/views/filament/forms/components/coordinate-picker.blade.php`
  - `resources/js/components/coordinate-picker-field.js`
- summary:
  - risolto readout indirizzo `[Object Object]` normalizzando la risposta `reverseGeocode` nel bridge Alpine
  - spostato `L.control.layers` in `topleft` per evitare overlap con toolbar custom fullscreen/geolocate
  - marker inizializzato sempre su centro valido anche senza coordinate esplicite
  - migliorata UX fullscreen (viewport piena + lock scroll body + invalidateSize affidabile)

## [2026-04-20] fix | latitudelongitudeinput map visibility + fullscreen reactivity
- sources:
  - `resources/js/components/geo-latlng-input.js`
- summary:
  - corretto rendering tile mappa in `LatitudeLongitudeInput` forzando dimensione reale del canvas Leaflet in Light DOM
  - resa reattiva la UI runtime interna (`isFullscreen`, `isLocating`, `currentLayer`) per evitare mismatch stato/DOM
  - mantenuto binding mappa su classi locali e non su id globali

## [2026-04-20] refactor | Mandatory Inheritance & Independent Hierarchy
- sources:
  - `laravel/Modules/Geo/app/Filament/Forms/Components/Traits/HasCoordinatePicker.php`
  - `laravel/Modules/Geo/app/Filament/Forms/Components/LatitudeLongitudeInput.php`
  - `laravel/Modules/Geo/app/Filament/Forms/Components/CoordinatePicker.php`
- pages:
  - `../../../../docs/wiki/entities/latitude-longitude-input.md`
  - `../../../../docs/wiki/entities/mappicker.md`
- summary:
  - Applicata regola mandatoria: `LatitudeLongitudeInput` estende **`XotBaseField`** (NOT `CoordinatePicker`).
  - Introdotto trait `HasCoordinatePicker` per condividere logica tra componenti indipendenti (DRY).
  - Rimosse ridondanze "Default" dai nomi dei metodi core.
  - Validata gerarchia classi via Pest.

## [2026-04-20] rule | latitudelongitudeinput dry kiss senza toggle showMap
- sources:
  - `app/Filament/Forms/Components/LatitudeLongitudeInput.php`
  - `resources/views/filament/forms/components/latitude-longitude-input-lit.blade.php`
  - `../../Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`
- pages:
  - `docs/wiki/concepts/latitudelongitudeinput-xotbasefield-rule.md` (updated)
  - `docs/wiki/index.md` (updated)
- summary:
  - rimossa API `showMap()/shouldShowMap()` dal field legacy
  - ripristinato contratto KISS: il componente ha una sola UI coerente, senza rami opzionali di presentazione
  - allineati consumer e documentazione per evitare regressioni

## [2026-04-20] rule | latitudelongitudeinput estende xotbasefield
- sources:
  - `app/Filament/Forms/Components/LatitudeLongitudeInput.php`
  - `../../Modules/Xot/app/Filament/Forms/Components/XotBaseField.php`
- pages:
  - `docs/wiki/concepts/latitudelongitudeinput-xotbasefield-rule.md` (new)
  - `docs/wiki/index.md` (updated)
- summary:
  - eliminata ereditarietà da `CoordinatePicker`; `LatitudeLongitudeInput` ora estende `XotBaseField`
  - mantenuta API compatibile (`defaultCenter/defaultZoom/mapHeight`) con implementazione autonoma
  - rafforzata governance Laraxot sui custom field Filament

## [2026-04-20] fix | latitudelongitudeinput fullscreen e drag stability nel web component lit
- sources:
  - `resources/js/components/geo-latlng-input.js`
- summary:
  - sostituito fullscreen browser API con modalità espansa CSS locale (`.map-shell.is-expanded`) per evitare schermata nera nel wizard
  - rimosso riferimento a metodo inesistente durante drag (`updateInputs`) e consolidato update stato locale con emit solo a `dragend`
  - migliorato bottone geolocalizzazione con stato loading (`isLocating`) e evento `geo-done`
  - mantenuto mount Leaflet su classe locale `.map-canvas`

## [2026-04-20] fix | latitudelongitudeinput rimozione duplicazione campi lat/lng
- sources:
  - `resources/js/components/geo-latlng-input.js`
  - `resources/views/filament/forms/components/latitude-longitude-input-lit.blade.php`
- summary:
  - eliminata la seconda coppia di input latitudine/longitudine nel web component Lit
  - mantenuta una sola coppia editabile nel layer Blade, con mappa Lit usata solo per interazione geografica
  - ridotta ambiguità UX e coupling tra stato mappa e rendering input

## [2026-04-20] governance | leaflet mount via class selectors only
- sources:
  - `docs/prompts/map-picker.txt`
  - `.cursor/rules/leaflet-class-selector-governance.mdc`
- pages:
  - `docs/wiki/concepts/leaflet-class-selector-governance.md` (new)
  - `docs/wiki/index.md` (updated)
- summary:
  - formalizzata regola permanente: i picker mappa Geo non devono usare id globali per il container Leaflet
  - standardizzato il pattern di lookup locale (`this.querySelector`, `this.$el.querySelector`) per istanze multiple

## [2026-04-20] audit | selector id-based residue mapping (geo + sixteen)
- sources:
  - `resources/js/components/*`
  - `resources/views/filament/forms/components/*`
  - `laravel/Themes/Sixteen/*`
- pages:
  - `docs/wiki/concepts/leaflet-selector-audit.md` (new)
- summary:
  - tracciati i residui id-based distinguendo runtime picker family da legacy/demo/assets
  - definita priorità di remediation: runtime first, legacy on dedicated task

## [2026-04-20] fix | latitudelongitudeinput allineato a coordinatepicker (no defaultLatitude)
- sources:
  - `app/Filament/Forms/Components/LatitudeLongitudeInput.php`
  - `resources/views/filament/forms/components/latitude-longitude-input-lit.blade.php`
- summary:
  - risolta eccezione `BadMethodCallException` causata da view legacy che invocava `getDefaultLatitude/getDefaultLongitude/getDefaultZoom/getMapHeight` non piu disponibili dopo convergenza su `CoordinatePicker`
  - la view Lit ora usa naming coerente col core: `getLatitude`, `getLongitude`, `getZoom`, `getHeight`
  - fallback centro mappa mantenuto (`41.9028`, `12.4964`) solo se stato e center non valorizzati

## [2026-04-20] hotfix | latitudelongitudeinput non renderizzato (include errato)
- sources:
  - `resources/views/filament/forms/components/latitude-longitude-input.blade.php`
  - `resources/views/filament/forms/components/latitude-longitude-input-lit.blade.php`
- summary:
  - identificata regressione bloccante: il file `latitude-longitude-input.blade.php` includeva erroneamente `coordinate-picker`, causando sparizione del widget legacy nel wizard
  - ripristinato include corretto verso `latitude-longitude-input-lit` senza toccare i picker commentati in `CreateTicketWizardWidget`
  - eseguiti clear cache Laravel + rebuild tema Sixteen per riallineare runtime

## [2026-04-20] fix | latitudelongitudeinput init bridge + toolbar visibile
- sources:
  - `resources/views/filament/forms/components/latitude-longitude-input.blade.php`
  - `docs/wiki/concepts/map-picker-runtime-asset-governance.md`
- summary:
  - aggiunto `x-init="init()"` al root Alpine del legacy picker: senza init mappa/listener geoloc+layer non partivano
  - toolbar layer/geolocalizzazione reso visibile con layout relativo (non assoluto) per evitare collisioni visuali nel wizard
  - confermato comportamento atteso: bottone posizione corrente centra marker+mappa e layer switch disponibile

## [2026-04-20] refactor | convergenza famiglia picker geo su contratto eventi unico
- sources:
  - `resources/js/components/coordinate-picker-field.js`
  - `resources/js/components/map-picker-lit.js`
  - `resources/js/components/place-picker-lit.js`
  - `resources/views/filament/forms/components/map-picker.blade.php`
  - `resources/views/filament/forms/components/place-picker.blade.php`
  - `docs/wiki/concepts/map-picker-family-architecture.md`
- summary:
  - `coordinate-picker-field` esteso con azione esplicita "usa posizione corrente" e sync marker+coords
  - `map-picker-lit` espone ora anche evento `coords-changed` (oltre a `location-changed`) per uniformare i bridge Alpine
  - `map-picker.blade.php` aggiornato per leggere dettagli evento robustamente (`latitude/longitude`) e supportare entrambi gli eventi
  - `place-picker-lit` rimosso auto-geolocate in bootstrap: geolocalizzazione ora solo user-driven via bottone
  - `place-picker.blade.php` allineati a `$wire.$set(..., false)` per ridurre churn verso backend

## [2026-04-20] fix | latitudelongitudeinput geolocate button + fullscreen edge-to-edge
- sources:
  - `resources/views/filament/forms/components/latitude-longitude-input.blade.php`
  - `lang/it/latitude_longitude_input.php`
  - `lang/en/latitude_longitude_input.php`
  - `docs/wiki/concepts/map-picker-runtime-asset-governance.md`
- summary:
  - reso visibile/stabile il pulsante "usa posizione corrente" nel toolbar overlay (layout `w-full` con ancoraggio destro)
  - introdotto evento `geo-done` su successo/errore geolocalizzazione per chiudere sempre lo stato loading UI
  - corretto fullscreen browser del legacy picker con regole `:fullscreen` / `:-webkit-full-screen` su shell e canvas per copertura totale schermo
  - localizzato label azione geolocalizzazione in `geo::latitude_longitude_input.actions.use_current_position`

## [2026-04-20] feat | coordinatepicker filamento completo (php+blade+lit+test)
- sources:
  - `app/Filament/Forms/Components/CoordinatePicker.php`
  - `resources/views/filament/forms/components/coordinate-picker.blade.php`
  - `resources/js/components/coordinate-picker-field.js`
  - `tests/Unit/Filament/Forms/Components/CoordinatePickerTest.php`
  - `docs/coordinate-picker.md`
- summary:
  - consolidato `CoordinatePicker` con stato composito `{ latitude, longitude }` e `dehydrated(false)`
  - reverse geocoding opzionale server-side con `#[ExposedLivewireMethod]` + `#[Renderless]`
  - bridge Alpine ridotto a sync esplicita `$wire.$watch` / `$wire.$set` e readout UI
  - web component Lit con Leaflet in Light DOM intenzionale, marker draggable, click-to-set, layer switch e cleanup lifecycle
  - aggiunta suite Pest unitaria per mapping e configurazioni fluent

## [2026-04-20] fix | coesistenza picker multipli senza collisione selector
- sources:
  - `app/Filament/Forms/Components/MapPicker.php`
  - `resources/views/filament/forms/components/map-picker.blade.php`
  - `resources/views/filament/forms/components/place-picker.blade.php`
  - `resources/js/components/place-picker-lit.js`
  - `resources/views/filament/forms/components/coordinate-picker.blade.php`
- summary:
  - ripristinato `MapPicker` valido dopo corruzione sintattica (parse error)
  - `PlacePicker` e `CoordinatePicker` allineati a binding locale via classi (`.js-*`) evitando lookup globali per id
  - `place-picker-lit` usa container mappa con classe (`.place-picker-map-container`) invece di `#id`
  - verifica runtime su `/it/tests/segnalazione-crea?step=...`: Leaflet controls presenti in tutti i picker nello stesso step

## [2026-04-20] docs | MapPicker Architecture + Screenshot Documentation
- sources:
  - `laravel/Modules/Geo/docs/wiki/concepts/map-picker-locationpicker-architecture.md` (NUOVO)
  - `docs/wiki/assets/screenshots/segnalazione-crea-wizard-*.png` (5 screenshot)
  - `laravel/Modules/Geo/app/Filament/Forms/Components/MapPicker.php`
  - `laravel/Modules/Geo/resources/js/components/map-picker-lit.js`
- summary:
  - Creata documentazione architetturale unified-state con 4 decisioni chiave motivate.
  - Catturati 5 screenshot del wizard `/it/tests/segnalazione-crea` con Playwright.
  - Embed screenshot in wiki con contesto (initial, fullscreen, layer-switch, geolocation).
  - Aggiornati indici e log wiki (Geo + docs/globali).
  - Story BMad 1.7 completata con AC e architecture diagram.

## [2026-04-19] install | Playwright Visual Tools
- sources:
  - `package.json`, `laravel/Modules/Geo/docs/visual-tools.md`
- summary:
  - Configurato Playwright per regressione visiva e screenshots di documentazione.
  - Documentata procedura `npx playwright screenshot` in `visual-tools.md`.

## [2026-04-19] feat | MapPositioner (v3)
- sources:
  - `laravel/Modules/Geo/app/Filament/Forms/Components/MapPositioner.php`
  - `laravel/Modules/Geo/resources/js/components/map-positioner-lit.js`
  - `laravel/Modules/Geo/resources/views/filament/forms/components/map-positioner.blade.php`
- summary:
  - Creato `MapPositioner` come successore di `MapPicker`.
  - Architettura Unified State `{ latitude, longitude }`.
  - Web Component dedicato `map-positioner-lit` con marker blu e logica ultra-robusta.
  - Dokumentazione completa in `MAP-POSITIONER.md`.

## [2026-04-19] refactor | MapPicker Unified State (v2)
...
