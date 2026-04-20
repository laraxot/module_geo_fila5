import { LitElement, html } from '@theme-lit';
import L from '@theme-leaflet';
import { createMapPickerLeafletIcon } from './map-picker-marker-config';

/**
 * CoordinatePickerField - Core UI Component for geographic positioning.
 *
 * Rule: No IDs. Only class targeting.
 * Rule: Light DOM for Leaflet compatibility.
 */
export class CoordinatePickerField extends LitElement {
    static properties = {
        latitude: { type: Number },
        longitude: { type: Number },
        defaultLatitude: { type: Number, attribute: 'default-latitude' },
        defaultLongitude: { type: Number, attribute: 'default-longitude' },
        zoom: { type: Number },
        height: { type: String },
        isExpanded: { type: Boolean, attribute: 'is-expanded', reflect: true }
    };

    // Essential for Leaflet + CSS global access
    createRenderRoot() {
        return this;
    }

    constructor() {
        super();
        this.latitude = null;
        this.longitude = null;
        this.defaultLatitude = 41.9028;
        this.defaultLongitude = 12.4964;
        this.zoom = 15;
        this.height = '400px';
        this.isExpanded = false;

        this._map = null;
        this._marker = null;
        this._layers = {};
        this._mapReady = false;
        this._isProgrammaticUpdate = false;
        this._lastBodyOverflow = '';
        this._isLocating = false;
        this._geolocRequested = false; // GOLDEN RULE guard: auto-geolocate once on init when coords are null
        this._markerIcon = createMapPickerLeafletIcon(L);
    }

    hasCompleteCoordinates(lat = this.latitude, lng = this.longitude) {
        return Number.isFinite(lat) && Number.isFinite(lng);
    }

    shouldAutolocate(lat = this.latitude, lng = this.longitude) {
        // Permanent UX rule: if one coordinate is missing, treat the pair as invalid
        // and replace both values with the current browser position.
        return !this.hasCompleteCoordinates(lat, lng);
    }

    render() {
        return html`
            <div class="coordinate-picker-shell ${this.isExpanded ? 'is-expanded' : ''}" style="height: ${this.isExpanded ? '100vh' : this.height}; position: relative; border-radius: 0.5rem; overflow: hidden; border: 1px solid #e5e7eb;">
                <div class="coordinate-picker-map-canvas" style="width: 100%; height: 100%; background: #f3f4f6;"></div>
                
                <div class="coordinate-picker-toolbar" style="position: absolute; top: 12px; right: 12px; z-index: 1000; display: flex; flex-direction: column; gap: 8px;">
                    <button type="button" @click="${this.toggleExpand}" class="map-action-btn" title="${this.isExpanded ? 'Esci da schermo intero' : 'Schermo intero'}" aria-label="${this.isExpanded ? 'Esci da schermo intero' : 'Schermo intero'}">
                        ${this.isExpanded
                            ? html`<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M9 3H5v4M15 3h4v4M9 21H5v-4M15 21h4v-4"/></svg>`
                            : html`<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/></svg>`}
                    </button>
                    <button type="button" @click="${this.handleGeolocation}" class="map-action-btn" title="Usa posizione corrente" aria-label="Usa posizione corrente">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M12 2v3M12 19v3M2 12h3M19 12h3"></path>
                        </svg>
                    </button>
                </div>

                <style>
                    .map-action-btn {
                        background: white; border: 1px solid #d1d5db; border-radius: 6px; 
                        width: 44px; height: 44px; cursor: pointer; display: flex; align-items: center; justify-content: center;
                        font-size: 20px; transition: all 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.1);
                    }
                    .map-action-btn:hover { background: #f9fafb; transform: scale(1.05); border-color: #9ca3af; }
                    .map-action-btn svg {
                        width: 18px;
                        height: 18px;
                        stroke: #374151;
                    }
                    .coordinate-picker-shell.is-expanded {
                        position: fixed !important; inset: 0; width: 100vw !important; height: 100vh !important; z-index: 9999;
                        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
                        border-radius: 0 !important;
                    }
                    .coordinate-picker-shell .leaflet-control-zoom a {
                        width: 38px !important;
                        height: 38px !important;
                        line-height: 36px !important;
                        border: 1px solid #d1d5db !important;
                        border-radius: 6px !important;
                        background: #fff !important;
                        color: #111827 !important;
                        text-decoration: none !important;
                        box-shadow: 0 1px 3px rgba(0,0,0,0.1) !important;
                        font-size: 0 !important;
                        transition: all 0.2s;
                        position: relative;
                    }
                    .coordinate-picker-shell .leaflet-control-zoom a:hover {
                        background: #f9fafb !important;
                        border-color: #9ca3af !important;
                        transform: scale(1.05);
                    }
                    .coordinate-picker-shell .leaflet-control-zoom a + a {
                        margin-top: 8px;
                    }
                    .coordinate-picker-shell .leaflet-control-zoom {
                        border: 0 !important;
                        box-shadow: none !important;
                    }
                    .coordinate-picker-shell .leaflet-control-zoom a::before {
                        content: '';
                        position: absolute;
                        inset: 0;
                        margin: auto;
                        width: 18px;
                        height: 18px;
                        background-repeat: no-repeat;
                        background-position: center;
                        background-size: 18px 18px;
                    }
                    .coordinate-picker-shell .leaflet-control-zoom-in::before {
                        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23374151' stroke-width='2.4' stroke-linecap='round'%3E%3Cpath d='M12 5v14M5 12h14'/%3E%3C/svg%3E");
                    }
                    .coordinate-picker-shell .leaflet-control-zoom-out::before {
                        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23374151' stroke-width='2.4' stroke-linecap='round'%3E%3Cpath d='M5 12h14'/%3E%3C/svg%3E");
                    }
                </style>
            </div>
        `;
    }

    firstUpdated() {
        this.initMap();
        if (typeof ResizeObserver !== 'undefined') {
            this._resizeObserver = new ResizeObserver(() => this.invalidateSize());
            this._resizeObserver.observe(this);
        }
    }

    disconnectedCallback() {
        super.disconnectedCallback();
        if (this._resizeObserver) this._resizeObserver.disconnect();
        if (this.isExpanded) {
            document.body.style.overflow = this._lastBodyOverflow;
        }
        if (this._map) {
            this._map.remove();
            this._map = null;
        }
    }

    initMap() {
        const canvas = this.querySelector('.coordinate-picker-map-canvas');
        if (!canvas || this._map) return;

        const hasInitialCoordinates = this.hasCompleteCoordinates();
        const startLat = hasInitialCoordinates ? this.latitude : this.defaultLatitude;
        const startLng = hasInitialCoordinates ? this.longitude : this.defaultLongitude;

        this._map = L.map(canvas, {
            center: [startLat, startLng],
            zoom: this.zoom,
            zoomControl: true
        });

        this._layers.Street = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(this._map);

        this._layers.Satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: '&copy; Esri'
        });

        L.control.layers(this._layers, {}, { position: 'topleft' }).addTo(this._map);

        this._map.on('click', (e) => this.updateState(e.latlng.lat, e.latlng.lng, 'click'));

        if (hasInitialCoordinates) {
            this.ensureMarker(this.latitude, this.longitude);
        } else {
            this.ensureMarker(startLat, startLng);
            this.autolocateWhenCoordinatesMissing();
        }

        this._mapReady = true;
        this.invalidateSize();
    }

    applyExternalLocation(loc) {
        if (!this._mapReady) return;

        if (!loc) {
            // Permanent UX rule: missing server coords means "use current position".
            this.autolocateWhenCoordinatesMissing();
            return;
        }

        this._isProgrammaticUpdate = true;
        const lat = parseFloat(loc.latitude);
        const lng = parseFloat(loc.longitude);
        if (!this.shouldAutolocate(lat, lng)) {
            this.ensureMarker(lat, lng);
            this._map.setView([lat, lng], this._map.getZoom());
        } else {
            this.autolocateWhenCoordinatesMissing();
        }
        this._isProgrammaticUpdate = false;
    }

    autolocateWhenCoordinatesMissing() {
        // GOLDEN RULE: if (latitude == null || longitude == null) => getCurrentPosition()
        // Single-trigger guard: never request geolocation more than once per component lifecycle.
        if (!this.shouldAutolocate() || this._geolocRequested) return;
        this._geolocRequested = true;
        this._autoGeolocate();
    }

    _autoGeolocate() {
        if (!navigator.geolocation) return; // silent fallback — map stays centered on default
        navigator.geolocation.getCurrentPosition(
            (pos) => {
                this.updateState(pos.coords.latitude, pos.coords.longitude, 'geolocation-auto');
                this._map.setView([pos.coords.latitude, pos.coords.longitude], this.zoom);
            },
            () => {}, // denied — map stays on default center, no error shown
            { enableHighAccuracy: true, timeout: 5000, maximumAge: 60000 }
        );
    }

    updateState(lat, lng, source) {
        this.latitude = lat;
        this.longitude = lng;
        this.ensureMarker(lat, lng);
        if (source !== 'drag') {
            this._map.panTo([lat, lng]);
        }

        if (!this._isProgrammaticUpdate) {
            this.dispatchEvent(new CustomEvent('coords-changed', {
                detail: { latitude: lat, longitude: lng, source },
                bubbles: true,
                composed: true
            }));
        }
    }

    ensureMarker(lat, lng) {
        if (!this._marker) {
            this._marker = L.marker([lat, lng], {
                icon: this._markerIcon,
                draggable: true
            }).addTo(this._map);
            this._marker.on('dragend', () => {
                const pos = this._marker.getLatLng();
                this.updateState(pos.lat, pos.lng, 'drag');
            });
        } else {
            this._marker.setLatLng([lat, lng]);
        }
    }

    removeMarker() {
        if (this._marker) {
            this._marker.remove();
            this._marker = null;
        }
    }

    toggleExpand() {
        this.isExpanded = !this.isExpanded;

        if (this.isExpanded) {
            this._lastBodyOverflow = document.body.style.overflow;
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = this._lastBodyOverflow;
        }

        requestAnimationFrame(() => this.invalidateSize());
    }

    invalidateSize() {
        if (this._map) {
            setTimeout(() => this._map.invalidateSize({ animate: false }), 50);
        }
    }

    handleGeolocation() {
        if (this._isLocating || !navigator.geolocation) return;

        this._isLocating = true;
        navigator.geolocation.getCurrentPosition(
            (pos) => {
                this._isLocating = false;
                this.updateState(pos.coords.latitude, pos.coords.longitude, 'geolocation');
            },
            () => {
                this._isLocating = false;
                console.warn('Geolocation denied');
            },
            { enableHighAccuracy: true }
        );
    }
}

if (!customElements.get('coordinate-picker-field')) {
    customElements.define('coordinate-picker-field', CoordinatePickerField);
}
