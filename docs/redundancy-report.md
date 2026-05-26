# Redundancy Report – Geo Module

## 1. Duplicate Alpine Global Function `geoMapPickerField`
- **Definition 1:** `Modules/Geo/resources/js/filament/map-picker.js`
  - Registers `window.geoMapPickerField` and Alpine data `geoMapPickerField`.
- **Definition 2:** `Themes/Sixteen/resources/views/partials/alpine-livewire-bootstrap-header.blade.php`
  - Provides a shim `window.geoMapPickerField = function geoMapPickerFieldShim(config) { … }` to support legacy markup.
- **Impact:** Two sources of the same global function increase maintenance burden and risk of diverging logic.
- **Recommendation:** Consolidate the function in a shared JS module (e.g., `Modules/Geo/resources/js/geo-map-picker-field.js`) and import it both where needed. Remove the shim or replace it with a thin import.

## 2. Potential Refactoring
- Ensure the shared module is bundled in the theme via Vite so that only one copy is emitted.
- Update the Blade shim to reference the shared module (`import … from '@modules/geo/...';`).

*No other code-level redundancies were identified in the Geo module at this depth.*
