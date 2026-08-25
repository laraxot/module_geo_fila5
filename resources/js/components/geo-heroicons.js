import { html } from 'lit';
import { unsafeHTML } from 'lit/directives/unsafe-html.js';
import magnifyingGlassSvg from '../../svg/magnifying-glass.svg?raw';
import arrowsPointingOutSvg from '../../svg/arrows-pointing-out.svg?raw';
import arrowsPointingInSvg from '../../svg/arrows-pointing-in.svg?raw';
import mapPinSvg from '../../svg/map-pin.svg?raw';
import squares2x2Svg from '../../svg/squares-2x2.svg?raw';
import plusSvg from '../../svg/plus.svg?raw';
import minusSvg from '../../svg/minus.svg?raw';
import xMarkSvg from '../../svg/x-mark.svg?raw';

/**
 * geo-heroicons.js — "Filament way" icon system for Lit components.
 * Icons referenced by Heroicons name, mirroring <x-heroicon-o-NAME> Blade pattern.
 * SVG files loaded from ../../svg/ via Vite ?raw import.
 * Usage: geoIcon('magnifying-glass') → Lit html template
    'x-mark': html`${unsafeHTML(xMarkSvg)}`,
};

export function geoIcon(name) {
    return icons[name] ?? html``;
}
