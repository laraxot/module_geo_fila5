import { LitElement, html, css } from 'lit';
import L from 'leaflet';

// Fix Leaflet default marker icons after bundling
import markerIcon from 'leaflet/dist/images/marker-icon.png';
import markerIcon2x from 'leaflet/dist/images/marker-icon-2x.png';
import markerShadow from 'leaflet/dist/images/marker-shadow.png';

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
    static lightDomStylesInjected = false;

    static properties = {
        lat: { type: Number },
        lng: { type: Number },
        zoom: { type: Number },
        height: { type: String },
        statePath: { type: String, attribute: 'state-path' },
        autoLocateOnInit: { type: Boolean, attribute: 'auto-locate-on-init' },
        currentLayer: { state: true },
        isFullscreen: { state: true },
        isLocating: { state: true },
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
            justify-content: flex-end;
            align-items: center;
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
            height: 340px;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            background-color: #fff;
            overflow: hidden;
        }

        .map-canvas {
            width: 100%;
            height: 100%;
        }

        .map-shell.is-expanded {
            position: fixed;
            inset: 0;
            width: 100vw;
            height: 100vh;
            min-height: 100vh;
            z-index: 9999;
            border: none;
            border-radius: 0;
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
        this.autoLocateOnInit = false;

        this.map = null;
        this.marker = null;
        this.currentLayer = 'osm';
        this.layers = {};
        this.isFullscreen = false;
        this.mapInitialized = false;
        this.isLocating = false;
    }

    createRenderRoot() {
        // Use light DOM so Tailwind/inherited styles work and Leaflet renders properly
        return this;
    }

    render() {
        const shellStyle = this.isFullscreen
            ? 'min-height: 100vh; height: 100vh;'
            : `min-height: ${this.height}; height: ${this.height};`;

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
                </div>

                <!-- Map Shell -->
                <div class="map-shell ${this.isFullscreen ? 'is-expanded' : ''}" style="${shellStyle}">
                    <div
                        class="map-canvas"
                        style="width: 100%; height: 100%;"
                    ></div>
                    
                    <!-- Geolocation Button (standard icon) - positioned left of fullscreen -->
                    <button
                        type="button"
                        class="map-locate-btn"
                        ?disabled="${this.isLocating}"
                        @click="${() => this.requestGeolocation()}"
                        title="${this.isLocating ? 'Locating...' : 'Use my location'}"
                        aria-label="${this.isLocating ? 'Locating...' : 'Use my location'}"
                    >
                        <!-- Standard GPS/Target icon (Heroicons style) -->
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:20px;height:20px;color:#374151">
                            <circle cx="12" cy="12" r="3"/>
                            <path d="M12 2v2M12 20v2M2 12h2M20 12h2"/>
                            <path d="M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/>
                        </svg>
                    </button>
                    
                    <!-- Fullscreen Button (standard icon) -->
                    <button
                        type="button"
                        class="map-fullscreen-btn"
                        @click="${() => this.toggleFullscreen()}"
                        title="${this.isFullscreen ? 'Exit fullscreen' : 'Enter fullscreen'}"
                        aria-label="${this.isFullscreen ? 'Exit fullscreen' : 'Enter fullscreen'}"
                    >
                        <!-- Standard Fullscreen icon (Heroicons style) -->
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:20px;height:20px;color:#374151">
                            ${this.isFullscreen 
                                ? html`<path d="M9 9V5H5v4h4zm6 0h4V5h-4v4zm0 6v4h4v-4h-4zm-6 0H5v4h4v-4z"/>`
                                : html`<path d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>`
                            }
                        </svg>
                    </button>
                </div>
            </div>
        `;
    }

    firstUpdated() {
        this.ensureLightDomStyles();
        
        // Auto-locate if coordinates are null/invalid (Golden Rule)
        const hasValidCoords = this.lat != null && !isNaN(this.lat) &&
                               this.lng != null && !isNaN(this.lng);
        if (!hasValidCoords) {
            this._autoLocate();
        }
        
        this.initializeMap();
    }
    
    /**
     * Auto-locate when coordinates are null.
     * Golden Rule: When lat/lng are null, always get current position.
     */
    _autoLocate() {
        if (!navigator.geolocation) {
            console.warn('[Geo] Geolocation not supported, using default (Rome)');
            return;
        }
        
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const { latitude, longitude } = position.coords;
                this.lat = latitude;
                this.lng = longitude;
                
                // Emit change to update Livewire
                this.emitChange(latitude, longitude);
                
                // If map already initialized, update it
                if (this.map && this.marker) {
                    this.map.setView([latitude, longitude], this.zoom);
                    this.marker.setLatLng([latitude, longitude]);
                }
                
                console.log('[Geo] Auto-located to:', latitude, longitude);
            },
            (error) => {
                console.warn('[Geo] Auto-locate failed:', error.message, '- using default (Rome)');
                // Keep default coordinates (Rome: 41.9028, 12.4964)
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 60000
            }
        );
    }

    ensureLightDomStyles() {
        if (GeoLatLngInput.lightDomStylesInjected) {
            return;
        }

        const style = document.createElement('style');
        style.setAttribute('data-geo-latlng-input-styles', 'true');
        style.textContent = `
            geo-latlng-input{display:block}
            geo-latlng-input .geo-latlng-shell{display:flex;flex-direction:column;gap:.75rem}
            geo-latlng-input .layer-controls{display:flex;gap:.25rem;flex-wrap:wrap}
            geo-latlng-input .layer-btn{padding:.5rem .75rem;font-size:.875rem;border:1px solid #d1d5db;border-radius:.375rem;background:#fff;color:#374151;cursor:pointer}
            geo-latlng-input .layer-btn.active{background:#2563eb;color:#fff;border-color:#2563eb}
            geo-latlng-input .spacer{flex:1}
            geo-latlng-input .map-shell{position:relative;width:100%;min-height:340px;height:340px;border:1px solid #e5e7eb;border-radius:.375rem;background:#fff;overflow:hidden}
            geo-latlng-input .map-canvas{width:100%;height:100%}
            geo-latlng-input .map-shell.is-expanded{position:fixed;inset:0;width:100vw;height:100vh;min-height:100vh;z-index:9999;border:none;border-radius:0}
            geo-latlng-input .map-fullscreen-btn{position:absolute;bottom:10px;right:10px;z-index:400;width:36px;height:36px;padding:0;background:#fff;border:1px solid #d1d5db;border-radius:.375rem;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background-color 150ms}
            geo-latlng-input .map-fullscreen-btn:hover{background:#f3f4f6}
            geo-latlng-input .map-zoom-controls{position:absolute;bottom:52px;right:10px;z-index:400;display:flex;flex-direction:column;gap:4px}
            geo-latlng-input .map-zoom-btn{width:36px;height:36px;padding:0;background:#fff;border:1px solid #d1d5db;border-radius:.375rem;cursor:pointer;display:flex;align-items:center;justify-content:center;text-decoration:none;transition:background-color 150ms}
            geo-latlng-input .map-zoom-btn:hover{background:#f3f4f6}
            geo-latlng-input .map-locate-btn{position:absolute;bottom:10px;right:52px;z-index:400;width:36px;height:36px;padding:0;background:#fff;border:1px solid #d1d5db;border-radius:.375rem;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background-color 150ms}
            geo-latlng-input .map-locate-btn:hover{background:#f3f4f6}
            geo-latlng-input .map-locate-btn:disabled{opacity:0.5;cursor:not-allowed}
        `;
        document.head.appendChild(style);
        GeoLatLngInput.lightDomStylesInjected = true;
    }

    updated(changedProperties) {
        // If lat/lng change externally (from Livewire), update the map
        if (changedProperties.has('lat') || changedProperties.has('lng')) {
            if (this.map && this.marker && this.mapInitialized) {
                this.marker.setLatLng([this.lat, this.lng]);
                this.map.panTo([this.lat, this.lng], { animate: false });
            }

        }

        if (changedProperties.has('height')) {
            const shell = this.querySelector('.map-shell');
            if (shell) {
                shell.style.minHeight = this.height;
                shell.style.height = this.height;
                requestAnimationFrame(() => this.map?.invalidateSize({ animate: false }));
            }
        }
    }

    initializeMap() {
        if (this.mapInitialized) return;

        const canvas = this.querySelector('.map-canvas');

        if (!canvas) {
            console.error('[Geo Lit] Map canvas not found');
            return;
        }

        // Fix default icon paths before creating map
        delete L.Icon.Default.prototype._getIconUrl;
        L.Icon.Default.mergeOptions({
            iconRetinaUrl: markerIcon2x,
            iconUrl: markerIcon,
            shadowUrl: markerShadow,
        });

        // Initialize Leaflet (disable default zoom control, we'll add custom)
        this.map = L.map(canvas, {
            zoomControl: false
        }).setView([this.lat, this.lng], this.zoom);

        // Add custom zoom controls with SVG icons (same style as layer buttons)
        const zoomControls = document.createElement('div');
        zoomControls.className = 'map-zoom-controls';
        zoomControls.innerHTML = `
            <button type="button" class="map-zoom-btn" data-zoom="in" title="Zoom in" aria-label="Zoom in">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:18px;height:18px;color:#374151">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
            </button>
            <button type="button" class="map-zoom-btn" data-zoom="out" title="Zoom out" aria-label="Zoom out">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:18px;height:18px;color:#374151">
                    <path d="M5 12h14"/>
                </svg>
            </button>
        `;
        zoomControls.querySelector('[data-zoom="in"]').onclick = () => this.map.zoomIn();
        zoomControls.querySelector('[data-zoom="out"]').onclick = () => this.map.zoomOut();
        canvas.parentElement.appendChild(zoomControls);

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

            // Throttle local state updates during drag, emit only on dragend
            if (!dragUpdateTimer) {
                dragUpdateTimer = setTimeout(() => {
                    this.lat = pos.lat;
                    this.lng = pos.lng;
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
            this.lat = pos.lat;
            this.lng = pos.lng;
            this.emitChange(pos.lat, pos.lng);
        });

        // Map click to move marker
        this.map.on('click', (e) => {
            const { lat, lng } = e.latlng;
            this.marker.setLatLng([lat, lng]);
            this.lat = lat;
            this.lng = lng;
            this.emitChange(lat, lng);
        });

        // Invalidate size after render
        setTimeout(() => {
            if (this.map) {
                this.map.invalidateSize();
            }
        }, 100);

        this.mapInitialized = true;

        if (this.autoLocateOnInit === true) {
            this.requestGeolocation();
        }
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
            return;
        }
        this.isLocating = true;

        navigator.geolocation.getCurrentPosition(
            (pos) => {
                const { latitude: lat, longitude: lng } = pos.coords;
                this.lat = lat;
                this.lng = lng;
                this.map.setView([lat, lng], Math.max(this.map.getZoom(), 15));
                this.marker.setLatLng([lat, lng]);
                this.emitChange(lat, lng);
                this.isLocating = false;
                this.dispatchEvent(new CustomEvent('geo-done', { bubbles: true, composed: true }));
            },
            () => {
                this.isLocating = false;
                this.dispatchEvent(new CustomEvent('geo-done', { bubbles: true, composed: true }));
            },
            { enableHighAccuracy: true, timeout: 15000 }
        );
    }

    toggleFullscreen() {
        this.isFullscreen = !this.isFullscreen;
        requestAnimationFrame(() => this.map?.invalidateSize({ animate: false }));
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

    disconnectedCallback() {
        super.disconnectedCallback();
        if (this.map) {
            this.map.remove();
            this.map = null;
        }
    }
}

customElements.define('geo-latlng-input', GeoLatLngInput);
