const SAFE_HEX_COLOR = /^#[0-9a-f]{3}([0-9a-f]{3})?$/i;

export function normalizeGeoMapColor(color, fallback = '#0066cc') {
    return SAFE_HEX_COLOR.test(String(color || '')) ? color : fallback;
}

/**
 * @param {string | null | undefined} iconUrl Public path from AssetAction (e.g. /assets/ui/svg/wrench.svg)
 */
function sanitizeIconUrl(iconUrl) {
    const url = String(iconUrl || '').trim();
    if (url === '' || !url.startsWith('/') || /["'<>]/.test(url)) {
        return null;
    }

    return url;
}

/**
 * Pin Leaflet con colore tipo ticket e glifo Heroicon locale (type_icon_url da GeoJSON).
 */
export function createGeoMapLeafletIcon(L, color = '#0066cc', iconUrl = null) {
    const fill = normalizeGeoMapColor(color);
    const safeUrl = sanitizeIconUrl(iconUrl);

    const glyph = safeUrl
        ? `<img src="${safeUrl}" alt="" class="geo-map-marker-glyph" width="14" height="14" loading="lazy" decoding="async" />`
        : '';

    return L.divIcon({
        html: `<div class="geo-map-marker-pin" aria-hidden="true">
            <svg viewBox="0 0 32 45" width="32" height="45" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 0C7.163 0 0 7.163 0 16c0 10 16 29 16 29S32 26 32 16C32 7.163 24.837 0 16 0z"
                      fill="${fill}" stroke="#fff" stroke-width="1.5"/>
                <circle cx="16" cy="16" r="7" fill="#fff"/>
            </svg>
            ${safeUrl ? `<div class="geo-map-marker-glyph-wrap">${glyph}</div>` : ''}
        </div>`,
        className: 'geo-map-marker-wrapper',
        iconSize: [32, 45],
        iconAnchor: [16, 45],
        popupAnchor: [0, -46],
    });
}
