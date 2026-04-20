import { LitElement, html, css } from 'lit';
import L from 'leaflet';
import 'leaflet.markercluster';
import 'leaflet/dist/leaflet.css';
import 'leaflet.markercluster/dist/MarkerCluster.css';
import 'leaflet.markercluster/dist/MarkerCluster.Default.css';

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
        }
    `;

    constructor() {
        super();
        this.payload = null;
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
    }

    _loadData(geoJson) {
        this._clusterGroup = L.markerClusterGroup();
        
        const geoJsonLayer = L.geoJSON(geoJson, {
            onEachFeature: (feature, layer) => {
                const popup = feature.properties.popup;
                layer.bindPopup(`
                    <strong>${popup.title}</strong><br>
                    ${popup.category}<br>
                    ${popup.address}
                `);
            }
        });

        this._clusterGroup.addLayer(geoJsonLayer);
        this._map.addLayer(this._clusterGroup);
        
        if (geoJson.features.length > 0) {
            this._map.fitBounds(this._clusterGroup.getBounds());
        }
    }

    render() {
        return html`<div id="map"></div>`;
    }
}

if (!customElements.get('geo-map-widget')) {
    customElements.define('geo-map-widget', GeoMapWidget);
}
