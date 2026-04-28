import { html } from 'lit';
import magnifyingGlassSvg from '../../svg/magnifying-glass.svg?raw';
import arrowsPointingOutSvg from '../../svg/arrows-pointing-out.svg?raw';
import arrowsPointingInSvg from '../../svg/arrows-pointing-in.svg?raw';
import mapPinSvg from '../../svg/map-pin.svg?raw';
import squares2x2Svg from '../../svg/squares-2x2.svg?raw';
import plusSvg from '../../svg/plus.svg?raw';
import minusSvg from '../../svg/minus.svg?raw';

/**
 * geo-heroicons.js — "Filament way" icon system for Lit components.
 * Icons referenced by Heroicons name, mirroring <x-heroicon-o-NAME> Blade pattern.
 * SVG files loaded from ../../svg/ via Vite ?raw import.
 * Usage: geoIcon('magnifying-glass') → Lit html template
 */
const icons = {
    'magnifying-glass': html`${magnifyingGlassSvg}`,
    'arrows-pointing-out': html`${arrowsPointingOutSvg}`,
    'arrows-pointing-in': html`${arrowsPointingInSvg}`,
    'map-pin': html`${mapPinSvg}`,
    'squares-2x2': html`${squares2x2Svg}`,
    'plus': html`${plusSvg}`,
    'minus': html`${minusSvg}`,
};

export function geoIcon(name) {
    return icons[name] ?? html``;
}
