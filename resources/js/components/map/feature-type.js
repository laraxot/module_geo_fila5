const SAFE_HEX_COLOR = /^#[0-9a-f]{3}([0-9a-f]{3})?$/i;

function normalizeColor(color, fallback = '#607d8b') {
    return SAFE_HEX_COLOR.test(String(color || '')) ? String(color) : fallback;
}

/**
 * Contratto GeoJSON properties.type (oggetto annidato).
 * Supporta brevemente il formato flat legacy (type string + type_label, …).
 *
 * @param {Record<string, unknown>} properties
 * @returns {{ value: string, label: string, color: string, icon: string, iconUrl: string|null }}
 */
export function resolveFeatureTicketType(properties = {}) {
    const nested = properties.type && typeof properties.type === 'object' ? properties.type : null;

    if (nested) {
        const value = String(nested.value ?? 'other');

        return {
            value,
            label: String(nested.label ?? value),
            color: normalizeColor(nested.color),
            icon: String(nested.icon ?? ''),
            iconUrl: nested.iconUrl ?? nested.icon_url ?? null,
        };
    }

    const value = typeof properties.type === 'string' ? properties.type : 'other';

    return {
        value,
        label: String(properties.type_label ?? value),
        color: normalizeColor(properties.type_color),
        icon: String(properties.type_icon ?? ''),
        iconUrl: properties.type_icon_url ?? null,
    };
}
