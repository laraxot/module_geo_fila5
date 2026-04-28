import { geoIcon } from './geo-heroicons.js'/
import { LitElement, html } from 'lit';
mport { geoIcon } from './geo-heroicons.js'/
import { guard } from 'lit/directives/guard.js';
mport { geoIcon } from './geo-heroicons.js'/
import L from 'leaflet';
mport { geoIcon } from './geo-heroicons.js'/
import { mapPickerStyles } from './map-picker-styles.js';
mport { geoIcon } from './geo-heroicons.js'/
import { createMapPickerLeafletIcon } from './map-picker-marker-config.js';
mport { geoIcon } from './geo-heroicons.js'/
import 'leaflet/dist/leaflet.css';
mport { geoIcon } from './geo-heroicons.js'/
/**
mport { geoIcon } from './geo-heroicons.js'/
 * LocationPickerLit
mport { geoIcon } from './geo-heroicons.js'/
 * ZEN: Standardized geographical picker with address support.
mport { geoIcon } from './geo-heroicons.js'/
 * Implementation: Light DOM for stability in dynamic/wizard contexts.
mport { geoIcon } from './geo-heroicons.js'/
 * Logic: Stateless UI, synchronization via coordinates-changed event.
mport { geoIcon } from './geo-heroicons.js'/
 */
mport { geoIcon } from './geo-heroicons.js'/
export class LocationPickerLit extends LitElement {
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
        isLocating: { type: Boolean, state: true },
mport { geoIcon } from './geo-heroicons.js'/
        isFullscreen: { type: Boolean, state: true },
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
        this.latitude = 41.9028;
mport { geoIcon } from './geo-heroicons.js'/
        this.longitude = 12.4964;
mport { geoIcon } from './geo-heroicons.js'/
        this.zoom = 13;
mport { geoIcon } from './geo-heroicons.js'/
        this.height = '400px';
mport { geoIcon } from './geo-heroicons.js'/
        this.address = '';
mport { geoIcon } from './geo-heroicons.js'/
        this.isLocating = false;
mport { geoIcon } from './geo-heroicons.js'/
        this.isFullscreen = false;
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        this._map = null;
mport { geoIcon } from './geo-heroicons.js'/
        this._marker = null;
mport { geoIcon } from './geo-heroicons.js'/
        this._isProgrammaticUpdate = false;
mport { geoIcon } from './geo-heroicons.js'/
        this._resizeObserver = null;
mport { geoIcon } from './geo-heroicons.js'/
        this._currentLayer = 'street';
mport { geoIcon } from './geo-heroicons.js'/
        this._layers = {};
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    render() {
mport { geoIcon } from './geo-heroicons.js'/
        return html`
mport { geoIcon } from './geo-heroicons.js'/
            <style>
mport { geoIcon } from './geo-heroicons.js'/
                location-picker-lit { display: block; width: 100%; }
mport { geoIcon } from './geo-heroicons.js'/
                ${mapPickerStyles}
mport { geoIcon } from './geo-heroicons.js'/
                .layer-controls-overlay { display: flex !important; flex-direction: column !important; gap: 0.5rem !important; }
mport { geoIcon } from './geo-heroicons.js'/
                .ctrl-btn svg { width: 1.5rem; height: 1.5rem; color: #374151; }
mport { geoIcon } from './geo-heroicons.js'/
                .ctrl-btn:hover svg { color: #ef4444; }
mport { geoIcon } from './geo-heroicons.js'/
                .close-fullscreen-btn { background: #ef4444 !important; color: white !important; }
mport { geoIcon } from './geo-heroicons.js'/
            </style>
mport { geoIcon } from './geo-heroicons.js'/
                        
mport { geoIcon } from './geo-heroicons.js'/
            <div class="map-container ${this.isFullscreen ? 'is-fullscreen' : ''}" style="--map-height: ${this.height}">
mport { geoIcon } from './geo-heroicons.js'/
                
mport { geoIcon } from './geo-heroicons.js'/
                ${guard([], () => html`<div class="map-picker-leaflet-pane" style="height: 100%;"></div>`)}
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
                <div class="layer-controls-overlay">
mport { geoIcon } from './geo-heroicons.js'/
                     ${this.isFullscreen ? html`
mport { geoIcon } from './geo-heroicons.js'/
                        <button class="ctrl-btn close-fullscreen-btn" type="button" @click="${this._toggleFullscreen}" title="Chiudi">
mport { geoIcon } from './geo-heroicons.js'/
                             <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
mport { geoIcon } from './geo-heroicons.js'/
                        </button>
mport { geoIcon } from './geo-heroicons.js'/
                    ` : html`
mport { geoIcon } from './geo-heroicons.js'/
                        <button class="ctrl-btn" type="button" @click="${this._toggleFullscreen}" title="Fullscreen">
mport { geoIcon } from './geo-heroicons.js'/
                            ${geoIcon('arrows-pointing-out')}
mport { geoIcon } from './geo-heroicons.js'/
                        </button>
mport { geoIcon } from './geo-heroicons.js'/
                    `}
mport { geoIcon } from './geo-heroicons.js'/
                    
mport { geoIcon } from './geo-heroicons.js'/
                    <button class="ctrl-btn" type="button" @click="${this._handleGeolocation}" ?disabled="${this.isLocating}" title="Mia posizione">
mport { geoIcon } from './geo-heroicons.js'/
                        ${this.isLocating 
mport { geoIcon } from './geo-heroicons.js'/
                            ? html`<svg class="animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" opacity=".25"/><path d="M4 12a8 8 0 018-8" opacity=".75"/></svg>`
mport { geoIcon } from './geo-heroicons.js'/
                            : geoIcon('map-pin')
mport { geoIcon } from './geo-heroicons.js'/
                        }
mport { geoIcon } from './geo-heroicons.js'/
                    </button>
mport { geoIcon } from './geo-heroicons.js'/
                    
mport { geoIcon } from './geo-heroicons.js'/
                    <button class="ctrl-btn" type="button" @click="${this._switchLayer}" title="Cambia Layer">
mport { geoIcon } from './geo-heroicons.js'/
                        ${geoIcon('squares-2x2')}
mport { geoIcon } from './geo-heroicons.js'/
                    </button>
mport { geoIcon } from './geo-heroicons.js'/
                    
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
                <div class="loading-overlay ${this.isLocating ? 'active' : ''}">
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
            if (this._map) setTimeout(() => this._map.invalidateSize(), 350);
mport { geoIcon } from './geo-heroicons.js'/
        });
mport { geoIcon } from './geo-heroicons.js'/
        this._resizeObserver.observe(this);
mport { geoIcon } from './geo-heroicons.js'/
        
mport { geoIcon } from './geo-heroicons.js'/
        document.addEventListener('keydown', (e) => {
mport { geoIcon } from './geo-heroicons.js'/
            if (e.key === 'Escape' && this.isFullscreen) this._toggleFullscreen();
mport { geoIcon } from './geo-heroicons.js'/
        });
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    disconnectedCallback() {
mport { geoIcon } from './geo-heroicons.js'/
        super.disconnectedCallback();
mport { geoIcon } from './geo-heroicons.js'/
        if (this._map) {
mport { geoIcon } from './geo-heroicons.js'/
            this._map.remove();
mport { geoIcon } from './geo-heroicons.js'/
            this._map = null;
mport { geoIcon } from './geo-heroicons.js'/
        }
mport { geoIcon } from './geo-heroicons.js'/
        this._resizeObserver?.disconnect();
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    updated(changed) {
mport { geoIcon } from './geo-heroicons.js'/
        if ((changed.has('latitude') || changed.has('longitude')) && !this._isProgrammaticUpdate) {
mport { geoIcon } from './geo-heroicons.js'/
            this._syncMarkerToState();
mport { geoIcon } from './geo-heroicons.js'/
        }
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    _initMap() {
mport { geoIcon } from './geo-heroicons.js'/
        const el = this.querySelector('.map-picker-leaflet-pane');
mport { geoIcon } from './geo-heroicons.js'/
        if (!el || this._map) return;
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        this._map = L.map(el, {
mport { geoIcon } from './geo-heroicons.js'/
            center: [this.latitude, this.longitude],
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
        this._map.on('click', (e) => this._handleInteraction(e.latlng.lat, e.latlng.lng, 'click'));
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        this._syncMarkerToState();
mport { geoIcon } from './geo-heroicons.js'/
        setTimeout(() => this._map.invalidateSize(), 350);
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    _handleInteraction(lat, lng, source = 'manual') {
mport { geoIcon } from './geo-heroicons.js'/
        this._isProgrammaticUpdate = true;
mport { geoIcon } from './geo-heroicons.js'/
        this.latitude = parseFloat(lat.toFixed(6));
mport { geoIcon } from './geo-heroicons.js'/
        this.longitude = parseFloat(lng.toFixed(6));
mport { geoIcon } from './geo-heroicons.js'/
        
mport { geoIcon } from './geo-heroicons.js'/
        this._syncMarkerToState();
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        this.dispatchEvent(new CustomEvent('location-changed', {
mport { geoIcon } from './geo-heroicons.js'/
            detail: { latitude: this.latitude, longitude: this.longitude, source },
mport { geoIcon } from './geo-heroicons.js'/
            bubbles: true,
mport { geoIcon } from './geo-heroicons.js'/
            composed: true,
mport { geoIcon } from './geo-heroicons.js'/
        }));
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        setTimeout(() => { this._isProgrammaticUpdate = false; }, 100);
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    _syncMarkerToState() {
mport { geoIcon } from './geo-heroicons.js'/
        if (!this._map) return;
mport { geoIcon } from './geo-heroicons.js'/
        if (!this._marker) {
mport { geoIcon } from './geo-heroicons.js'/
            this._marker = L.marker([this.latitude, this.longitude], { 
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
                this._handleInteraction(pos.lat, pos.lng, 'drag');
mport { geoIcon } from './geo-heroicons.js'/
            });
mport { geoIcon } from './geo-heroicons.js'/
        } else {
mport { geoIcon } from './geo-heroicons.js'/
            this._marker.setLatLng([this.latitude, this.longitude]);
mport { geoIcon } from './geo-heroicons.js'/
        }
mport { geoIcon } from './geo-heroicons.js'/
        this._map.setView([this.latitude, this.longitude], this._map.getZoom());
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
    _toggleFullscreen() {
mport { geoIcon } from './geo-heroicons.js'/
        this.isFullscreen = !this.isFullscreen;
mport { geoIcon } from './geo-heroicons.js'/
        if (this.isFullscreen) {
mport { geoIcon } from './geo-heroicons.js'/
            document.body.style.overflow = 'hidden';
mport { geoIcon } from './geo-heroicons.js'/
        } else {
mport { geoIcon } from './geo-heroicons.js'/
            document.body.style.overflow = '';
mport { geoIcon } from './geo-heroicons.js'/
        }
mport { geoIcon } from './geo-heroicons.js'/
        this.dispatchEvent(new CustomEvent('fullscreen-changed', {
mport { geoIcon } from './geo-heroicons.js'/
            detail: { isFullscreen: this.isFullscreen },
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
    async _handleGeolocation() {
mport { geoIcon } from './geo-heroicons.js'/
        if (!navigator.geolocation) return;
mport { geoIcon } from './geo-heroicons.js'/
        this.isLocating = true;
mport { geoIcon } from './geo-heroicons.js'/
        this.requestUpdate();
mport { geoIcon } from './geo-heroicons.js'/
        return new Promise((resolve) => {
mport { geoIcon } from './geo-heroicons.js'/
            navigator.geolocation.getCurrentPosition(
mport { geoIcon } from './geo-heroicons.js'/
                (pos) => {
mport { geoIcon } from './geo-heroicons.js'/
                    this._handleInteraction(pos.coords.latitude, pos.coords.longitude, 'geolocation');
mport { geoIcon } from './geo-heroicons.js'/
                    if (this._map) this._map.setView([pos.coords.latitude, pos.coords.longitude], 16);
mport { geoIcon } from './geo-heroicons.js'/
                    this.isLocating = false;
mport { geoIcon } from './geo-heroicons.js'/
                    this.requestUpdate();
mport { geoIcon } from './geo-heroicons.js'/
                    resolve(true);
mport { geoIcon } from './geo-heroicons.js'/
                },
mport { geoIcon } from './geo-heroicons.js'/
                () => { this.isLocating = false; this.requestUpdate(); resolve(false); },
mport { geoIcon } from './geo-heroicons.js'/
                { enableHighAccuracy: true, timeout: 5000 }
mport { geoIcon } from './geo-heroicons.js'/
            );
mport { geoIcon } from './geo-heroicons.js'/
        });
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/
}
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
if (!customElements.get('location-picker-lit')) {
mport { geoIcon } from './geo-heroicons.js'/
    customElements.define('location-picker-lit', LocationPickerLit);
mport { geoIcon } from './geo-heroicons.js'/
}
