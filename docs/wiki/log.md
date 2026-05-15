---
title: "Geo Wiki Activity Log"
module: "Geo"
---

# Geo - Wiki Activity Log

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
- `map-picker-controls.js requestGeolocation` usa lo zoom configurato del
  picker (min 14) invece di hard-code 12.

## [2026-05-11] Wiki Structure Created

- Created wiki structure: rules/, skills/, commands/, memories/, concepts/
- Created INDEX.md for each section
- Created module index.md
- Ready for on-demand loading via QMD

