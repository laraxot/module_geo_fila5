mport { geoIcon } from './geo-heroicons.js'/
import { LitElement, html } from 'lit';
mport { geoIcon } from './geo-heroicons.js'/
import { guard } from 'lit/directives/guard.js';
mport { geoIcon } from './geo-heroicons.js'/
import L from 'leaflet';
mport { geoIcon } from './geo-heroicons.js'/
import 'leaflet/dist/leaflet.css';
mport { geoIcon } from './geo-heroicons.js'/
import { mapPickerStyles } from './map-picker-styles.js';
mport { geoIcon } from './geo-heroicons.js'/
import { createMapPickerLeafletIcon } from './map-picker-marker-config.js';
mport { geoIcon } from './geo-heroicons.js'/
import { geoIcon } from './geo-heroicons.js';
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
/**
mport { geoIcon } from './geo-heroicons.js'/
 * CoordinatePickerField
mport { geoIcon } from './geo-heroicons.js'/
 * Componente Lit per selezione coordinate geografiche con mappa Leaflet
mport { geoIcon } from './geo-heroicons.js'/
 * Scopo: Permettere agli utenti di selezionare una posizione sulla mappa
mport { geoIcon } from './geo-heroicons.js'/
 * per segnalazioni ticket, segnalazioni georeferenziate, etc.
mport { geoIcon } from './geo-heroicons.js'/
 */
mport { geoIcon } from './geo-heroicons.js'/
export class CoordinatePickerField extends LitElement {
mport { geoIcon } from './geo-heroicons.js'/
    static properties = {
mport { geoIcon } from './geo-heroicons.js'/
        state: { type: Object },
mport { geoIcon } from './geo-heroicons.js'/
        zoom: { type: Number },
mport { geoIcon } from './geo-heroicons.js'/
        height: { type: String },
mport { geoIcon } from './geo-heroicons.js'/
        isLocating: { type: Boolean, state: true },
mport { geoIcon } from './geo-heroicons.js'/
        isFullscreen: { type: Boolean, state: true },
mport { geoIcon } from './geo-heroicons.js'/
        geolocateWhenEmpty: { type: Boolean, attribute: 'geolocate-when-empty' },
mport { geoIcon } from './geo-heroicons.js'/
        labels: { type: Object },
mport { geoIcon } from './geo-heroicons.js'/
        provider: { type: String },
mport { geoIcon } from './geo-heroicons.js'/
        showSearch: { type: Boolean, attribute: 'show-search' },
mport { geoIcon } from './geo-heroicons.js'/
        _isProgrammaticUpdate: { type: Boolean, state: true },
mport { geoIcon } from './geo-heroicons.js'/
    };
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    get _lat() { return this.state?.latitude ?? null; }
mport { geoIcon } from './geo-heroicons.js'/
    get _lng() { return this.state?.longitude ?? null; }
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
        this.state = null;
mport { geoIcon } from './geo-heroicons.js'/
        this.zoom = 13;
mport { geoIcon } from './geo-heroicons.js'/
        this.height = '400px';
mport { geoIcon } from './geo-heroicons.js'/
        this.isLocating = false;
mport { geoIcon } from './geo-heroicons.js'/
        this.isFullscreen = false;
mport { geoIcon } from './geo-heroicons.js'/
        this.geolocateWhenEmpty = false;
mport { geoIcon } from './geo-heroicons.js'/
        this.geolocated = false;
mport { geoIcon } from './geo-heroicons.js'/
        this.labels = {};
mport { geoIcon } from './geo-heroicons.js'/
        this.provider = 'osm';
mport { geoIcon } from './geo-heroicons.js'/
        this.showSearch = false;
mport { geoIcon } from './geo-heroicons.js'/
        this._isProgrammaticUpdate = false;
mport { geoIcon } from './geo-heroicons.js'/
        this._layers = {};
mport { geoIcon } from './geo-heroicons.js'/
        this._marker = null;
mport { geoIcon } from './geo-heroicons.js'/
        this._map = null;
mport { geoIcon } from './geo-heroicons.js'/
        this._lastMeasuredSize = null;
mport { geoIcon } from './geo-heroicons.js'/
        this._debounceTimeout = null;
mport { geoIcon } from './geo-heroicons.js'/
        this._boundRefreshMapSize = null;
mport { geoIcon } from './geo-heroicons.js'/
        this._resizeObserver = null;
mport { geoIcon } from './geo-heroicons.js'/
        this._mutationObserver = null;
mport { geoIcon } from './geo-heroicons.js'/
        this._currentLayer = 'street';
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    _debounceMapUpdate(fn, delay = 300) {
mport { geoIcon } from './geo-heroicons.js'/
        clearTimeout(this._debounceTimeout);
mport { geoIcon } from './geo-heroicons.js'/
        this._debounceTimeout = setTimeout(() => {
mport { geoIcon } from './geo-heroicons.js'/
            fn();
mport { geoIcon } from './geo-heroicons.js'/
        }, delay);
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    _handleMapInteraction(lat, lng, source = 'manual') {
mport { geoIcon } from './geo-heroicons.js'/
        this._isProgrammaticUpdate = true;
mport { geoIcon } from './geo-heroicons.js'/
        const latitude = Number.parseFloat(Number.parseFloat(lat).toFixed(6));
mport { geoIcon } from './geo-heroicons.js'/
        const longitude = Number.parseFloat(Number.parseFloat(lng).toFixed(6));
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        if (!Number.isFinite(latitude) || !Number.isFinite(longitude)) {
mport { geoIcon } from './geo-heroicons.js'/
            this._isProgrammaticUpdate = false;
mport { geoIcon } from './geo-heroicons.js'/
            return;
mport { geoIcon } from './geo-heroicons.js'/
        }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        this.state = { ...(this.state || {}), latitude, longitude };
mport { geoIcon } from './geo-heroicons.js'/
        this._updateMarker(latitude, longitude);
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        this.dispatchEvent(new CustomEvent('coords-changed', {
mport { geoIcon } from './geo-heroicons.js'/
            detail: { latitude, longitude, source },
mport { geoIcon } from './geo-heroicons.js'/
            bubbles: true,
mport { geoIcon } from './geo-heroicons.js'/
            composed: true,
mport { geoIcon } from './geo-heroicons.js'/
        }));
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        window.setTimeout(() => {
mport { geoIcon } from './geo-heroicons.js'/
            this._isProgrammaticUpdate = false;
mport { geoIcon } from './geo-heroicons.js'/
        }, 100);
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    _requestGeolocation() {
mport { geoIcon } from './geo-heroicons.js'/
        if (!navigator.geolocation || this.isLocating) return;
mport { geoIcon } from './geo-heroicons.js'/
        this.isLocating = true;
mport { geoIcon } from './geo-heroicons.js'/
        this.requestUpdate();
mport { geoIcon } from './geo-heroicons.js'/
        navigator.geolocation.getCurrentPosition(
mport { geoIcon } from './geo-heroicons.js'/
            (pos) => {
mport { geoIcon } from './geo-heroicons.js'/
                const lat = pos.coords.latitude;
mport { geoIcon } from './geo-heroicons.js'/
                const lng = pos.coords.longitude;
mport { geoIcon } from './geo-heroicons.js'/
                this._handleMapInteraction(lat, lng, 'geolocation');
mport { geoIcon } from './geo-heroicons.js'/
                this.isLocating = false;
mport { geoIcon } from './geo-heroicons.js'/
                this.requestUpdate();
mport { geoIcon } from './geo-heroicons.js'/
                // If map exists, center on geolocated position
mport { geoIcon } from './geo-heroicons.js'/
                if (this._map) {
mport { geoIcon } from './geo-heroicons.js'/
                    this._map.setView([lat, lng], Math.max(this._map.getZoom(), 16));
mport { geoIcon } from './geo-heroicons.js'/
                }
mport { geoIcon } from './geo-heroicons.js'/
            },
mport { geoIcon } from './geo-heroicons.js'/
            () => {
mport { geoIcon } from './geo-heroicons.js'/
                this.isLocating = false;
mport { geoIcon } from './geo-heroicons.js'/
                this.requestUpdate();
mport { geoIcon } from './geo-heroicons.js'/
                this.geolocated = false;
mport { geoIcon } from './geo-heroicons.js'/
            },
mport { geoIcon } from './geo-heroicons.js'/
            { enableHighAccuracy: true, timeout: 5000 }
mport { geoIcon } from './geo-heroicons.js'/
        );
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    _refreshMapSize() {
mport { geoIcon } from './geo-heroicons.js'/
        if (this.offsetParent === null) return;
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        const pane = this.querySelector('.map-picker-leaflet-pane');
mport { geoIcon } from './geo-heroicons.js'/
        if (!pane) return;
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        const rect = pane.getBoundingClientRect();
mport { geoIcon } from './geo-heroicons.js'/
        if (!rect || rect.width === 0 || rect.height === 0) return;
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        const last = this._lastMeasuredSize;
mport { geoIcon } from './geo-heroicons.js'/
        if (last && Math.abs(last.width - rect.width) < 0.5 && Math.abs(last.height - rect.height) < 0.5) {
mport { geoIcon } from './geo-heroicons.js'/
            return;
mport { geoIcon } from './geo-heroicons.js'/
        }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        [0, 50, 150, 300, 500, 800, 1200].forEach((delay) => {
mport { geoIcon } from './geo-heroicons.js'/
            setTimeout(() => {
mport { geoIcon } from './geo-heroicons.js'/
                if (this.offsetParent === null || !this._map) return;
mport { geoIcon } from './geo-heroicons.js'/
                this._map.invalidateSize({ animate: false, pan: false });
mport { geoIcon } from './geo-heroicons.js'/
                this._forceTileRedraw();
mport { geoIcon } from './geo-heroicons.js'/
            }, delay);
mport { geoIcon } from './geo-heroicons.js'/
        });
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        if (this._lat != null && this._lng != null) {
mport { geoIcon } from './geo-heroicons.js'/
            this._updateMarker(this._lat, this._lng);
mport { geoIcon } from './geo-heroicons.js'/
        } else if (this.geolocateWhenEmpty && !this.geolocated) {
mport { geoIcon } from './geo-heroicons.js'/
            this._requestGeolocation();
mport { geoIcon } from './geo-heroicons.js'/
        }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        this._lastMeasuredSize = { width: rect.width, height: rect.height };
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    _forceTileRedraw() {
mport { geoIcon } from './geo-heroicons.js'/
        if (!this._map) return;
mport { geoIcon } from './geo-heroicons.js'/
        this._map.eachLayer((layer) => {
mport { geoIcon } from './geo-heroicons.js'/
            if (layer.redraw) layer.redraw();
mport { geoIcon } from './geo-heroicons.js'/
        });
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    _setupObservers() {
mport { geoIcon } from './geo-heroicons.js'/
        this._resizeObserver = new ResizeObserver(() => this._refreshMapSize());
mport { geoIcon } from './geo-heroicons.js'/
        this._resizeObserver.observe(this);
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        this._mutationObserver = new MutationObserver(() => {
mport { geoIcon } from './geo-heroicons.js'/
            if (this.offsetParent !== null) {
mport { geoIcon } from './geo-heroicons.js'/
                this._refreshMapSize();
mport { geoIcon } from './geo-heroicons.js'/
            }
mport { geoIcon } from './geo-heroicons.js'/
        });
mport { geoIcon } from './geo-heroicons.js'/
        let parent = this.parentElement;
mport { geoIcon } from './geo-heroicons.js'/
        for (let i = 0; i < 20 && parent; i++) {
mport { geoIcon } from './geo-heroicons.js'/
            this._mutationObserver.observe(parent, { attributes: true, attributeFilter: ['class', 'style', 'hidden'] });
mport { geoIcon } from './geo-heroicons.js'/
            parent = parent.parentElement;
mport { geoIcon } from './geo-heroicons.js'/
        }
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    render() {
mport { geoIcon } from './geo-heroicons.js'/
        const l = this.labels || {};
mport { geoIcon } from './geo-heroicons.js'/
        
mport { geoIcon } from './geo-heroicons.js'/
        return html`
mport { geoIcon } from './geo-heroicons.js'/
            <style>
mport { geoIcon } from './geo-heroicons.js'/
                coordinate-picker-lit { display: block; width: 100%; height: 100%; min-height: 200px; }
mport { geoIcon } from './geo-heroicons.js'/
                ${mapPickerStyles}
mport { geoIcon } from './geo-heroicons.js'/
                .map-container { min-height: 200px; }
mport { geoIcon } from './geo-heroicons.js'/
                .map-container.is-fullscreen { position: fixed !important; inset: 0 !important; width: 100vw !important; height: 100vh !important; border: none !important; border-radius: 0 !important; z-index: 9999 !important; }
mport { geoIcon } from './geo-heroicons.js'/
                .map-container.is-fullscreen .map-picker-leaflet-pane { height: 100vh !important; }
mport { geoIcon } from './geo-heroicons.js'/
                .layer-controls-overlay { display: flex !important; flex-direction: column !important; gap: 0.5rem !important; }
mport { geoIcon } from './geo-heroicons.js'/
            </style>
mport { geoIcon } from './geo-heroicons.js'/
            <div class="map-container ${this.isFullscreen ? 'is-fullscreen' : ''}" style="--map-height: ${this.height}">
mport { geoIcon } from './geo-heroicons.js'/
                
mport { geoIcon } from './geo-heroicons.js'/
                ${guard([], () => html`<div class="map-picker-leaflet-pane" style="height: 100%;"></div>`)}
mport { geoIcon } from './geo-heroicons.js'/
                
mport { geoIcon } from './geo-heroicons.js'/
                <div class="layer-controls-overlay">
mport { geoIcon } from './geo-heroicons.js'/
                    <button class="ctrl-btn" type="button" @click="${this._toggleFullscreen}" title="${this.isFullscreen ? (l.close_fullscreen || 'Chiudi') : (l.fullscreen || 'Fullscreen')}">
mport { geoIcon } from './geo-heroicons.js'/
                        ${this.isFullscreen ? geoIcon('arrows-pointing-in') : geoIcon('arrows-pointing-out')}
mport { geoIcon } from './geo-heroicons.js'/
                    </button>
mport { geoIcon } from './geo-heroicons.js'/
                    
mport { geoIcon } from './geo-heroicons.js'/
                    <button class="ctrl-btn" type="button" @click="${this._requestGeolocation}" ?disabled="${this.isLocating}" title="${l.use_location || 'Mia posizione'}">
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
                    <button class="ctrl-btn" type="button" @click="${this._switchLayer}" title="${l.switch_layer || 'Cambia Layer'}">
mport { geoIcon } from './geo-heroicons.js'/
                        ${geoIcon('squares-2x2')}
mport { geoIcon } from './geo-heroicons.js'/
                    </button>
mport { geoIcon } from './geo-heroicons.js'/
                    
mport { geoIcon } from './geo-heroicons.js'/
                    <button class="ctrl-btn" type="button" @click="${this._zoomIn}" title="${l.zoom_in || 'Zoom In'}">
mport { geoIcon } from './geo-heroicons.js'/
                        ${geoIcon('plus')}
mport { geoIcon } from './geo-heroicons.js'/
                    </button>
mport { geoIcon } from './geo-heroicons.js'/
                    <button class="ctrl-btn" type="button" @click="${this._zoomOut}" title="${l.zoom_out || 'Zoom Out'}">
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
        this._boundRefreshMapSize = this._refreshMapSize.bind(this);
mport { geoIcon } from './geo-heroicons.js'/
        this._setupObservers();
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        window.addEventListener('resize', this._boundRefreshMapSize);
mport { geoIcon } from './geo-heroicons.js'/
        document.addEventListener('livewire:navigated', this._boundRefreshMapSize);
mport { geoIcon } from './geo-heroicons.js'/
        document.addEventListener('livewire:updated', this._boundRefreshMapSize);
mport { geoIcon } from './geo-heroicons.js'/
        document.addEventListener('click', this._boundRefreshMapSize, true);
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
        this._mutationObserver?.disconnect();
mport { geoIcon } from './geo-heroicons.js'/
        window.removeEventListener('resize', this._boundRefreshMapSize);
mport { geoIcon } from './geo-heroicons.js'/
        document.removeEventListener('livewire:navigated', this._boundRefreshMapSize);
mport { geoIcon } from './geo-heroicons.js'/
        document.removeEventListener('livewire:updated', this._boundRefreshMapSize);
mport { geoIcon } from './geo-heroicons.js'/
        document.removeEventListener('click', this._boundRefreshMapSize, true);
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    updated(changed) {
mport { geoIcon } from './geo-heroicons.js'/
        if (changed.has('state') && !this._isProgrammaticUpdate) {
mport { geoIcon } from './geo-heroicons.js'/
            if (this._map && this._lat != null && this._lng != null) {
mport { geoIcon } from './geo-heroicons.js'/
                this._syncMarkerToProperties();
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
        const el = this.querySelector('.map-picker-leaflet-pane');
mport { geoIcon } from './geo-heroicons.js'/
        if (!el || this._map) return;
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        this._layers = this._layers ?? {};
mport { geoIcon } from './geo-heroicons.js'/
        this._currentLayer = this._currentLayer ?? 'street';
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        const centerLat = this._lat ?? 41.9028;
mport { geoIcon } from './geo-heroicons.js'/
        const centerLng = this._lng ?? 12.4964;
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
        this._map.on('click', (e) => this._handleMapInteraction(e.latlng.lat, e.latlng.lng, 'click'));
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        if (this._lat != null && this._lng != null) {
mport { geoIcon } from './geo-heroicons.js'/
            this._syncMarkerToProperties();
mport { geoIcon } from './geo-heroicons.js'/
        } else if (this.geolocateWhenEmpty || (this._lat === null && this._lng === null)) {
mport { geoIcon } from './geo-heroicons.js'/
            void this._requestGeolocation();
mport { geoIcon } from './geo-heroicons.js'/
        }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        this._refreshMapSize();
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    _syncMarkerToProperties() {
mport { geoIcon } from './geo-heroicons.js'/
        if (!this._map) return;
mport { geoIcon } from './geo-heroicons.js'/
        const lat = this._lat;
mport { geoIcon } from './geo-heroicons.js'/
        const lng = this._lng;
mport { geoIcon } from './geo-heroicons.js'/
        this._updateMarker(lat, lng);
mport { geoIcon } from './geo-heroicons.js'/
        this._map.setView([lat, lng], Math.max(this._map.getZoom(), this.zoom));
mport { geoIcon } from './geo-heroicons.js'/
        this._refreshMapSize();
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    _updateMarker(lat, lng) {
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
                this._handleMapInteraction(pos.lat, pos.lng, 'drag');
mport { geoIcon } from './geo-heroicons.js'/
            });
mport { geoIcon } from './geo-heroicons.js'/
        } else {
mport { geoIcon } from './geo-heroicons.js'/
            this._marker.setLatLng([lat, lng]);
mport { geoIcon } from './geo-heroicons.js'/
        }
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    _switchLayer() {
mport { geoIcon } from './geo-heroicons.js'/
        if (!this._map || !this._layers) {
mport { geoIcon } from './geo-heroicons.js'/
            return;
mport { geoIcon } from './geo-heroicons.js'/
        }
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
        const currentLayerObj = this._layers[this._currentLayer];
mport { geoIcon } from './geo-heroicons.js'/
        if (currentLayerObj) {
mport { geoIcon } from './geo-heroicons.js'/
            this._map.removeLayer(currentLayerObj);
mport { geoIcon } from './geo-heroicons.js'/
        }
mport { geoIcon } from './geo-heroicons.js'/
        const nextLayerObj = this._layers[nextLayer];
mport { geoIcon } from './geo-heroicons.js'/
        if (nextLayerObj && !nextLayerObj._map) {
mport { geoIcon } from './geo-heroicons.js'/
            nextLayerObj.addTo(this._map);
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

mport { geoIcon } from './geo-heroicons.js'/
        if (this._map) {
mport { geoIcon } from './geo-heroicons.js'/
            setTimeout(() => this._map?.invalidateSize(), 350);
mport { geoIcon } from './geo-heroicons.js'/
        }
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    _zoomIn() {
mport { geoIcon } from './geo-heroicons.js'/
        if (this._map) {
mport { geoIcon } from './geo-heroicons.js'/
            this._map.zoomIn();
mport { geoIcon } from './geo-heroicons.js'/
            setTimeout(() => this._map?.invalidateSize(), 150);
mport { geoIcon } from './geo-heroicons.js'/
        }
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    _zoomOut() {
mport { geoIcon } from './geo-heroicons.js'/
        if (this._map) {
mport { geoIcon } from './geo-heroicons.js'/
            this._map.zoomOut();
mport { geoIcon } from './geo-heroicons.js'/
            setTimeout(() => this._map?.invalidateSize(), 150);
mport { geoIcon } from './geo-heroicons.js'/
        }
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    async _requestGeolocationAsync() {
mport { geoIcon } from './geo-heroicons.js'/
        if (!navigator.geolocation) return;
mport { geoIcon } from './geo-heroicons.js'/
        this.isLocating = true;
mport { geoIcon } from './geo-heroicons.js'/
        this.requestUpdate();
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        return new Promise((resolve) => {
mport { geoIcon } from './geo-heroicons.js'/
            navigator.geolocation.getCurrentPosition(
mport { geoIcon } from './geo-heroicons.js'/
                (pos) => {
mport { geoIcon } from './geo-heroicons.js'/
                    const lat = pos.coords.latitude;
mport { geoIcon } from './geo-heroicons.js'/
                    const lng = pos.coords.longitude;
mport { geoIcon } from './geo-heroicons.js'/
                    this._handleMapInteraction(lat, lng, 'geolocation');
mport { geoIcon } from './geo-heroicons.js'/
                    if (this._map) {
mport { geoIcon } from './geo-heroicons.js'/
                        this._map.setView([lat, lng], 16);
mport { geoIcon } from './geo-heroicons.js'/
                    }
mport { geoIcon } from './geo-heroicons.js'/
                    this.isLocating = false;
mport { geoIcon } from './geo-heroicons.js'/
                    this.requestUpdate();
mport { geoIcon } from './geo-heroicons.js'/
                    resolve(true);
mport { geoIcon } from './geo-heroicons.js'/
                },
mport { geoIcon } from './geo-heroicons.js'/
                () => {
mport { geoIcon } from './geo-heroicons.js'/
                    this.isLocating = false;
mport { geoIcon } from './geo-heroicons.js'/
                    this.requestUpdate();
mport { geoIcon } from './geo-heroicons.js'/
                    resolve(false);
mport { geoIcon } from './geo-heroicons.js'/
                },
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
if (!customElements.get('coordinate-picker-lit')) {
mport { geoIcon } from './geo-heroicons.js'/
    customElements.define('coordinate-picker-lit', CoordinatePickerField);
mport { geoIcon } from './geo-heroicons.js'/
}
