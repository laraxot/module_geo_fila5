import { LitElement, html, css } from 'lit';
import L from 'leaflet';

// Fix Leaflet icons (standard Laraxot Geo requirement)
import markerIcon from 'leaflet/dist/images/marker-icon.png';
import markerIcon2x from 'leaflet/dist/images/marker-icon-2x.png';
import markerShadow from 'leaflet/dist/images/marker-shadow.png';

import { injectCoordinatePickerStyles } from './coordinate-picker-styles.js';

injectCoordinatePickerStyles();

/**
 * CoordinatePickerLit - Stateless Web Component for Leaflet interactions.
 * 
 * Rules:
 * - Light DOM (compatible with Leaflet & global CSS).
 * - Stateless regarding Livewire (Emitter only).
 * - Local classes selection (no global IDs).
 */
export class CoordinatePickerLit extends LitElement {
    static properties = {
        latitude: { type: Number },
        longitude: { type: Number },
        zoom: { type: Number },
        height: { type: String },
        isExpanded: { type: Boolean, state: true },
        isLocating: { type: Boolean, state: true }
    };

    constructor() {
        super();
        this.latitude = null;
        this.longitude = null;
        this.zoom = 13;
        this.height = '400px';
        this.isExpanded = false;
        this.isLocating = false;
        
        this.map = null;
        this.marker = null;
        this.layers = {};
        this._isProgrammaticUpdate = false;
    }

    /**
     * Use Light DOM for Leaflet compatibility.
     */
    createRenderRoot() {
        return this;
    }

    firstUpdated() {
        this.initLeaflet();
    }

    disconnectedCallback() {
        super.disconnectedCallback();
        if (this.map) {
            this.map.remove();
            this.map = null;
        }
    }

    updated(changed) {
        if ((changed.has('latitude') || changed.has('longitude')) && !this._isProgrammaticUpdate) {
            this.syncMarkerToProperties();
        }
    }

    initLeaflet() {
        const mapContainer = this.querySelector('.coordinate-picker-map');
        if (!mapContainer || this.map) return;

        // Fix Leaflet icons
        delete L.Icon.Default.prototype._getIconUrl;
        L.Icon.Default.mergeOptions({
            iconRetinaUrl: markerIcon2x,
            iconUrl: markerIcon,
            shadowUrl: markerShadow,
        });

        const initialLat = this.latitude || 41.9028;
        const initialLng = this.longitude || 12.4964;

        this.map = L.map(mapContainer, {
            zoomControl: false,
            center: [initialLat, initialLng],
            zoom: this.zoom
        });

        this.layers.street = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(this.map);

        this.layers.satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri'
        });

        L.control.layers({
            "Mappa": this.layers.street,
            "Satellite": this.layers.satellite
        }, null, { position: 'topright' }).addTo(this.map);

        L.control.zoom({ position: 'bottomright' }).addTo(this.map);

        this.map.on('click', (e) => this.handleMapInteraction(e.latlng.lat, e.latlng.lng, 'click'));

        if (this.latitude !== null && this.longitude !== null) {
            this.updateMarker(this.latitude, this.longitude);
        }

        // Invalidate size in case of hidden container init
        setTimeout(() => this.map.invalidateSize(), 50);
    }

    handleMapInteraction(lat, lng, source = 'manual') {
        this._isProgrammaticUpdate = true;
        this.latitude = parseFloat(lat.toFixed(6));
        this.longitude = parseFloat(lng.toFixed(6));
        this.updateMarker(this.latitude, this.longitude);
        this.emitCoordsChanged(source);
        this._isProgrammaticUpdate = false;
    }

    updateMarker(lat, lng) {
        if (!this.map) return;

        if (!this.marker) {
            this.marker = L.marker([lat, lng], { draggable: true }).addTo(this.map);
            this.marker.on('dragend', (e) => {
                const pos = e.target.getLatLng();
                this.handleMapInteraction(pos.lat, pos.lng, 'drag');
            });
        } else {
            this.marker.setLatLng([lat, lng]);
        }
    }

    syncMarkerToProperties() {
        if (!this.map || this.latitude == null || this.longitude == null) return;
        this.updateMarker(this.latitude, this.longitude);
        this.map.setView([this.latitude, this.longitude], this.map.getZoom());
    }

    emitCoordsChanged(source) {
        this.dispatchEvent(new CustomEvent('coords-changed', {
            detail: {
                latitude: this.latitude,
                longitude: this.longitude,
                source: source
            },
            bubbles: true,
            composed: true
        }));
    }

    toggleFullscreen() {
        this.isExpanded = !this.isExpanded;
        // Wait for CSS transition/render
        setTimeout(() => {
            if (this.map) this.map.invalidateSize();
        }, 300);
    }

    requestGeolocation() {
        if (!navigator.geolocation) return;
        this.isLocating = true;
        navigator.geolocation.getCurrentPosition(
            (pos) => {
                this.handleMapInteraction(pos.coords.latitude, pos.coords.longitude, 'geolocation');
                if (this.map) this.map.setView([pos.coords.latitude, pos.coords.longitude], 16);
                this.isLocating = false;
            },
            () => { this.isLocating = false; },
            { enableHighAccuracy: true, timeout: 5000 }
        );
    }

    render() {
        return html`
            <div class="coordinate-picker-shell ${this.isExpanded ? 'is-expanded' : ''}">
                <div class="layer-controls-overlay">
                    <button type="button" class="ctrl-btn" @click="${this.requestGeolocation}" ?disabled="${this.isLocating}" title="Mia posizione">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M12 2v2m0 16v2M2 12h2m16 0h2"/></svg>
                    </button>
                    <button type="button" class="ctrl-btn" @click="${this.toggleFullscreen}" title="Espandi">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/></svg>
                    </button>
                </div>
                <div class="coordinate-picker-map" style="height: ${this.height}"></div>
            </div>
        `;
    }
}

if (!customElements.get('coordinate-picker-lit')) {
    customElements.define('coordinate-picker-lit', CoordinatePickerLit);
}
