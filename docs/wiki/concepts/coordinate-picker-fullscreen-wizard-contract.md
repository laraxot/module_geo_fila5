---
name: coordinate-picker-fullscreen-wizard-contract
description: Geo CoordinatePicker fullscreen contract inside wizard layouts
type: concept
---

# Coordinate Picker Fullscreen Wizard Contract

`coordinate-picker-lit` can be used inside Filament/Livewire wizard steps, including Fixcity `segnalazione-crea`.

Fullscreen requirements:

- no vertical page scrollbar while fullscreen is active;
- no wizard/sidebar panel above the map;
- Leaflet must call `invalidateSize()` after entering and leaving fullscreen;
- browser Fullscreen API is preferred, with CSS fixed-position fallback.

Implementation owner:

- JavaScript: `laravel/Modules/Geo/resources/js/components/coordinate-picker-lit.js`
- Theme CSS consumption: `laravel/Themes/Sixteen/resources/css/app.css`

Related theme document:

`laravel/Themes/Sixteen/docs/wiki/concepts/coordinate-picker-fullscreen-wizard-contract.md`
