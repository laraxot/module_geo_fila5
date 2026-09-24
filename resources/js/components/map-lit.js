// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
import { LitElement, html } from 'lit';
import L from 'leaflet';
window.L = L;
globalThis.L = L;

// Import markercluster - Vite may wrap in CommonJS, ensure registration
import 'leaflet.markercluster/dist/leaflet.markercluster.js';
import 'leaflet.markercluster/dist/MarkerCluster.css';
import 'leaflet.markercluster/dist/MarkerCluster.Default.css';
// Direct UMD registration for Vite
const mcg = (function() {
    // Handle both UMD registration and Vite CommonJS wrapper
    const candidates = [
        (window.L && window.L.MarkerClusterGroup),
        (window.L && window.L.markerClusterGroup && window.L.markerClusterGroup.prototype && window.L.MarkerClusterGroup),
        L.MarkerClusterGroup,
    ];
    for (const c of candidates) {
        if (typeof c === 'function') return c;
    }
    return null;
})();
if (mcg && !L.markerClusterGroup) {
    L.markerClusterGroup = (opts) => new mcg(opts);
}

import { renderControls, toggleFullscreen, switchLayer, zoomIn, zoomOut, requestGeolocation } from './map/controls.js';
import { renderSearch, searchUiHandlers } from './map/controls/search.js';
import { buildMapLayers } from './map/layers.js';
import { mapStylesText } from './map/styles.js';
import { createGeoMapLeafletIcon, markerCardStylesText } from './map/config.js';
import { buildClusterTypeTileHtml } from './map/icon-glyph.js';
import { resolveFeatureTicketType } from './map/feature-type.js';
import { resolveFeatureTicketStatus } from './map/feature-status.js';
import {
    collectLegendStatusesFromFeatures,
    mountMapLegend,
    refreshMapLegend,
} from './map/legend.js';
import {
    buildTicketPopupHtml,
    buildTicketPopupLoadingHtml,
    popupTicketStylesText,
} from './map/popup-ticket.js';
import { bindFeaturePopup } from './map/feature-popup-bind.js';
import { mapLitTicketLayerDataMethods } from './map/map-lit-ticket-layer-data.js';
import { mapLitTicketLayerUiMethods } from './map/map-lit-ticket-layer-ui.js';

const DEFAULT_TICKETS_JSON_URL = '/data/tickets.json';
const DEFAULT_CENTER = [41.9028, 12.4964];
const DEFAULT_ZOOM = 6;
const DEFAULT_MAP_HEIGHT = 'clamp(360px, 58vh, 560px)';

function resolveMapHeight(rawHeight) {
    const value = String(rawHeight || '').trim();
    if (value === '' || value === '100%' || value === 'auto') {
        return DEFAULT_MAP_HEIGHT;
    }

    return value;
}

/** @param {string|null|undefined} raw */
function parseOptionalCoord(raw) {
    if (raw === null || raw === undefined || String(raw).trim() === '') {
        return null;
    }

    const n = Number.parseFloat(String(raw));
    return Number.isFinite(n) ? n : null;
}

/**
 * map-lit.js
 * 1:1 Conversion of direktvermarkter.js (farmshops.eu)
 * Implements LOD clustering, AJAX popups, and auto-geolocation.
 */
class MapLit extends LitElement {
    static properties = {
        filterType: { type: String },
        activeLayer: { type: String },
        isFullscreen: { type: Boolean, state: true },
        height: { type: String },
        _searchOpen: { type: Boolean, state: true },
        labels: { type: Object },
        dataUrl: { type: String, attribute: 'data-url' },
        lat: { type: Number, attribute: 'lat' },
        lng: { type: Number, attribute: 'lng' },
        detailMode: { type: Boolean, attribute: 'detail-mode' },
        ticketId: { type: Number, attribute: 'ticket-id' },
        // State for shared modules (renderSearch/renderControls)
        searchQuery: { type: String, state: true },
        searchResults: { type: Array, state: true },
        showSearchResults: { type: Boolean, state: true },
        isSearching: { type: Boolean, state: true },
        isLocating: { type: Boolean, state: true },
    };

    createRenderRoot() { return this; }

    constructor() {
        super();
        this.filterType = null;
        this.activeLayer = 'markers';
        this.isFullscreen = false;
        this._searchOpen = false;
        this.searchQuery = '';
        this.searchResults = [];
        this.showSearchResults = false;
        this.isSearching = false;
        this.isLocating = false;
        this._previousBodyOverflow = '';
        this._previousHtmlOverflow = '';
        this._geolocRequested = false;
        this.labels = {
            fullscreen: 'Schermo intero',
            close_fullscreen: 'Esci da schermo intero',
            use_location: 'Usa la mia posizione',
            switch_layer: 'Cambia layer',
            zoom_in: 'Aumenta zoom',
            zoom_out: 'Diminuisci zoom',
            search: 'Cerca',
            search_placeholder: 'Cerca indirizzo...',
            legend_title: 'Stati segnalazione',
        };
        this.height = DEFAULT_MAP_HEIGHT;
        this.dataUrl = DEFAULT_TICKETS_JSON_URL;
        this.lat = null;
        this.lng = null;
        this.detailMode = false;
        this.ticketId = null;
        this._currentLayer = 'street';
        this._allFeatures = [];
        this._allMarkers = [];
        this._layers = {};
        this._isUserCentered = false;
        this._initialFitDone = false;
        this._activeTypeFilter = null;
        this._activeStatusFilter = null;
        this._geojsonLayer = null;
        this._invalidateSizeTimer = null;
        this._filterRenderTimer = null;
        this._mapReady = false;
        this._mutationDebounceTimer = null;
        this._legendControl = null;
    }

    render() {
        return html`
            <style>
                ${mapStylesText}
                map-lit { display: block; width: 100%; min-height: 320px; }
                .geo-map-leaflet { width: 100%; height: 100%; min-height: 320px; }
                ${markerCardStylesText}
                .leaflet-div-icon { background: transparent !important; border: none !important; }
                ${popupTicketStylesText}

                html.geo-map-fullscreen-active, html.geo-map-fullscreen-active body { overflow: hidden !important; }
            </style>
            <div class="map-container ${this.isFullscreen ? 'is-fullscreen' : ''}"
                 style="position:relative;--map-height:${resolveMapHeight(this.height)};">
                <div class="geo-map-leaflet" style="width:100%;height:100%;"></div>
                ${this.detailMode ? '' : renderControls(this)}
                ${!this.detailMode && this._searchOpen ? renderSearch(this, searchUiHandlers) : ''}
            </div>
        `;
    }

    _toggleFullscreen() { void toggleFullscreen(this); }
    _switchLayer() { switchLayer(this); }
    _zoomIn() { zoomIn(this); }
    _zoomOut() { zoomOut(this); }
    _requestGeolocation() { requestGeolocation(this, { showLoading: true }); }

    connectedCallback() {
        super.connectedCallback();
        this.dataUrl = this.getAttribute('data-url') || this.dataUrl || DEFAULT_TICKETS_JSON_URL;
        this.lat = parseOptionalCoord(this.getAttribute('lat'));
        this.lng = parseOptionalCoord(this.getAttribute('lng'));
        this.detailMode = this.hasAttribute('detail-mode');
        this.ticketId = parseOptionalCoord(this.getAttribute('ticket-id'));
    }

    _hasExplicitCenter() {
        return Number.isFinite(this.lat) && Number.isFinite(this.lng);
    }

    async firstUpdated() {
        super.firstUpdated();
        await this.updateComplete;

        this._onFiltersChanged = (event) => {
            const detail = event.detail ?? {};
            if (Array.isArray(detail.types)) {
                this._activeTypeFilter = detail.types.length > 0 ? detail.types : null;
            }
            if (Array.isArray(detail.statuses)) {
                this._activeStatusFilter = detail.statuses.length > 0 ? detail.statuses : null;
            }
            this._applyFeatureFilters();
        };
        this.addEventListener('filters-changed', this._onFiltersChanged);

        try {
            await this._initMap();
        } catch (error) {
        }
    }

    async _initMap() {
        const container = this.renderRoot.querySelector('.geo-map-leaflet');
        if (!container) {
            return;
        }

        if (!document.getElementById('popup-styles')) {
            const styleEl = document.createElement('style');
            styleEl.id = 'popup-styles';
            styleEl.textContent = popupTicketStylesText;
            document.head.appendChild(styleEl);
        }

        await this._ensureLeafletPlugins();

        this._map = L.map(container, {
            center: DEFAULT_CENTER,
            zoom: DEFAULT_ZOOM,
            minZoom: this.detailMode ? 14 : 3,
            maxZoom: this.detailMode ? 18 : 19,
            zoomControl: false,
            zoomAnimation: false,
            dragging: !this.detailMode,
            scrollWheelZoom: !this.detailMode,
            doubleClickZoom: !this.detailMode,
            touchZoom: !this.detailMode,
        });

        this._layers = buildMapLayers(L);
        this._layers[this._currentLayer].addTo(this._map);

        // A5: scala metrica (km/m) in basso a sinistra, niente miglia
        L.control.scale({ imperial: false }).addTo(this._map);

        // Reference: direktvermarkter.js custom cluster group
        const clusterFactory = L.markerClusterGroup || (window.L && window.L.markerClusterGroup);
        if (typeof clusterFactory === 'function') {
            this._markersLayer = clusterFactory({
                maxClusterRadius: (z) => (z < 12 ? 80 : 45),
                spiderfyOnMaxZoom: true,
                showCoverageOnHover: false,
                zoomToBoundsOnClick: true,
                chunkedLoading: true,
                // false: i marker restano nel layer al pan/zoom e riappaiono tornando in vista (STORY-124)
                removeOutsideVisibleBounds: false,
                animate: false,
                animateAddingMarkers: false,
                iconCreateFunction: (cluster) => this._createClusterIcon(cluster),
            });
            this._map.addLayer(this._markersLayer);
        } else {
            this._markersLayer = L.layerGroup().addTo(this._map);
        }

        this._map.on('popupopen', (e) => {
            const container = this._map.getContainer();
            const mapW = container.clientWidth;
            const mapH = container.clientHeight;
            // farmshops.eu: maxHeight 0.65 × mappa (A4), maxWidth 0.95 × mappa
            e.popup.options.maxWidth = Math.floor(mapW * 0.95);
            e.popup.options.maxHeight = Math.floor(mapH * 0.65);
            e.popup.update();
            this._wirePopupActions(e.popup);
        });

        // farmshops.eu: LOD cluster (conteggio vs icone tipo) si aggiorna al cambio zoom
        this._map.on('zoomend', () => {
            if (typeof this._markersLayer?.refreshClusters === 'function') {
                this._markersLayer.refreshClusters();
            }
        });

        this._setupMutationObserver();
        this._setupVisibilityObserver();
        this._syncMapLegend([]);

        this._loadGeoJson();
    }

    async _ensureLeafletPlugins() {
        window.L = L;
        globalThis.L = L;

        // Wait for markercluster registration (Vite CommonJS wrapper)
        await this._waitForMarkerCluster();

        await import('leaflet.heat')
            .catch((error) => console.warn('[map-lit] Heat plugin unavailable:', error.message));
    }

    async _waitForMarkerCluster() {
        const maxWait = 50; // 50 * 50ms = 2.5s max
        for (let i = 0; i < maxWait; i++) {
            if (L.markerClusterGroup || (L.MarkerClusterGroup && !L.markerClusterGroup)) {
                // Ensure markerClusterGroup factory is available (UMD polyfill)
                if (!L.markerClusterGroup && L.MarkerClusterGroup) {
                    L.markerClusterGroup = (opts) => new L.MarkerClusterGroup(opts);
                }
                if (L.markerClusterGroup) {
                    return;
                }
            }
            await new Promise(r => setTimeout(r, 50));
        }
    }

    _setupMutationObserver() {
        this._mutationObserver = new MutationObserver(() => {
            if (this.offsetParent === null || !this._map) {
                return;
            }
            if (this._mutationDebounceTimer) {
                clearTimeout(this._mutationDebounceTimer);
            }
            this._mutationDebounceTimer = setTimeout(() => {
                this._mutationDebounceTimer = null;
                this.refreshWhenVisible();
            }, 200);
        });
        let parent = this.parentElement;
        for (let i = 0; i < 12 && parent; i++) {
            this._mutationObserver.observe(parent, { attributes: true, attributeFilter: ['class', 'style', 'hidden'] });
            parent = parent.parentElement;
        }

        document.addEventListener('shown.bs.tab', (e) => this._handleBootstrapTabShown(e));
    }

    _handleBootstrapTabShown(e) {
        if (!this._map) {
            return;
        }
        const target = String(e.target?.getAttribute?.('data-bs-target') || e.target?.getAttribute?.('href') || '');
        const isMapTab = target.includes('map') || target.includes('mappa') || target.includes('tab-mappa');
        if (!isMapTab && this.offsetParent === null) {
            return;
        }
        setTimeout(() => this._invalidateAfterTabShow(), 80);
    }

    _invalidateAfterTabShow() {
        if (!this._map) {
            return;
        }
        this._map.invalidateSize({ pan: false, animate: false });
        if (!this._allFeatures?.length || !this._initialFitDone) {
            return;
        }
        const features = this._resolveFilteredFeatures();
        if (features.length) {
            this._fitBoundsToMarkers(features);
        }
    }

    /**
     * Quando la mappa entra nel viewport: solo invalidateSize (no fitBounds — conflitto con GPS).
     */
    _setupVisibilityObserver() {
        if (typeof IntersectionObserver === 'undefined') {
            return;
        }

        this._visibilityObserver?.disconnect();
        this._visibilityObserver = new IntersectionObserver(
            (entries) => {
                for (const entry of entries) {
                    if (!entry.isIntersecting || entry.intersectionRatio <= 0) {
                        continue;
                    }

                    this.refreshWhenVisible();
                }
            },
            { root: null, threshold: [0, 0.12, 0.35] },
        );
        this._visibilityObserver.observe(this);
    }

    /**
     * LOD Cluster Icon (1:1 from direktvermarkter.js)
     */
    _createClusterIcon(cluster) {
        const markers = cluster.getAllChildMarkers();
        const count = markers.length;
        const zoom = this._map ? this._map.getZoom() : 0;
        const clusterAnchor = L.point(40, 40);
        const clusterSize = L.point(80, 80);

        if (zoom >= 8) {
            const typeByValue = new Map();
            markers.forEach((m) => {
                const value = m.options.typeValue;
                if (!value || typeByValue.has(value)) {
                    return;
                }
                typeByValue.set(value, {
                    iconUrl: m.options.typeIconUrl,
                    label: m.options.typeLabel,
                });
            });
            const icons = [...typeByValue.values()]
                .slice(0, 4)
                .map((t) => buildClusterTypeTileHtml(t.iconUrl, t.label, 16))
                .join('');

            return L.divIcon({
                html: `<div class="geo-cluster-circle"><strong>${count}</strong><div class="geo-cluster-type-icons">${icons}</div></div>`,
                className: 'geo-cluster-wrapper',
                iconSize: clusterSize,
                iconAnchor: clusterAnchor,
            });
        }

        return L.divIcon({
            html: `<div class="geo-cluster-circle"><strong>${count}</strong></div>`,
            className: 'geo-cluster-wrapper',
            iconSize: clusterSize,
            iconAnchor: clusterAnchor,
        });
    }

    _filterFeaturesForDetailMode(features) {
        if (!this.detailMode || !Number.isFinite(this.ticketId)) {
            return features;
        }

        const id = String(this.ticketId);
        return features.filter((f) => String((f.properties || {}).id ?? '') === id);
    }

    // ticket layer methods → map/map-lit-ticket-layer.js
    disconnectedCallback() {
        super.disconnectedCallback();
        if (this._onFiltersChanged) {
            this.removeEventListener('filters-changed', this._onFiltersChanged);
        }
        this._mutationObserver?.disconnect();
        this._visibilityObserver?.disconnect();
        this._legendControl = null;
        if (this._map) {
            this._map.remove();
            this._map = null;
        }
    }
}

Object.assign(MapLit.prototype, mapLitTicketLayerDataMethods, mapLitTicketLayerUiMethods);

if (!customElements.get('map-lit')) {
    customElements.define('map-lit', MapLit);
}
export default MapLit;
