import { LitElement, html } from 'lit';
import { guard } from 'lit/directives/guard.js';
import L from 'leaflet';
import { mapPickerStyles, controlIcons } from './map-picker-styles.js';
import { createMapPickerLeafletIcon } from './map-picker-marker-config.js';

/**
 * MapPositionerLit
 * ZEN: Stateless UI Component for geographic positioning.
 * Implementation: Light DOM for stability and unified behavior.
 */
export class MapPositionerLit extends LitElement {
    static properties = {
        latitude: { type: Number },
        longitude: { type: Number },
        defaultLatitude: { type: Number, attribute: 'default-latitude' },
        defaultLongitude: { type: Number, attribute: 'default-longitude' },
        zoom: { type: Number },
        height: { type: String },
        showSearch: { type: Boolean, attribute: 'show-search' },
    };

    createRenderRoot() {
        return this;
    }

    constructor() {
        super();
        this.latitude = null;
        this.longitude = null;
        this.defaultLatitude = 41.9028;
        this.defaultLongitude = 12.4964;
        this.zoom = 13;
        this.height = '400px';
        this.showSearch = true;

        this._map = null;
        this._marker = null;
        this._layers = {};
        this._mapReady = false;
        this._loading = false;
        this._isProgrammaticUpdate = false;
        this._resizeObserver = null;
        this._pendingLocation = null;
    }

    render() {
        const isFullscreen = !!document.fullscreenElement;
        
        return html`
            <style>
                map-positioner-lit { display: block; width: 100%; }
                ${mapPickerStyles}
                .layer-controls-overlay { display: flex !important; flex-direction: column !important; gap: 0.5rem !important; }
                .ctrl-btn svg { width: 1.5rem; height: 1.5rem; color: #374151; }
                .ctrl-btn:hover svg { color: #ef4444; }
            </style>
            <div class="map-container ${isFullscreen ? 'is-fullscreen' : ''}" style="--map-height: ${this.height}">
                
                ${guard([], () => html`<div class="map-picker-leaflet-pane" style="height: 100%;"></div>`)}
                
                ${this.showSearch ? this._renderSearch() : ''}
                
                <div class="layer-controls-overlay">
                    <button class="ctrl-btn" type="button" @click="${this._handleGeolocation}" title="Mia posizione">
                        ${controlIcons.locate}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${() => this._map?.zoomIn()}" title="Zoom In">
                        ${controlIcons.zoomIn}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${() => this._map?.zoomOut()}" title="Zoom Out">
                        ${controlIcons.zoomOut}
                    </button>
                </div>

                <div class="loading-overlay ${this._loading ? 'active' : ''}">
                    <div class="spinner"></div>
                </div>
            </div>
        `;
    }

    _renderSearch() {
        return html`
            <div class="search-box">
                <input
                    type="text"
                    class="map-picker-search-input"
                    placeholder="Cerca indirizzo..."
                    @keydown="${(e) => e.key === 'Enter' && this._handleSearch()}"
                    autocomplete="off"
                />
                <button class="ctrl-btn" @click="${this._handleSearch}" type="button" aria-label="Cerca">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        `;
    }

    firstUpdated() {
        this._initMap();
        this._resizeObserver = new ResizeObserver(() => {
            if (this._map) this._map.invalidateSize();
        });
        this._resizeObserver.observe(this);
        
        document.addEventListener('fullscreenchange', () => this.requestUpdate());
    }

    disconnectedCallback() {
        super.disconnectedCallback();
        this._resizeObserver?.disconnect();
        if (this._map) {
            this._map.remove();
            this._map = null;
        }
    }

    updated(changed) {
        if ((changed.has('latitude') || changed.has('longitude')) && !this._isProgrammaticUpdate) {
            if (this._mapReady && this.latitude !== null && this.longitude !== null) {
                this._syncMarkerToState(this.latitude, this.longitude);
            }
        }
    }

    _initMap() {
        const el = this.querySelector('.map-picker-leaflet-pane');
        if (!el || this._map) return;

        const centerLat = Number(this.latitude ?? this.defaultLatitude);
        const centerLng = Number(this.longitude ?? this.defaultLongitude);

        this._map = L.map(el, {
            center: [centerLat, centerLng],
            zoom: this.zoom,
            zoomControl: false,
            attributionControl: false
        });

        this._layers.street = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(this._map);

        this._map.on('click', (e) => this._handleInteraction(e.latlng.lat, e.latlng.lng, 'click'));

        this._mapReady = true;
        
        if (this.latitude !== null && this.longitude !== null) {
            this._syncMarkerToState(this.latitude, this.longitude);
        } else {
            void this._handleGeolocation(false);
        }

        setTimeout(() => this._map.invalidateSize(), 350);
    }

    _handleInteraction(lat, lng, source = 'manual') {
        this._isProgrammaticUpdate = true;
        this.latitude = parseFloat(lat.toFixed(6));
        this.longitude = parseFloat(lng.toFixed(6));
        
        this._syncMarkerToState(this.latitude, this.longitude);

        this.dispatchEvent(new CustomEvent('position-changed', {
            detail: { latitude: this.latitude, longitude: this.longitude, source },
            bubbles: true,
            composed: true,
        }));

        setTimeout(() => { this._isProgrammaticUpdate = false; }, 100);
    }

    _syncMarkerToState(lat, lng) {
        if (!this._map) return;
        if (!this._marker) {
            this._marker = L.marker([lat, lng], { 
                draggable: true,
                icon: createMapPickerLeafletIcon(L) 
            }).addTo(this._map);
            this._marker.on('dragend', (e) => {
                const pos = e.target.getLatLng();
                this._handleInteraction(pos.lat, pos.lng, 'drag');
            });
        } else {
            this._marker.setLatLng([lat, lng]);
        }
        this._map.setView([lat, lng], this._map.getZoom());
    }

    async _handleSearch() {
        const input = this.querySelector('.map-picker-search-input');
        if (!input?.value) return;
        this._loading = true;
        this.requestUpdate();
        try {
            const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(input.value)}&limit=1`);
            const data = await res.json();
            if (data?.[0]) {
                const lat = parseFloat(data[0].lat);
                const lon = parseFloat(data[0].lon);
                this._handleInteraction(lat, lon, 'search');
                this._map?.setView([lat, lon], 16);
            }
        } finally {
            this._loading = false;
            this.requestUpdate();
        }
    }

    async _handleGeolocation(emit = true) {
        if (!navigator.geolocation) return;
        this._loading = true;
        this.requestUpdate();
        return new Promise((resolve) => {
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    this._handleInteraction(pos.coords.latitude, pos.coords.longitude, 'geolocation');
                    if (this._map) this._map.setView([pos.coords.latitude, pos.coords.longitude], 16);
                    this._loading = false;
                    this.requestUpdate();
                    resolve(true);
                },
                () => { this._loading = false; this.requestUpdate(); resolve(false); },
                { enableHighAccuracy: true, timeout: 5000 }
            );
        });
    }
}

if (!customElements.get('map-positioner-lit')) {
    customElements.define('map-positioner-lit', MapPositionerLit);
}
