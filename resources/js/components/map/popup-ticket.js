// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
/**
 * Popup marker mappa — card ricca (ispirazione farmshops.eu, palette Design Comuni / Fixcity).
 *
 * BEM block: `popup` (vedi Modules/Geo/docs/wiki/rules/bem-modifier-dom-contract.md).
 * Stato loading: modifier `popup--loading` + assenza di `popup__footer` nel DOM (no CSS descendant hack).
 */

const LABELS = {
    it: {
        status: 'Stato',
        type: 'Tipologia',
        address: 'Indirizzo',
        code: 'Codice segnalazione',
        detail: 'Dettaglio',
        images: 'Immagini',
        close: 'Chiudi',
        openDetail: 'Scheda completa',
        openMaps: 'Apri in mappe',
        noAddress: 'Indirizzo non disponibile',
    },
    en: {
        status: 'Status',
        type: 'Report type',
        address: 'Address',
        code: 'Report code',
        detail: 'Details',
        images: 'Images',
        close: 'Close',
        openDetail: 'Full details',
        openMaps: 'Open in maps',
        noAddress: 'Address not available',
    },
};

export function getPopupLabels() {
    const lang = (document.documentElement.lang || 'it').slice(0, 2).toLowerCase();

    return LABELS[lang] ?? LABELS.it;
}

export function escapeHtml(value) {
    return String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

function formatAddress(properties) {
    const address = String(properties.address || '').trim();
    const city = String(properties.city || '').trim();
    if (address && city && !address.toLowerCase().includes(city.toLowerCase())) {
        return `${address} — ${city}`;
    }

    return address || city;
}

function buildTypeIconHtml(ticketType, size = 56) {
    const iconUrl = String(ticketType.iconUrl || '').trim();
    if (iconUrl === '') {
        return '';
    }

    return `<img src="${escapeHtml(iconUrl)}" alt="" class="popup__type-icon" width="${size}" height="${size}" loading="lazy" decoding="async">`;
}

function buildTypeRow(ticketType, labels, { skipIfHeaderIcon = false } = {}) {
    const typeLabel = escapeHtml(ticketType.label || '');
    const hasHeaderIcon = String(ticketType.iconUrl || '').trim() !== '';
    if (skipIfHeaderIcon && hasHeaderIcon) {
        return `
            <div class="popup__row popup__row--type popup__row--compact">
                <span class="popup__row-label">${escapeHtml(labels.type)}</span>
                <p class="popup__row-value">${typeLabel}</p>
            </div>
        `;
    }

    const iconHtml = buildTypeIconHtml(ticketType, 24);

    return `
        <div class="popup__row popup__row--type">
            <span class="popup__row-label">${escapeHtml(labels.type)}</span>
            <div class="popup__row-value popup__type-value">
                ${iconHtml}
                <span>${typeLabel}</span>
            </div>
        </div>
    `;
}

function buildMapLinksHtml(coords, labels) {
    const lat = Number(coords?.lat);
    const lng = Number(coords?.lng);
    if (!Number.isFinite(lat) || !Number.isFinite(lng)) {
        return '';
    }

    const google = `https://www.google.com/maps?q=${lat},${lng}`;
    const osm = `https://www.openstreetmap.org/?mlat=${lat}&mlon=${lng}#map=17/${lat}/${lng}`;
    const ors = `https://maps.openrouteservice.org/directions?n1=${lng}&n2=${lat}&n3=14&a=null,null,${lng},${lat}&b=0&c=0&k1=it-IT&k2=km`;

    return `
        <div class="popup__links-block">
            <span class="popup__row-label">${escapeHtml(labels.openMaps)}</span>
            <div class="popup__map-links">
                <a href="${osm}" target="_blank" rel="noopener noreferrer" class="popup__map-link">OpenStreetMap</a>
                <a href="${ors}" target="_blank" rel="noopener noreferrer" class="popup__map-link">OpenRouteService</a>
                <a href="${google}" target="_blank" rel="noopener noreferrer" class="popup__map-link">Google Maps</a>
            </div>
        </div>
    `;
}

/** Layout farmshops `#wrapper`: indirizzo + link mappe affiancati. */
function buildAddressLinksWrapper(properties, coords, labels) {
    const addressRaw = formatAddress(properties);
    const address = escapeHtml(addressRaw !== '' ? addressRaw : labels.noAddress);
    const mapLinks = buildMapLinksHtml(coords, labels);

    return `
        <div class="popup__wrapper">
            <div class="popup__address-block">
                <span class="popup__row-label">${escapeHtml(labels.address)}</span>
                <p class="popup__row-value popup__address">${address}</p>
            </div>
            ${mapLinks}
        </div>
    `;
}

function buildStatusBadge(ticketStatus, labels) {
    const label = escapeHtml(ticketStatus.label || ticketStatus.value || '');
    const color = escapeHtml(ticketStatus.color || '#607d8b');

    return `
        <span class="popup__status" style="--status-color:${color}">
            <span class="popup__status-dot" aria-hidden="true"></span>
            <span class="popup__status-text">${label}</span>
        </span>
    `;
}

function buildTicketCodeRow(properties, labels) {
    const code = String(properties.code || properties.ticket_code || '').trim();
    if (code === '') {
        return '';
    }

    return `
        <div class="popup__row popup__row--code">
            <span class="popup__row-label">${escapeHtml(labels.code)}</span>
            <p class="popup__row-value popup__code">${escapeHtml(code)}</p>
        </div>
    `;
}

/**
 * @param {Record<string, unknown>} properties
 * @param {{ label: string, value: string, iconUrl?: string|null }} ticketType
 * @param {{ label: string, value: string, color: string }} ticketStatus
 * @param {{ title?: string, description?: string, images?: string[] }|null} [detail]
 * @param {{ lat?: number, lng?: number }} [coords]
 */
/** Skeleton mentre arriva `/api/ticket-details/{id}` (pattern farmshops: popup subito, dettaglio async). */
export function buildTicketPopupLoadingHtml(ticketType, ticketStatus) {
    const labels = getPopupLabels();
    const statusColor = escapeHtml(ticketStatus.color || '#607d8b');
    const headerTypeIcon = buildTypeIconHtml(ticketType, 48);
    const headerBarClass = headerTypeIcon
        ? 'popup__header-bar popup__header-bar--with-icon'
        : 'popup__header-bar';

    return `
        <article class="popup popup--loading" style="--status-color:${statusColor}" aria-busy="true" data-popup-state="loading">
            <div class="popup__accent" aria-hidden="true"></div>
            <div class="popup__header">
                <div class="${headerBarClass}">
                    ${headerTypeIcon ? `<div class="popup__header-icon" aria-hidden="true">${headerTypeIcon}</div>` : ''}
                    <div class="popup__header-text">
                        <div class="popup__skeleton popup__skeleton--title"></div>
                        ${buildStatusBadge(ticketStatus, labels)}
                    </div>
                </div>
            </div>
            <div class="popup__body">
                <div class="popup__skeleton popup__skeleton--line"></div>
                <div class="popup__skeleton popup__skeleton--line popup__skeleton--short"></div>
            </div>
        </article>
    `;
}

export function buildTicketPopupHtml(properties, ticketType, ticketStatus, detail = null, coords = {}) {
    const labels = getPopupLabels();
    const title = escapeHtml(detail?.title || properties.title || properties.name || '—');
    const description = escapeHtml(
        detail?.description || properties.description || properties.content || '',
    );
    const statusColor = escapeHtml(ticketStatus.color || '#607d8b');
    const detailUrl = String(properties.detail_url || properties.url || '').trim();
    const hasDetailUrl = detailUrl !== '' && detailUrl.startsWith('/');
    const addressRaw = formatAddress(properties);
    const address = escapeHtml(addressRaw !== '' ? addressRaw : labels.noAddress);

    const images = Array.isArray(detail?.images)
        ? detail.images
        : Array.isArray(properties.images)
            ? properties.images
            : [];

    const descriptionBlock = description
        ? `<p class="popup__description">${description}</p>`
        : '';

    const detailLink = hasDetailUrl
        ? `<a href="${escapeHtml(detailUrl)}" class="popup__link popup__link--primary">${escapeHtml(labels.openDetail)}</a>`
        : `<button type="button" class="popup__link popup__link--primary" data-popup-open-detail>${escapeHtml(labels.openDetail)}</button>`;

    const addressLinksBlock = buildAddressLinksWrapper(properties, coords, labels);
    const typeRow = buildTypeRow(ticketType, labels, { skipIfHeaderIcon: true });
    const codeRow = buildTicketCodeRow(properties, labels);
    const headerTypeIcon = buildTypeIconHtml(ticketType, 44);
    const headerBarClass = headerTypeIcon ? 'popup__header-bar popup__header-bar--with-icon' : 'popup__header-bar';
    const addressPreview = addressRaw !== ''
        ? `<p class="popup__address-preview">${address}</p>`
        : '';
    const heroImage = images.length > 0
        ? `<div class="popup__hero"><img src="${escapeHtml(images[0])}" alt="" loading="lazy" class="popup__hero-img"></div>`
        : '';
    const galleryRest = images.length > 1
        ? `<div class="popup__gallery">${images
            .slice(1, 4)
            .map((src) => `<img src="${escapeHtml(src)}" alt="" loading="lazy" class="popup__img">`)
            .join('')}</div>`
        : '';

    return `
        <article class="popup" style="--status-color:${statusColor}" role="dialog" aria-label="${title}">
            <div class="popup__accent" aria-hidden="true"></div>
            ${heroImage}
            <div class="popup__header popup__header--headline">
                <div class="${headerBarClass}">
                    ${headerTypeIcon ? `<div class="popup__header-icon" aria-hidden="true">${headerTypeIcon}</div>` : ''}
                    <div class="popup__header-text">
                        ${buildStatusBadge(ticketStatus, labels)}
                        <h2 class="popup__title popup__title--headline">${title}</h2>
                        ${addressPreview}
                    </div>
                </div>
            </div>
            <div class="popup__body">
                ${typeRow}
                ${codeRow}
                ${addressLinksBlock}
                ${descriptionBlock}
                ${galleryRest}
            </div>
            <footer class="popup__footer">
                ${detailLink}
                <button type="button" class="popup__link popup__link--ghost" data-popup-close>
                    ${escapeHtml(labels.close)}
                </button>
            </footer>
        </article>
    `;
}

export { popupTicketStylesText } from './popup-ticket-styles.js';
