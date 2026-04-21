import { LitElement, html } from '@theme-lit';
import L from '@theme-leaflet';

export class MyMap extends LitElement {
    static properties = {
        lat: { type: Number },
        lng: { type: Number },
        zoom: { type: Number },
        height: { type: String },
        interactive: { type: Boolean },
        markerTitle: { type: String, attribute: 'marker-title' },
    };

    constructor() {
        super();
        this.lat = 45.6669;   // esempio: Treviso/Mogliano area
        this.lng = 12.2423;
        this.zoom = 10;
        this.height = '400px';
        this.interactive = true;
        this.markerTitle = 'My Map';
        this._map = null;
        this._marker = null;
    }

    connectedCallback() {
        super.connectedCallback();
        this.style.display = 'block';
        this.style.width = '100%';
    }

    createRenderRoot() {
        return this;
    }

    render() {
        return html`<div id="map" class="map" style="width: 100%; height: ${this.height}; border-radius: 12px; overflow: hidden;"></div>`;
    }

    firstUpdated() {
        const mapEl = this.querySelector('#map');

        this._map = L.map(mapEl).setView([this.lat, this.lng], this.zoom);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors',
        }).addTo(this._map);

        this._marker = L.marker([this.lat, this.lng], {
            draggable: this.interactive,
        })
            .addTo(this._map)
            .bindPopup(this.markerTitle);

        if (this.interactive) {
            this._marker.on('dragend', () => {
                const position = this._marker?.getLatLng();

                if (! position) {
                    return;
                }

                this.lat = position.lat;
                this.lng = position.lng;

                this.dispatchCoordinatesChanged();
            });

            this._map.on('click', (event) => {
                this.lat = event.latlng.lat;
                this.lng = event.latlng.lng;

                this._marker?.setLatLng(event.latlng);
                this.dispatchCoordinatesChanged();
            });
        }

        requestAnimationFrame(() => {
            this._map?.invalidateSize();
        });
    }

    updated(changedProperties) {
        if (! this._map) {
            return;
        }

        const latChanged = changedProperties.has('lat');
        const lngChanged = changedProperties.has('lng');
        const zoomChanged = changedProperties.has('zoom');

        if (latChanged || lngChanged || zoomChanged) {
            this._map.setView([this.lat, this.lng], this.zoom);

            if (this._marker) {
                this._marker.setLatLng([this.lat, this.lng]);
            }
        }

        if (changedProperties.has('height')) {
            const mapEl = this.querySelector('#map');

            if (mapEl instanceof HTMLElement) {
                mapEl.style.height = this.height;
            }

            requestAnimationFrame(() => {
                this._map?.invalidateSize();
            });
        }
    }

    dispatchCoordinatesChanged() {
        this.dispatchEvent(new CustomEvent('map-coordinates-changed', {
            bubbles: true,
            composed: true,
            detail: {
                lat: this.lat,
                lng: this.lng,
                zoom: this.zoom,
            },
        }));
    }

    disconnectedCallback() {
        if (this._map) {
            this._map.remove();
            this._map = null;
        }
        this._marker = null;
        super.disconnectedCallback();
    }
}

if (! customElements.get('my-map')) {
    customElements.define('my-map', MyMap);
}
