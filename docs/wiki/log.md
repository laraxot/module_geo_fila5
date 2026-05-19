---
title: "Geo Wiki Activity Log"
module: "Geo"
---

# Geo - Wiki Activity Log

## [2026-05-15] Toolbar: registry in `render-controls.js`

- `OVERLAY_PARTS` elenca solo `(ctx) => …` importate dai moduli; zoom raggruppato con `renderZoomGroup` in `zoom-in-out.js`.
- Regola descritta in [concepts/geo-map-controls-unification-rule.md](concepts/geo-map-controls-unification-rule.md).

## [2026-05-15] Ricerca indirizzo in `map/controls/search.js`

- Implementazione unica: logica Nominatim + `renderSearch`, `renderToggleButton`, `searchUiHandlers`.
- `map/search.js` resta shim di compatibilità; `renderSearchPanel` è alias deprecato di `renderSearch` (secondo argomento: `searchUiHandlers`).
- `toggleSearch` mette a fuoco l’input all’apertura; `showSearch === false` disabilita, valore assente = mappa pubblica con ricerca attiva.
- Wiki regola: [concepts/map-js-module-naming-rule.md](concepts/map-js-module-naming-rule.md).

## [2026-05-15] map/styles.js

- `resources/js/components/map/styles.js` è il modulo canonico per `mapStyles` e `mapStylesText`.
- `coordinate-picker-lit.js` importa `mapStylesText` da `./map/styles.js`, non `mapStylesText` da root.
- `map/styles.js` resta solo re-export deprecato per compatibilità con componenti legacy.
- Mirror Sixteen: `resources/js/components/modules/Geo/map/styles.js` re-export verso il modulo Geo.

## [2026-05-15] map/controls split

- `map/controls.js` è barrel; implementazione in `map/controls/{render-controls,fullscreen,zoom-in-out,geolocation,switch-layer}.js`.
- `map/resize-after-action.js` condiviso per invalidate dopo zoom/fullscreen/layer.

## [2026-05-15] map/heroicons.js

- Spostata implementazione icone da `geo-heroicons.js` a `map/heroicons.js`; root `geo-heroicons.js` è solo re-export deprecato.
- Mirror Sixteen: `map/heroicons.js` re-export da `@modules/Geo/...`.

## [2026-05-15] Map JS modules in `components/map/`

- Spostata logica condivisa in `resources/js/components/map/`: `controls.js`, `events.js`, `search.js`, `resize.js`, `utils.js`, `layers.js`.
- Import Lit: `./map/controls.js` (non più `map-picker-controls` in root).
- Regola aggiornata: [concepts/map-js-module-naming-rule.md](concepts/map-js-module-naming-rule.md).
- Mirror Sixteen: `resources/js/components/modules/Geo/map/`.

## [2026-05-13] Full Geocoding Payload contract

- Aggiunto `concepts/full-geocoding-payload.md` con il contratto del payload
  `location` (search + reverse-geocode salvano `raw`, `address_details`,
  `place_id`, `boundingbox`).
- `map-picker-search.js → buildLocationPayload()` flatten + raw.
- `coordinate-picker-lit.js _handleSearchSelection` accetta payload completo.
- `coordinate-picker.blade.php` spread payload e reverseGeocode senza
  perdere `raw`.
- `HasCoordinatePicker::reverseGeocode()` ora ritorna `address`,
  `provider`, `place_id`, `osm_*`, `licence`, `importance`, `type`,
  `class`, `boundingbox`, `address_details`, `raw`.
- `map-controls.js` (`requestGeolocation`) usa lo zoom configurato del
  picker (min 14) invece di hard-code 12.

## [2026-05-11] Wiki Structure Created

- Created wiki structure: rules/, skills/, commands/, memories/, concepts/
- Created INDEX.md for each section
- Created module index.md
- Ready for on-demand loading via QMD
