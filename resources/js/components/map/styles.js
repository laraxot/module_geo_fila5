/**
 * Canonical map styles module (re-export hub).
 *
 * Side effect: imports Leaflet base CSS via map-styles-lit.js.
 * Rule: `Modules/Geo/docs/wiki/concepts/map-js-module-naming-rule.md`.
 */
import { geoIcon } from './heroicons.js';

export { mapStyles, mapStylesText } from './map-styles-lit.js';

// controlIcons: name mapping → geoIcon() in map/heroicons.js
// DEPRECATED: use geoIcon('name') directly in templates
export const controlIcons = {
    zoomIn: geoIcon('plus'),
    zoomOut: geoIcon('minus'),
    fullscreen: geoIcon('arrows-pointing-out'),
    fullscreenExit: geoIcon('arrows-pointing-in'),
    locate: geoIcon('map-pin'),
    layer: geoIcon('squares-2x2'),
    crosshair: geoIcon('map-pin'),
};
