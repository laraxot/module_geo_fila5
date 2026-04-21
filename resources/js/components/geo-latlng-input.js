import { LitElement, html, css } from 'lit';
import L from 'leaflet';

/**
 * GeoLatLngInput — Lit Web Component for interactive latitude/longitude input with Leaflet map.
 *
 * Provides:
 * - Interactive map with draggable marker
 * - Layer switcher (OSM, Satellite, Terrain)
 * - Geolocation button
 * - Fullscreen mode
 * - Bidirectional sync with Livewire via geo-latlng-change events
 *
 * Usage:
 *   <geo-latlng-input
 *     lat="41.9028"
 *     lng="12.4964"
 *     zoom="13"
 *     height="340px"
 *     state-path="data.location"
 *   ></geo-latlng-input>
 *
 * Events:
 *   - geo-latlng-change: { detail: { lat, lng } } — fired when coordinates change
 */
export class GeoLatLngInput extends LitElement {
    static properties = {
        lat: { type: Number },
        lng: { type: Number },
        zoom: { type: Number },
        height: { type: String },
        statePath: { type: String, attribute: 'state-path' },
    };

    static styles = css`
        :host {
            display: block;
        }

        .geo-latlng-shell {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .layer-controls {
            display: flex;
            gap: 0.25rem;
            flex-wrap: wrap;
        }

        .layer-btn {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            background-color: #fff;
            color: #374151;
            cursor: pointer;
            transition: all 150ms;
        }

        .layer-btn:hover {
            background-color: #f3f4f6;
        }

        .layer-btn.active {
            background-color: #2563eb;
            color: #fff;
            border-color: #2563eb;
        }

        .layer-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .spacer {
            flex: 1;
        }

        .map-shell {
            position: relative;
            width: 100%;
            min-height: 340px;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            background-color: #fff;
            overflow: hidden;
        }

        .map-canvas {
            width: 100%;
            height: 100%;
        }

        .map-fullscreen-btn {
            position: absolute;
            bottom: 10px;
            right: 10px;
            z-index: 400;
            width: 36px;
            height: 36px;
            padding: 0;
            background-color: #fff;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 150ms;
        }

        .map-fullscreen-btn:hover {
            background-color: #f3f4f6;
        }

        .map-fullscreen-btn svg {
            width: 20px;
            height: 20px;
            stroke: #374151;
            stroke-width: 2;
        }

        .is-browser-fullscreen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 9999;
            border-radius: 0;
        }

        .coordinate-inputs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .input-group label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
        }

        .input-group input {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            transition: border-color 150ms;
        }

        .input-group input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .leaflet-container {
            font-family: inherit;
        }
    `;

    constructor() {
        super();
        this.lat = 41.9028;
        this.lng = 12.4964;
        this.zoom = 13;
        this.height = '340px';
        this.statePath = 'data.location';

        this.map = null;
        this.marker = null;
        this.currentLayer = 'osm';
        this.layers = {};
        this.isFullscreen = false;
        this.mapInitialized = false;
    }

    createRenderRoot() {
        // Use light DOM so Tailwind/inherited styles work and Leaflet renders properly
        return this;
    }

    render() {
        return html`
            <div class="geo-latlng-shell">
                <!-- Layer Switcher -->
                <div class="layer-controls">
                    <button
                        type="button"
                        class="layer-btn ${this.currentLayer === 'osm' ? 'active' : ''}"
                        @click="${() => this.switchLayer('osm')}"
                    >
                        OSM
                    </button>
                    <button
                        type="button"
                        class="layer-btn ${this.currentLayer === 'satellite' ? 'active' : ''}"
                        @click="${() => this.switchLayer('satellite')}"
                    >
                        Satellite
                    </button>
                    <button
                        type="button"
                        class="layer-btn ${this.currentLayer === 'terrain' ? 'active' : ''}"
                        @click="${() => this.switchLayer('terrain')}"
                    >
                        Terrain
                    </button>

                    <div class="spacer"></div>

                    <button
                        type="button"
                        class="layer-btn"
                        @click="${() => this.requestGeolocation()}"
                        title="Use my location"
                    >
                        📍 Locate
                    </button>
                </div>

                <!-- Map Shell -->
                <div
                    class="map-shell"
                    style="min-height: ${this.height};"
                >
                    <div
                        id="geo-map-canvas-${this.hashCode()}"
                        class="map-canvas"
                    ></div>
                    <button
                        type="button"
                        class="map-fullscreen-btn"
                        @click="${() => this.toggleFullscreen()}"
                        title="${this.isFullscreen ? 'Exit fullscreen' : 'Enter fullscreen'}"
                        aria-label="${this.isFullscreen ? 'Exit fullscreen' : 'Enter fullscreen'}"
                    >
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/>
                        </svg>
                    </button>
                </div>

                <!-- Coordinate Inputs -->
                <div class="coordinate-inputs">
                    <div class="input-group">
                        <label for="${this.statePath}_latitude">Latitude</label>
                        <input
                            type="number"
                            id="${this.statePath}_latitude"
                            step="0.000001"
                            min="-90"
                            max="90"
                            .value="${this.lat.toString()}"
                            @change="${(e) => this.onLatitudeChange(e)}"
                            placeholder="Latitude"
                        >
                    </div>
                    <div class="input-group">
                        <label for="${this.statePath}_longitude">Longitude</label>
                        <input
                            type="number"
                            id="${this.statePath}_longitude"
                            step="0.000001"
                            min="-180"
                            max="180"
                            .value="${this.lng.toString()}"
                            @change="${(e) => this.onLongitudeChange(e)}"
                            placeholder="Longitude"
                        >
                    </div>
                </div>
            </div>
        `;
    }

    firstUpdated() {
        this.initializeMap();
    }

    updated(changedProperties) {
        // If lat/lng change externally (from Livewire), update the map
        if (changedProperties.has('lat') || changedProperties.has('lng')) {
            if (this.map && this.marker && this.mapInitialized) {
                this.marker.setLatLng([this.lat, this.lng]);
                this.map.setView([this.lat, this.lng], this.map.getZoom());
            }

            // Update input values if changed externally
            const latInput = this.querySelector(`#${this.statePath}_latitude`);
            const lngInput = this.querySelector(`#${this.statePath}_longitude`);
            if (latInput) latInput.value = this.lat.toString();
            if (lngInput) lngInput.value = this.lng.toString();
        }

        if (changedProperties.has('height')) {
            const shell = this.querySelector('.map-shell');
            if (shell) {
                shell.style.minHeight = this.height;
            }
        }
    }

    initializeMap() {
        if (this.mapInitialized) return;

        const canvasId = `geo-map-canvas-${this.hashCode()}`;
        const canvas = this.querySelector(`#${canvasId}`);

        if (!canvas) {
            console.error('[Geo Lit] Map canvas not found:', canvasId);
            return;
        }

        // Initialize Leaflet
        this.map = L.map(canvas).setView([this.lat, this.lng], this.zoom);

        // Define layers
        this.layers = {
            osm: L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                maxZoom: 19,
            }),
            satellite: L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP',
                maxZoom: 19,
            }),
            terrain: L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
                attribution: 'Map data: &copy; OpenStreetMap contributors, SRTM | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a>',
                maxZoom: 17,
            }),
        };

        // Add default layer
        this.layers.osm.addTo(this.map);
        this.currentLayer = 'osm';

        // Add marker
        this.marker = L.marker([this.lat, this.lng], { draggable: true }).addTo(this.map);

        // Marker drag events
        let dragUpdateTimer = null;

        this.marker.on('drag', (e) => {
            const pos = e.target.getLatLng();

            // Throttle input updates during drag
            if (!dragUpdateTimer) {
                dragUpdateTimer = setTimeout(() => {
                    this.updateInputs(pos.lat, pos.lng);
                    dragUpdateTimer = null;
                }, 200);
            }
        });

        this.marker.on('dragend', (e) => {
            if (dragUpdateTimer) {
                clearTimeout(dragUpdateTimer);
                dragUpdateTimer = null;
            }

            const pos = e.target.getLatLng();
            this.updateInputs(pos.lat, pos.lng);
            this.emitChange(pos.lat, pos.lng);
        });

        // Map click to move marker
        this.map.on('click', (e) => {
            const { lat, lng } = e.latlng;
            this.marker.setLatLng([lat, lng]);
            this.updateInputs(lat, lng);
            this.emitChange(lat, lng);
        });

        // Invalidate size after render
        setTimeout(() => {
            if (this.map) {
                this.map.invalidateSize();
            }
        }, 100);

        this.mapInitialized = true;
    }

    switchLayer(layerName) {
        if (!this.map || !this.layers[layerName] || this.currentLayer === layerName) {
            return;
        }

        this.map.removeLayer(this.layers[this.currentLayer]);
        this.layers[layerName].addTo(this.map);
        this.currentLayer = layerName;

        // Trigger re-render to update button active states
        this.requestUpdate();
    }

    requestGeolocation() {
        if (!navigator.geolocation) {
            alert('Geolocation not supported');
            return;
        }

        navigator.geolocation.getCurrentPosition(
            (pos) => {
                const { latitude: lat, longitude: lng } = pos.coords;
                this.lat = lat;
                this.lng = lng;
                this.map.setView([lat, lng], Math.max(this.map.getZoom(), 15));
                this.marker.setLatLng([lat, lng]);
                this.updateInputs(lat, lng);
                this.emitChange(lat, lng);
            },
            (error) => {
                alert('Failed to get location: ' + error.message);
            },
            { enableHighAccuracy: true, timeout: 15000 }
        );
    }

    toggleFullscreen() {
        const shell = this.querySelector('.map-shell');
        if (!shell) return;

        if (this.isFullscreen) {
            this.exitFullscreen();
        } else {
            this.enterFullscreen(shell);
        }
    }

    enterFullscreen(element) {
        if (element.requestFullscreen) {
            element.requestFullscreen();
        } else if (element.webkitRequestFullscreen) {
            element.webkitRequestFullscreen();
        } else if (element.msRequestFullscreen) {
            element.msRequestFullscreen();
        }
    }

    exitFullscreen() {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }

    updateInputs(lat, lng) {
        const latInput = this.querySelector(`#${this.statePath}_latitude`);
        const lngInput = this.querySelector(`#${this.statePath}_longitude`);

        if (latInput) {
            latInput.value = lat.toString();
        }
        if (lngInput) {
            lngInput.value = lng.toString();
        }

        this.lat = lat;
        this.lng = lng;
    }

    onLatitudeChange(e) {
        const lat = parseFloat(e.target.value);
        if (Number.isFinite(lat) && lat >= -90 && lat <= 90) {
            this.lat = lat;
            if (this.marker) {
                this.marker.setLatLng([lat, this.lng]);
            }
            if (this.map) {
                this.map.setView([lat, this.lng], this.map.getZoom());
            }
            this.emitChange(lat, this.lng);
        }
    }

    onLongitudeChange(e) {
        const lng = parseFloat(e.target.value);
        if (Number.isFinite(lng) && lng >= -180 && lng <= 180) {
            this.lng = lng;
            if (this.marker) {
                this.marker.setLatLng([this.lat, lng]);
            }
            if (this.map) {
                this.map.setView([this.lat, lng], this.map.getZoom());
            }
            this.emitChange(this.lat, lng);
        }
    }

    emitChange(lat, lng) {
        this.dispatchEvent(
            new CustomEvent('geo-latlng-change', {
                detail: { lat, lng },
                bubbles: true,
                composed: true,
            })
        );
    }

    hashCode() {
        // Simple hash of statePath to create unique map canvas ID
        let hash = 0;
        for (let i = 0; i < this.statePath.length; i++) {
            const char = this.statePath.charCodeAt(i);
            hash = ((hash << 5) - hash) + char;
            hash = hash & hash; // Convert to 32bit integer
        }
        return Math.abs(hash);
    }

    disconnectedCallback() {
        super.disconnectedCallback();
        if (this.map) {
            this.map.remove();
            this.map = null;
        }
    }
}

customElements.define('geo-latlng-input', GeoLatLngInput);
