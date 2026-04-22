import { LitElement, html, css } from 'lit';
import L from 'leaflet';
import 'leaflet.markercluster';

/**
 * GeoMapWidget - UI Component for displaying clusters of geographic data.
 * Zen: Vision. Aggregates information into a meaningful overview.
 * 
 * Commandment 4: Thou shalt be encapsulated (Shadow DOM).
 */
export class GeoMapWidget extends LitElement {
    static properties = {
        payload: { type: Object },
        _map: { state: true },
        _clusterGroup: { state: true }
    };

    static styles = css`
        :host {
            display: block;
            width: 100%;
            height: 100%;
        }
        .map-container {
            width: 100%;
            height: 100%;
            min-height: 600px;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }
    `;

    constructor() {
        super();
        this.payload = null;
    }

    render() {
        return html`
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
            <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
            <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
            <div class="map-container"></div>
        `;
    }

    firstUpdated() {
        this._initMap();
    }

    _initMap() {
        const container = this.shadowRoot.querySelector('.map-container');
        if (!container) return;

        const initialState = this.payload?.initialState || {
            center: { lat: 45.4642, lng: 9.1900 },
            zoom: 7
        };

        this._map = L.map(container).setView(
            [initialState.center.lat, initialState.center.lng],
            initialState.zoom
        );

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(this._map);

        if (this.payload?.geoJson) {
            this._loadData(this.payload.geoJson);
        }

        setTimeout(() => this._map.invalidateSize(), 150);
    }

    _loadData(geoJson) {
        this._clusterGroup = L.markerClusterGroup();
        
        const geoJsonLayer = L.geoJSON(geoJson, {
            onEachFeature: (feature, layer) => {
                const popup = feature.properties?.popup || {
                    title: 'POI',
                    category: '',
                    address: ''
                };
                layer.bindPopup(`
                    <div style="font-family: inherit;">
                        <strong style="display: block; margin-bottom: 4px;">${popup.title}</strong>
                        <span style="color: #6b7280; font-size: 0.85em;">${popup.category}</span><br>
                        <span style="font-size: 0.9em;">${popup.address}</span>
                    </div>
                `);
            }
        });

        this._clusterGroup.addLayer(geoJsonLayer);
        this._map.addLayer(this._clusterGroup);
        
        if (geoJson.features?.length > 0) {
            this._map.fitBounds(this._clusterGroup.getBounds());
        }
    }

    disconnectedCallback() {
        if (this._map) {
            this._map.remove();
            this._map = null;
        }
        super.disconnectedCallback();
    }
}

if (!customElements.get('geo-map-widget')) {
    customElements.define('geo-map-widget', GeoMapWidget);
}
