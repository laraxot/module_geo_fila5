import { html } from 'lit';
import { unsafeHTML } from 'lit/directives/unsafe-html.js';
import magnifyingGlassSvg from '../../../svg/magnifying-glass.svg?raw';
import arrowsPointingOutSvg from '../../../svg/arrows-pointing-out.svg?raw';
import arrowsPointingInSvg from '../../../svg/arrows-pointing-in.svg?raw';
import mapPinSvg from '../../../svg/map-pin.svg?raw';
import squares2x2Svg from '../../../svg/squares-2x2.svg?raw';
import plusSvg from '../../../svg/plus.svg?raw';
import minusSvg from '../../../svg/minus.svg?raw';
import xMarkSvg from '../../../svg/x-mark.svg?raw';

/**
 * Heroicons for shared map controls (Lit).
 * SVG from Modules/Geo/resources/svg/ via Vite ?raw import.
 * Uses unsafeHTML() so Lit does not escape inline SVG markup.
 */
const icons = {
    'magnifying-glass': html`${unsafeHTML(magnifyingGlassSvg)}`,
    'arrows-pointing-out': html`${unsafeHTML(arrowsPointingOutSvg)}`,
    'arrows-pointing-in': html`${unsafeHTML(arrowsPointingInSvg)}`,
    'map-pin': html`${unsafeHTML(mapPinSvg)}`,
    'squares-2x2': html`${unsafeHTML(squares2x2Svg)}`,
    'plus': html`${unsafeHTML(plusSvg)}`,
    'minus': html`${unsafeHTML(minusSvg)}`,
    'x-mark': html`${unsafeHTML(xMarkSvg)}`,
};

export function geoIcon(name) {
    return icons[name] ?? html``;
}
