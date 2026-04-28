mport { geoIcon } from './geo-heroicons.js'/
import { LitElement, html, nothing } from 'lit';
mport { geoIcon } from './geo-heroicons.js'/
import { guard } from 'lit/directives/guard.js';
mport { geoIcon } from './geo-heroicons.js'/
import L from 'leaflet';
mport { geoIcon } from './geo-heroicons.js'/
import { mapPickerStyles } from './map-picker-styles.js';
mport { geoIcon } from './geo-heroicons.js'/
import { createMapPickerLeafletIcon } from './map-picker-marker-config.js';
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
/**
mport { geoIcon } from './geo-heroicons.js'/
 * PlacePickerLit
mport { geoIcon } from './geo-heroicons.js'/
 * ZEN: Simplified selection with readout.
mport { geoIcon } from './geo-heroicons.js'/
 * Implementation: Light DOM for stability and unified behavior.
mport { geoIcon } from './geo-heroicons.js'/
 */
mport { geoIcon } from './geo-heroicons.js'/
export class PlacePickerField extends LitElement {
mport { geoIcon } from './geo-heroicons.js'/
    static properties = {
mport { geoIcon } from './geo-heroicons.js'/
        latitude: { type: Number },
mport { geoIcon } from './geo-heroicons.js'/
        longitude: { type: Number },
mport { geoIcon } from './geo-heroicons.js'/
        zoom: { type: Number },
mport { geoIcon } from './geo-heroicons.js'/
        height: { type: String },
mport { geoIcon } from './geo-heroicons.js'/
        address: { type: String },
mport { geoIcon } from './geo-heroicons.js'/
    };
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    createRenderRoot() {
mport { geoIcon } from './geo-heroicons.js'/
        return this;
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    constructor() {
mport { geoIcon } from './geo-heroicons.js'/
        super();
mport { geoIcon } from './geo-heroicons.js'/
        this.latitude = null;
mport { geoIcon } from './geo-heroicons.js'/
        this.longitude = null;
mport { geoIcon } from './geo-heroicons.js'/
        this.zoom = 13;
mport { geoIcon } from './geo-heroicons.js'/
        this.height = '400px';
mport { geoIcon } from './geo-heroicons.js'/
        this.address = null;
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        this._map = null;
mport { geoIcon } from './geo-heroicons.js'/
        this._marker = null;
mport { geoIcon } from './geo-heroicons.js'/
        this._layers = {};
mport { geoIcon } from './geo-heroicons.js'/
        this._currentLayer = 'street';
mport { geoIcon } from './geo-heroicons.js'/
        this._mapReady = false;
mport { geoIcon } from './geo-heroicons.js'/
        this._loading = false;
mport { geoIcon } from './geo-heroicons.js'/
        this._isProgrammaticUpdate = false;
mport { geoIcon } from './geo-heroicons.js'/
        this._resizeObserver = null;
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    render() {
mport { geoIcon } from './geo-heroicons.js'/
        const isFullscreen = !!document.fullscreenElement;
mport { geoIcon } from './geo-heroicons.js'/
        const hasCoords = Number.isFinite(this.latitude) && Number.isFinite(this.longitude);
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        return html`
mport { geoIcon } from './geo-heroicons.js'/
            <style>
mport { geoIcon } from './geo-heroicons.js'/
                place-picker-lit { display: block; width: 100%; }
mport { geoIcon } from './geo-heroicons.js'/
                ${mapPickerStyles}
mport { geoIcon } from './geo-heroicons.js'/
                .place-picker-readout {
mport { geoIcon } from './geo-heroicons.js'/
                    display: flex;
mport { geoIcon } from './geo-heroicons.js'/
                    flex-wrap: wrap;
mport { geoIcon } from './geo-heroicons.js'/
                    align-items: center;
mport { geoIcon } from './geo-heroicons.js'/
                    gap: 12px;
mport { geoIcon } from './geo-heroicons.js'/
                    padding: 12px 16px;
mport { geoIcon } from './geo-heroicons.js'/
                    font-size: 11px;
mport { geoIcon } from './geo-heroicons.js'/
                    font-family: ui-monospace, monospace;
mport { geoIcon } from './geo-heroicons.js'/
                    background: #fff;
mport { geoIcon } from './geo-heroicons.js'/
                    border-top: 1px solid #e5e7eb;
mport { geoIcon } from './geo-heroicons.js'/
                }
mport { geoIcon } from './geo-heroicons.js'/
                .place-picker-readout__label {
mport { geoIcon } from './geo-heroicons.js'/
                    text-transform: uppercase;
mport { geoIcon } from './geo-heroicons.js'/
                    font-size: 9px;
mport { geoIcon } from './geo-heroicons.js'/
                    color: #6b7280;
mport { geoIcon } from './geo-heroicons.js'/
                    font-weight: 700;
mport { geoIcon } from './geo-heroicons.js'/
                }
mport { geoIcon } from './geo-heroicons.js'/
                .place-picker-readout__value--set { color: #2563eb; font-weight: 600; }
mport { geoIcon } from './geo-heroicons.js'/
                .layer-controls-overlay { display: flex !important; flex-direction: column !important; gap: 0.5rem !important; }
mport { geoIcon } from './geo-heroicons.js'/
            </style>
mport { geoIcon } from './geo-heroicons.js'/
            
mport { geoIcon } from './geo-heroicons.js'/
            <div class="map-container ${isFullscreen ? 'is-fullscreen' : ''}" style="--map-height: ${this.height}">
mport { geoIcon } from './geo-heroicons.js'/
                ${guard([], () => html`<div class="place-picker-leaflet-pane" style="height: 100%;"></div>`)}
mport { geoIcon } from './geo-heroicons.js'/
                
mport { geoIcon } from './geo-heroicons.js'/
                <div class="layer-controls-overlay">
mport { geoIcon } from './geo-heroicons.js'/
                    <button class="ctrl-btn" type="button" @click="${this._toggleFullscreen}" title="Fullscreen">
mport { geoIcon } from './geo-heroicons.js'/
                        ${geoIcon('arrows-pointing-out')}
mport { geoIcon } from './geo-heroicons.js'/
                    </button>
mport { geoIcon } from './geo-heroicons.js'/
                    <button class="ctrl-btn" type="button" @click="${() => this._handleGeolocation(true)}" title="Mia posizione">
mport { geoIcon } from './geo-heroicons.js'/
                        ${geoIcon('map-pin')}
mport { geoIcon } from './geo-heroicons.js'/
                    </button>
mport { geoIcon } from './geo-heroicons.js'/
                    <button class="ctrl-btn" type="button" @click="${this._switchLayer}" title="Cambia Layer">
mport { geoIcon } from './geo-heroicons.js'/
                        ${geoIcon('squares-2x2')}
mport { geoIcon } from './geo-heroicons.js'/
                    </button>
mport { geoIcon } from './geo-heroicons.js'/
                    <button class="ctrl-btn" type="button" @click="${() => this._map?.zoomIn()}" title="Zoom In">
mport { geoIcon } from './geo-heroicons.js'/
                        ${geoIcon('plus')}
mport { geoIcon } from './geo-heroicons.js'/
                    </button>
mport { geoIcon } from './geo-heroicons.js'/
                    <button class="ctrl-btn" type="button" @click="${() => this._map?.zoomOut()}" title="Zoom Out">
mport { geoIcon } from './geo-heroicons.js'/
                        ${geoIcon('minus')}
mport { geoIcon } from './geo-heroicons.js'/
                    </button>
mport { geoIcon } from './geo-heroicons.js'/
                </div>
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
                <div class="place-picker-readout">
mport { geoIcon } from './geo-heroicons.js'/
                    <div>
mport { geoIcon } from './geo-heroicons.js'/
                        <span class="place-picker-readout__label">Lat</span>
mport { geoIcon } from './geo-heroicons.js'/
                        <span class="place-picker-readout__value ${hasCoords ? 'place-picker-readout__value--set' : ''}">
mport { geoIcon } from './geo-heroicons.js'/
                            ${hasCoords ? this.latitude.toFixed(6) : '–'}
mport { geoIcon } from './geo-heroicons.js'/
                        </span>
mport { geoIcon } from './geo-heroicons.js'/
                    </div>
mport { geoIcon } from './geo-heroicons.js'/
                    <div>
mport { geoIcon } from './geo-heroicons.js'/
                        <span class="place-picker-readout__label">Lng</span>
mport { geoIcon } from './geo-heroicons.js'/
                        <span class="place-picker-readout__value ${hasCoords ? 'place-picker-readout__value--set' : ''}">
mport { geoIcon } from './geo-heroicons.js'/
                            ${hasCoords ? this.longitude.toFixed(6) : '–'}
mport { geoIcon } from './geo-heroicons.js'/
                        </span>
mport { geoIcon } from './geo-heroicons.js'/
                    </div>
mport { geoIcon } from './geo-heroicons.js'/
                    ${this.address ? html`<div>📍 ${this.address}</div>` : nothing}
mport { geoIcon } from './geo-heroicons.js'/
                </div>
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
                <div class="loading-overlay ${this._loading ? 'active' : ''}">
mport { geoIcon } from './geo-heroicons.js'/
                    <div class="spinner"></div>
mport { geoIcon } from './geo-heroicons.js'/
                </div>
mport { geoIcon } from './geo-heroicons.js'/
            </div>
mport { geoIcon } from './geo-heroicons.js'/
        `;
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    firstUpdated() {
mport { geoIcon } from './geo-heroicons.js'/
        this._initMap();
mport { geoIcon } from './geo-heroicons.js'/
        this._resizeObserver = new ResizeObserver(() => {
mport { geoIcon } from './geo-heroicons.js'/
            if (this._map) this._map.invalidateSize();
mport { geoIcon } from './geo-heroicons.js'/
        });
mport { geoIcon } from './geo-heroicons.js'/
        this._resizeObserver.observe(this);
mport { geoIcon } from './geo-heroicons.js'/
        document.addEventListener('fullscreenchange', () => this.requestUpdate());
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    disconnectedCallback() {
mport { geoIcon } from './geo-heroicons.js'/
        super.disconnectedCallback();
mport { geoIcon } from './geo-heroicons.js'/
        this._resizeObserver?.disconnect();
mport { geoIcon } from './geo-heroicons.js'/
        if (this._map) {
mport { geoIcon } from './geo-heroicons.js'/
            this._map.remove();
mport { geoIcon } from './geo-heroicons.js'/
            this._map = null;
mport { geoIcon } from './geo-heroicons.js'/
        }
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    updated(changed) {
mport { geoIcon } from './geo-heroicons.js'/
        if ((changed.has('latitude') || changed.has('longitude')) && !this._isProgrammaticUpdate) {
mport { geoIcon } from './geo-heroicons.js'/
            if (this._mapReady && this.latitude !== null && this.longitude !== null) {
mport { geoIcon } from './geo-heroicons.js'/
                this._syncMarkerToState(this.latitude, this.longitude);
mport { geoIcon } from './geo-heroicons.js'/
            }
mport { geoIcon } from './geo-heroicons.js'/
        }
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    _initMap() {
mport { geoIcon } from './geo-heroicons.js'/
        const el = this.querySelector('.place-picker-leaflet-pane');
mport { geoIcon } from './geo-heroicons.js'/
        if (!el || this._map) return;
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        const centerLat = this.latitude || 45.4654;
mport { geoIcon } from './geo-heroicons.js'/
        const centerLng = this.longitude || 12.3354;
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        this._map = L.map(el, {
mport { geoIcon } from './geo-heroicons.js'/
            center: [centerLat, centerLng],
mport { geoIcon } from './geo-heroicons.js'/
            zoom: this.zoom,
mport { geoIcon } from './geo-heroicons.js'/
            zoomControl: false,
mport { geoIcon } from './geo-heroicons.js'/
            attributionControl: false
mport { geoIcon } from './geo-heroicons.js'/
        });
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        this._layers.street = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(this._map);
mport { geoIcon } from './geo-heroicons.js'/
        this._layers.satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { maxZoom: 19 });
mport { geoIcon } from './geo-heroicons.js'/
        this._layers.topo = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', { maxZoom: 17 });
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        this._mapReady = true;
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        if (this.latitude !== null && this.longitude !== null) {
mport { geoIcon } from './geo-heroicons.js'/
            this._syncMarkerToState(this.latitude, this.longitude);
mport { geoIcon } from './geo-heroicons.js'/
        } else {
mport { geoIcon } from './geo-heroicons.js'/
            void this._handleGeolocation(false);
mport { geoIcon } from './geo-heroicons.js'/
        }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        this._map.on('click', (e) => this._handleInteraction(e.latlng.lat, e.latlng.lng));
mport { geoIcon } from './geo-heroicons.js'/
        setTimeout(() => this._map.invalidateSize(), 350);
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    _handleInteraction(lat, lng, emit = true) {
mport { geoIcon } from './geo-heroicons.js'/
        this._isProgrammaticUpdate = true;
mport { geoIcon } from './geo-heroicons.js'/
        this.latitude = parseFloat(lat.toFixed(6));
mport { geoIcon } from './geo-heroicons.js'/
        this.longitude = parseFloat(lng.toFixed(6));
mport { geoIcon } from './geo-heroicons.js'/
        this._syncMarkerToState(this.latitude, this.longitude);
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        if (emit) {
mport { geoIcon } from './geo-heroicons.js'/
            this.dispatchEvent(new CustomEvent('place-changed', {
mport { geoIcon } from './geo-heroicons.js'/
                detail: { latitude: this.latitude, longitude: this.longitude },
mport { geoIcon } from './geo-heroicons.js'/
                bubbles: true,
mport { geoIcon } from './geo-heroicons.js'/
                composed: true,
mport { geoIcon } from './geo-heroicons.js'/
            }));
mport { geoIcon } from './geo-heroicons.js'/
        }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        setTimeout(() => { this._isProgrammaticUpdate = false; }, 100);
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    _syncMarkerToState(lat, lng) {
mport { geoIcon } from './geo-heroicons.js'/
        if (!this._map) return;
mport { geoIcon } from './geo-heroicons.js'/
        if (!this._marker) {
mport { geoIcon } from './geo-heroicons.js'/
            this._marker = L.marker([lat, lng], { 
mport { geoIcon } from './geo-heroicons.js'/
                draggable: true,
mport { geoIcon } from './geo-heroicons.js'/
                icon: createMapPickerLeafletIcon(L) 
mport { geoIcon } from './geo-heroicons.js'/
            }).addTo(this._map);
mport { geoIcon } from './geo-heroicons.js'/
            this._marker.on('dragend', (e) => {
mport { geoIcon } from './geo-heroicons.js'/
                const pos = e.target.getLatLng();
mport { geoIcon } from './geo-heroicons.js'/
                this._handleInteraction(pos.lat, pos.lng);
mport { geoIcon } from './geo-heroicons.js'/
            });
mport { geoIcon } from './geo-heroicons.js'/
        } else {
mport { geoIcon } from './geo-heroicons.js'/
            this._marker.setLatLng([lat, lng]);
mport { geoIcon } from './geo-heroicons.js'/
        }
mport { geoIcon } from './geo-heroicons.js'/
        this._map.setView([lat, lng], this._map.getZoom());
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    _switchLayer() {
mport { geoIcon } from './geo-heroicons.js'/
        const layers = ['street', 'satellite', 'topo'];
mport { geoIcon } from './geo-heroicons.js'/
        const currentIndex = layers.indexOf(this._currentLayer);
mport { geoIcon } from './geo-heroicons.js'/
        const nextIndex = (currentIndex + 1) % layers.length;
mport { geoIcon } from './geo-heroicons.js'/
        const nextLayer = layers[nextIndex];
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        this._map.removeLayer(this._layers[this._currentLayer]);
mport { geoIcon } from './geo-heroicons.js'/
        if (!this._layers[nextLayer]._map) {
mport { geoIcon } from './geo-heroicons.js'/
            this._layers[nextLayer].addTo(this._map);
mport { geoIcon } from './geo-heroicons.js'/
        }
mport { geoIcon } from './geo-heroicons.js'/
        this._currentLayer = nextLayer;
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    async _handleGeolocation(emit = true) {
mport { geoIcon } from './geo-heroicons.js'/
        if (!navigator.geolocation) return;
mport { geoIcon } from './geo-heroicons.js'/
        this._loading = true;
mport { geoIcon } from './geo-heroicons.js'/
        this.requestUpdate();
mport { geoIcon } from './geo-heroicons.js'/
        return new Promise((resolve) => {
mport { geoIcon } from './geo-heroicons.js'/
            navigator.geolocation.getCurrentPosition(
mport { geoIcon } from './geo-heroicons.js'/
                (pos) => {
mport { geoIcon } from './geo-heroicons.js'/
                    this._handleInteraction(pos.coords.latitude, pos.coords.longitude, emit);
mport { geoIcon } from './geo-heroicons.js'/
                    if (this._map) this._map.setView([pos.coords.latitude, pos.coords.longitude], 16);
mport { geoIcon } from './geo-heroicons.js'/
                    this._loading = false;
mport { geoIcon } from './geo-heroicons.js'/
                    this.requestUpdate();
mport { geoIcon } from './geo-heroicons.js'/
                    resolve(true);
mport { geoIcon } from './geo-heroicons.js'/
                },
mport { geoIcon } from './geo-heroicons.js'/
                () => { this._loading = false; this.requestUpdate(); resolve(false); },
mport { geoIcon } from './geo-heroicons.js'/
                { enableHighAccuracy: true, timeout: 5000 }
mport { geoIcon } from './geo-heroicons.js'/
            );
mport { geoIcon } from './geo-heroicons.js'/
        });
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    _toggleFullscreen() {
mport { geoIcon } from './geo-heroicons.js'/
        const container = this.querySelector('.map-container');
mport { geoIcon } from './geo-heroicons.js'/
        if (!container) return;
mport { geoIcon } from './geo-heroicons.js'/
        if (document.fullscreenElement) {
mport { geoIcon } from './geo-heroicons.js'/
            document.exitFullscreen();
mport { geoIcon } from './geo-heroicons.js'/
        } else {
mport { geoIcon } from './geo-heroicons.js'/
            container.requestFullscreen();
mport { geoIcon } from './geo-heroicons.js'/
        }
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/
}
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
if (!customElements.get('place-picker-lit')) {
mport { geoIcon } from './geo-heroicons.js'/
    customElements.define('place-picker-lit', PlacePickerField);
mport { geoIcon } from './geo-heroicons.js'/
}