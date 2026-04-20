import { LitElement, html } from '@theme-lit';
import L from '@theme-leaflet';
import { mapPickerStyles, controlIcons } from './map-picker-styles.js';
import { createMapPickerLeafletIcon } from './map-picker-marker-config.js';

export class MapPickerLit extends LitElement {
    static properties = {
        latitude: { type: Number },
        longitude: { type: Number },
        defaultLatitude: { type: Number, attribute: 'default-latitude' },
        defaultLongitude: { type: Number, attribute: 'default-longitude' },
        zoom: { type: Number },
        height: { type: String },
        showSearch: { type: Boolean, attribute: 'show-search' },
        address: { type: String, attribute: 'address' },
    };

    static styles = mapPickerStyles;

    constructor() {
        super();
        this.latitude = null;
        this.longitude = null;
        this.defaultLatitude = 41.9028;
        this.defaultLongitude = 12.4964;
        this.zoom = 15;
        this.height = '400px';
        this.showSearch = true;
        this.address = null;
        this.hasReverseGeocoding = true;

        this._map = null;
        this._marker = null;
        this._layers = {};
        this._currentLayer = 'street';
        this._mapReady = false;
        this._suppressEvent = false;
        this._pendingLocation = null;
        this._resizeObserver = null;
        this._initRaf = null;
        this._isLocating = false;

        this._onFullscreenChange = this._onFullscreenChange.bind(this);
    }

    render() {
        return html`
            <div class="map-container" style="--map-height: ${this.height}">
                <div class="map-picker-leaflet-pane" part="map"></div>
                ${this.showSearch ? this._renderSearch() : ''}
                <div class="loading-overlay" part="loader">
                    <div class="loading-spinner"></div>
                </div>
            </div>
        `;
    }

    _renderSearch() {
        return html`
            <div class="search-box" part="search">
                <input
                    type="text"
                    class="map-picker-search-input"
                    placeholder="Cerca indirizzo..."
                    @keydown="${(e) => e.key === 'Enter' && this._handleSearch()}"
                    autocomplete="off"
                />
                <button class="control-btn" @click="${this._handleSearch}" type="button">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        `;
    }

    firstUpdated() {
        if (typeof ResizeObserver !== 'undefined') {
            this._resizeObserver = new ResizeObserver(() => this._handleResize());
            this._resizeObserver.observe(this);
        }

        requestAnimationFrame(() => this._handleResize());
        document.addEventListener('fullscreenchange', this._onFullscreenChange);
    }

    updated(changed) {
        if (changed.has('height')) {
            this.invalidateSize();
        }
    }

    disconnectedCallback() {
        super.disconnectedCallback();
        document.removeEventListener('fullscreenchange', this._onFullscreenChange);
        this._resizeObserver?.disconnect();

        if (this._initRaf) {
            cancelAnimationFrame(this._initRaf);
        }

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
            this._autolocateWhenCoordinatesMissing();
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

        if (!(rect.width > 0 && rect.height > 0)) {
            return;
        }

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

        const el = this.renderRoot.querySelector('.map-picker-leaflet-pane');

        if (!el || el._leaflet_id) return;

        const hasInitialCoordinates = Number.isFinite(this.latitude) && Number.isFinite(this.longitude);
        const centerLat = hasInitialCoordinates ? this.latitude : this.defaultLatitude;
        const centerLng = hasInitialCoordinates ? this.longitude : this.defaultLongitude;

        this._map = L.map(el, {
            center: [centerLat, centerLng],
            zoom: this.zoom,
            zoomControl: false,
        });

        this._layers.street = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap',
            maxZoom: 19,
        });
        this._layers.satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: '&copy; Esri',
            maxZoom: 19,
        });

        this._layers.street.addTo(this._map);
        L.control.scale({ position: 'bottomleft', metric: true, imperial: false }).addTo(this._map);
        this._addCustomToolbar();
        this._map.on('click', (e) => this._updateInternal(e.latlng.lat, e.latlng.lng, true, 'click'));
        this._mapReady = true;

        if (this._pendingLocation) {
            this._updateInternal(this._pendingLocation.latitude, this._pendingLocation.longitude, false);
            this._pendingLocation = null;
        } else if (hasInitialCoordinates) {
            this._updateInternal(this.latitude, this.longitude, false);
        } else {
            this._autolocateWhenCoordinatesMissing();
        }

        this.invalidateSize();
    }

    _addCustomToolbar() {
        const self = this;
        const Toolbar = L.Control.extend({
            options: { position: 'topleft' },
            onAdd() {
                const container = L.DomUtil.create('div', 'leaflet-bar leaflet-control map-picker-toolbar');
                L.DomEvent.disableClickPropagation(container);
                L.DomEvent.disableScrollPropagation(container);

                const zoomInBtn = self._createToolbarBtn(container, 'zoomIn', 'Zoom in');
                zoomInBtn.onclick = () => self._map.zoomIn();

                const zoomOutBtn = self._createToolbarBtn(container, 'zoomOut', 'Zoom out');
                zoomOutBtn.onclick = () => self._map.zoomOut();

                const locateBtn = self._createToolbarBtn(container, 'locate', 'Usa posizione corrente');
                locateBtn.onclick = () => self._handleGeolocation();

                const layerBtn = self._createToolbarBtn(container, 'layer', 'Cambia mappa');
                layerBtn.onclick = () => self._switchLayer();

                const fsBtn = self._createToolbarBtn(container, 'fullscreen', 'Fullscreen');
                fsBtn.onclick = () => self._toggleFullscreen();

                return container;
            }
        });

        new Toolbar().addTo(this._map);
    }

    _createToolbarBtn(container, iconKey, title) {
        const btn = L.DomUtil.create('button', `control-btn control-${iconKey}`, container);
        btn.type = 'button';
        btn.title = title;
        btn.innerHTML = controlIcons[iconKey];
        return btn;
    }

    _updateInternal(lat, lng, emit = true, source = 'external') {
        if (!this._map) return;

        this.latitude = lat;
        this.longitude = lng;
        this._suppressEvent = !emit;

        if (!this._marker) {
            this._marker = L.marker([lat, lng], {
                draggable: true,
                icon: createMapPickerLeafletIcon(L),
            }).addTo(this._map);
            this._marker.on('dragend', () => {
                const pos = this._marker.getLatLng();
                this._updateInternal(pos.lat, pos.lng, true, 'drag');
            });
        } else {
            this._marker.setIcon(createMapPickerLeafletIcon(L));
            this._marker.setLatLng([lat, lng]);
        }

        if (source !== 'drag') {
            this._map.setView([lat, lng], this._map.getZoom(), { animate: source !== 'click' });
        }

        this._updateAddress(lat, lng);

        if (emit && !this._suppressEvent) {
            this.dispatchEvent(new CustomEvent('coords-changed', {
                detail: { latitude: lat, longitude: lng },
                bubbles: true,
                composed: true,
            }));
            this.dispatchEvent(new CustomEvent('location-changed', {
                detail: { latitude: lat, longitude: lng, source, address: this.address },
                bubbles: true,
                composed: true,
            }));
        }

        this._suppressEvent = false;
    }

    async _updateAddress(lat, lng) {
        if (!this.hasReverseGeocoding) {
            this.address = null;
            return;
        }

        try {
            const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`, {
                headers: { 'User-Agent': 'FixCity-Senior-Architect/1.0' },
            });

            if (response.ok) {
                const data = await response.json();
                this.address = data.display_name || null;
            } else {
                this.address = null;
            }
        } catch {
            this.address = null;
        }
    }

    _normalizeLocation(loc) {
        if (!loc || typeof loc !== 'object') return null;
        const lat = Number(loc.latitude ?? loc.lat);
        const lng = Number(loc.longitude ?? loc.lng);
        return (Number.isFinite(lat) && Number.isFinite(lng)) ? { latitude: lat, longitude: lng } : null;
    }

    async _handleSearch() {
        const input = this.renderRoot.querySelector('.map-picker-search-input');
        if (!input || !input.value.trim()) return;

        this._setLoading(true);
        try {
            const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(input.value)}&limit=1`);
            const data = await res.json();
            if (data && data[0]) {
                this._updateInternal(parseFloat(data[0].lat), parseFloat(data[0].lon), true, 'search');
            }
        } finally {
            this._setLoading(false);
        }
    }

    _handleGeolocation() {
        if (this._isLocating || !navigator.geolocation) return;

        this._isLocating = true;
        this._setLoading(true);
        navigator.geolocation.getCurrentPosition(
            (pos) => {
                this._isLocating = false;
                this._updateInternal(pos.coords.latitude, pos.coords.longitude, true, 'geolocation');
                this._setLoading(false);
            },
            () => {
                this._isLocating = false;
                this._setLoading(false);
            },
            { enableHighAccuracy: true, timeout: 5000 }
        );
    }

    _autolocateWhenCoordinatesMissing() {
        if (Number.isFinite(this.latitude) && Number.isFinite(this.longitude)) {
            return;
        }

        this._handleGeolocation();
    }

    _toggleFullscreen() {
        const container = this.renderRoot.querySelector('.map-container');
        if (!container) return;

        if (!document.fullscreenElement) {
            container.requestFullscreen().catch(() => {});
        } else {
            document.exitFullscreen();
        }
    }

    _onFullscreenChange() {
        this.classList.toggle('is-fullscreen', !!document.fullscreenElement);
        this.invalidateSize();
    }

    _switchLayer() {
        if (this._currentLayer === 'street') {
            this._map.removeLayer(this._layers.street);
            this._layers.satellite.addTo(this._map);
            this._currentLayer = 'satellite';
        } else {
            this._map.removeLayer(this._layers.satellite);
            this._layers.street.addTo(this._map);
            this._currentLayer = 'street';
        }
    }

    _setLoading(active) {
        const loader = this.renderRoot.querySelector('.loading-overlay');
        if (loader) loader.classList.toggle('active', active);
    }
}

if (!customElements.get('map-picker-lit')) {
    customElements.define('map-picker-lit', MapPickerLit);
}
