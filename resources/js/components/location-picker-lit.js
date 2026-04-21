import { LitElement, html } from '@theme-lit';
import L from '@theme-leaflet';
import { locationPickerStyles } from './location-picker-lit-styles.js';

/**
 * LocationPickerLit - Minimalist UI Component for geographic coordinate selection.
 *
 * Architecture:
 * - KISS version of MapPickerLit.
 * - Optimized for simple coordinate selection without search/layers.
 * - Robust rendering via ResizeObserver.
 */
export class LocationPickerLit extends LitElement {
    static properties = {
        /** Selected latitude */
        latitude: { type: Number },
        /** Selected longitude */
        longitude: { type: Number },
        /** Default latitude if selection is null */
        defaultLatitude: { type: Number, attribute: 'default-latitude' },
        /** Default longitude if selection is null */
        defaultLongitude: { type: Number, attribute: 'default-longitude' },
        zoom: { type: Number },
        height: { type: String },
    };

    static styles = locationPickerStyles;

    constructor() {
        super();
        this.latitude = null;
        this.longitude = null;
        this.defaultLatitude = 41.9028;
        this.defaultLongitude = 12.4964;
        this.zoom = 13;
        this.height = '300px';

        this._map = null;
        this._marker = null;
        this._mapReady = false;
        this._resizeObserver = null;
        this._initRaf = null;
        this._pendingLocation = null;
    }

    render() {
        return html`
            <div class="lp-map-shell" style="--lp-map-height: ${this.height};">
                <div class="lp-leaflet-pane" part="map"></div>
            </div>
        `;
    }

    firstUpdated() {
        if (typeof ResizeObserver !== 'undefined') {
            this._resizeObserver = new ResizeObserver(() => this._handleResize());
            this._resizeObserver.observe(this);
        }
        requestAnimationFrame(() => this._handleResize());
    }

    updated(changed) {
        if (changed.has('height')) {
            this.invalidateSize();
        }
    }

    disconnectedCallback() {
        super.disconnectedCallback();
        if (this._resizeObserver) this._resizeObserver.disconnect();
        if (this._initRaf) cancelAnimationFrame(this._initRaf);
        if (this._map) {
            this._map.remove();
            this._map = null;
        }
    }

    applyExternalLocation(loc) {
        const normalized = this._normalizeLocation(loc);

        if (!this._mapReady) {
            this._pendingLocation = normalized;
            return;
        }

        if (!normalized) {
            this._removeMarker();
            return;
        }

        this._updateInternal(normalized.latitude, normalized.longitude, false);
    }

    invalidateSize() {
        if (this._map) {
            setTimeout(() => this._map.invalidateSize({ animate: false }), 50);
        }
    }

    _handleResize() {
        const rect = this.getBoundingClientRect();
        if (rect.width <= 0 || rect.height <= 0) return;

        if (!this._map) {
            if (this._initRaf) cancelAnimationFrame(this._initRaf);
            this._initRaf = requestAnimationFrame(() => {
                this._initRaf = null;
                this._initMap();
            });
        } else {
            this._map.invalidateSize({ animate: false });
        }
    }

    _initMap() {
        if (this._map) return;

        const el = this.renderRoot.querySelector('.lp-leaflet-pane');
        if (!el || el._leaflet_id) return;

        const centerLat = Number(this.latitude ?? this.defaultLatitude);
        const centerLng = Number(this.longitude ?? this.defaultLongitude);

        this._map = L.map(el, {
            center: [centerLat, centerLng],
            zoom: this.zoom,
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap',
            maxZoom: 19,
        }).addTo(this._map);

        this._map.on('click', (e) => this._updateInternal(e.latlng.lat, e.latlng.lng, true, 'click'));

        this._mapReady = true;

        const initialLoc = this._pendingLocation || this._normalizeLocation({ latitude: this.latitude, longitude: this.longitude });
        this._pendingLocation = null;

        if (initialLoc) {
            this._updateInternal(initialLoc.latitude, initialLoc.longitude, false);
        }

        this.invalidateSize();
    }

    _updateInternal(lat, lng, emit = true, source = 'external') {
        if (!this._map) return;

        if (!this._marker) {
            this._marker = L.marker([lat, lng], { draggable: true }).addTo(this._map);
            this._marker.on('dragend', () => {
                const pos = this._marker.getLatLng();
                this._updateInternal(pos.lat, pos.lng, true, 'drag');
            });
        } else {
            this._marker.setLatLng([lat, lng]);
        }

        if (source !== 'drag') {
            this._map.setView([lat, lng], this._map.getZoom(), { animate: source !== 'click' });
        }

        if (emit) {
            this.dispatchEvent(new CustomEvent('location-changed', {
                detail: { latitude: lat, longitude: lng, source },
                bubbles: true,
                composed: true,
            }));
        }
    }

    _removeMarker() {
        if (this._marker) {
            this._marker.remove();
            this._marker = null;
        }
    }

    _normalizeLocation(loc) {
        if (!loc || typeof loc !== 'object') return null;
        const lat = Number(loc.latitude ?? loc.lat);
        const lng = Number(loc.longitude ?? loc.lng);
        return (Number.isFinite(lat) && Number.isFinite(lng)) ? { latitude: lat, longitude: lng } : null;
    }
}

if (!customElements.get('location-picker-lit')) {
    customElements.define('location-picker-lit', LocationPickerLit);
}
