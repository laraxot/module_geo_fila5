import { LitElement, html } from 'lit';
import { guard } from 'lit/directives/guard.js';
import 'leaflet/dist/leaflet.css';
import { mapPickerStylesText } from './map-picker-styles.js';
import { renderControls, switchLayer, toggleFullscreen, zoomIn, zoomOut, requestGeolocation, syncFullscreenState } from './map-picker-controls.js';
import { renderSearch } from './map-picker-search.js';
import { initMap, handleMapInteraction, updateMarker, syncMarkerToProperties } from './map-picker-events.js';
import { refreshMapSize, bindRefreshHandler, cleanupObservers } from './map-picker-resize.js';
import { resolveStateCoordinates } from './geo-location-utils.js';

/**
 * CoordinatePickerField - Lit component for geographic coordinate selection.
 * Uses Leaflet for map rendering. Light DOM keeps it compatible with Filament wrappers.
 */
export class CoordinatePickerField extends LitElement {
    static properties = {
        state: { type: Object },
        zoom: { type: Number },
        height: { type: String },
        isLocating: { type: Boolean, state: true },
        isFullscreen: { type: Boolean, state: true },
        geolocateWhenEmpty: { type: Boolean, attribute: 'geolocate-when-empty' },
        labels: { type: Object },
        provider: { type: String },
        showSearch: { type: Boolean, attribute: 'show-search' },
        searchQuery: { type: String, state: true },
        searchResults: { type: Array, state: true },
        showSearchResults: { type: Boolean, state: true },
        isSearching: { type: Boolean, state: true },
        _isProgrammaticUpdate: { type: Boolean, state: true },
        _searchOpen: { type: Boolean, state: true },
    };

    get _lat() { return resolveStateCoordinates(this.state).lat; }
    get _lng() { return resolveStateCoordinates(this.state).lng; }

    createRenderRoot() { return this; }

    constructor() {
        super();
        this.state = null;
        this.zoom = 13;
        this.height = '400px';
        this.isLocating = false;
        this.isFullscreen = false;
        this.geolocateWhenEmpty = false;
        this.geolocated = false;
        this.labels = {};
        this.provider = 'osm';
        this.showSearch = true;
        this.searchQuery = '';
        this.searchResults = [];
        this.showSearchResults = false;
        this.isSearching = false;
        this._searchOpen = false;
        this._isProgrammaticUpdate = false;
        this._layers = {};
        this._marker = null;
        this._map = null;
        this._lastMeasuredSize = null;
        this._debounceTimeout = null;
        this._boundRefreshMapSize = null;
        this._resizeObserver = null;
        this._mutationObserver = null;
        this._currentLayer = 'street';
    }

    render() {
        const l = this.labels || {};
        return html`
            <style>
                coordinate-picker-lit { display: block; width: 100%; height: 100%; min-height: 200px; }
                ${mapPickerStylesText}
                .map-container { min-height: 200px; }
                .map-container.is-fullscreen,
                .map-container:fullscreen { position: fixed !important; inset: 0 !important; width: 100vw !important; height: 100vh !important; border: none !important; border-radius: 0 !important; z-index: 999999 !important; }
                .map-container.is-fullscreen .map-picker-leaflet-pane,
                .map-container:fullscreen .map-picker-leaflet-pane { height: 100vh !important; }
                .layer-controls-overlay { display: flex !important; flex-direction: column !important; gap: 0.5rem !important; }
            </style>
            <div class="map-container ${this.isFullscreen ? 'is-fullscreen' : ''}" style="--map-height: ${this.height}">
                ${guard([], () => html`<div class="map-picker-leaflet-pane" style="height: 100%;"></div>`)}
                ${this.showSearch ? renderSearch(this) : ''}
                ${renderControls(this)}
                <div class="loading-overlay ${this.isLocating ? 'active' : ''}">
                    <div class="spinner"></div>
                </div>
            </div>
        `;
    }

    firstUpdated() {
        initMap(this);
        this._boundRefreshMapSize = () => refreshMapSize(this);
        bindRefreshHandler(this);
        
        // Add fullscreen event listener
        this._handleFullscreenChange = () => {
            console.log('[coordinate-picker] Fullscreen change event detected');
            syncFullscreenState(this);
        };
        document.addEventListener('fullscreenchange', this._handleFullscreenChange);
        
        this._handleEscapeKey = (e) => {
            if (e.key !== 'Escape') {
                return;
            }

            if (this._searchOpen) {
                this._searchOpen = false;
                this.requestUpdate();
                return;
            }

            if (this.isFullscreen) {
                this._toggleFullscreen();
            }
        };
        document.addEventListener('keydown', this._handleEscapeKey);
        
        // Add SVG detection for better fallback handling
        setTimeout(() => {
            this._checkSVGRendering();
        }, 100);
    }
    
    _checkSVGRendering() {
        const buttons = this.querySelectorAll('.ctrl-btn');
        buttons.forEach(button => {
            const svg = button.querySelector('svg');
            if (!svg || svg.children.length === 0) {
                button.classList.add('no-svg');
            } else {
                button.classList.remove('no-svg');
            }
        });
    }

    disconnectedCallback() {
        super.disconnectedCallback();
        if (this._map) { 
            this._map.remove(); 
            this._map = null; 
        }
        cleanupObservers(this);
        if (this._handleEscapeKey) {
            document.removeEventListener('keydown', this._handleEscapeKey);
        }
        // Remove fullscreen event listener
        if (this._handleFullscreenChange) {
            document.removeEventListener('fullscreenchange', this._handleFullscreenChange);
        }
    }

    updated(changed) {
        if (changed.has('state') && !this._isProgrammaticUpdate) {
            if (this._map && this._lat != null && this._lng != null) {
                syncMarkerToProperties(this);
            }
        }
    }

    _switchLayer() { switchLayer(this); }
    _toggleFullscreen() { toggleFullscreen(this); }
    _zoomIn() { zoomIn(this); }
    _zoomOut() { zoomOut(this); }
    _requestGeolocation() { requestGeolocation(this); }
    _handleMapInteraction(lat, lng, source) { handleMapInteraction(this, lat, lng, source); }
    _updateMarker(lat, lng) { updateMarker(this, lat, lng); }
    _syncMarkerToProperties() { syncMarkerToProperties(this); }
    _refreshMapSize() { refreshMapSize(this); }
    _initMap() { initMap(this); }

    _toggleSearch() {
        if (!this.showSearch) {
            console.log('[coordinate-picker] Search toggle ignored: showSearch is false');
            return;
        }

        const wasOpen = this._searchOpen;
        this._searchOpen = !this._searchOpen;
        console.log('[coordinate-picker] Search toggled from', wasOpen, 'to', this._searchOpen);
        
        this.requestUpdate();

        if (this._searchOpen) {
            this.updateComplete.then(() => {
                const searchInput = this.querySelector('.map-picker-search-input');
                if (searchInput) {
                    searchInput.focus();
                    console.log('[coordinate-picker] Search input focused');
                    
                    // Fix for mobile browsers
                    if (document.activeElement !== searchInput) {
                        setTimeout(() => {
                            searchInput.focus();
                        }, 50);
                    }
                } else {
                    console.warn('[coordinate-picker] Search input not found for focus');
                    // Try to find input in search box
                    const searchBox = this.querySelector('.search-box');
                    if (searchBox) {
                        const input = searchBox.querySelector('input');
                        if (input) {
                            input.focus();
                        }
                    }
                }
            });
        }
    }

    _handleSearchSelection(result, lat, lng, payload = null) {
        const enriched = payload && typeof payload === 'object'
            ? payload
            : {
                lat,
                lng,
                latitude: lat,
                longitude: lng,
                address: result?.display_name || this.state?.address || '',
                provider: 'nominatim',
                raw: result,
            };

        this.state = {
            ...(this.state || {}),
            ...enriched,
        };

        this._handleMapInteraction(lat, lng, 'search');
        this._map?.setView([lat, lng], Math.max(this._map.getZoom(), 16));
    }

    setCoordinates(lat, lng, source = 'programmatic') {
        this._handleMapInteraction(lat, lng, source);
        this._map?.setView([lat, lng], Math.max(this._map.getZoom(), this.zoom));
    }
}

if (typeof customElements !== 'undefined' && !customElements.get('coordinate-picker-lit')) {
    customElements.define('coordinate-picker-lit', CoordinatePickerField);
}