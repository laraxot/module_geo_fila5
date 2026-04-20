import { LitElement, html, nothing } from 'lit';
import * as L from 'leaflet';
import 'leaflet/dist/leaflet.css';

import markerIconUrl       from 'leaflet/dist/images/marker-icon.png';
import markerIconRetinaUrl from 'leaflet/dist/images/marker-icon-2x.png';
import markerShadowUrl     from 'leaflet/dist/images/marker-shadow.png';

delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconUrl:       markerIconUrl,
    iconRetinaUrl: markerIconRetinaUrl,
    shadowUrl:     markerShadowUrl,
});

let _stylesInjected = false;

function injectStyles() {
    if (_stylesInjected) return;

    const style = document.createElement('style');
    style.id    = 'place-picker-field-styles';
    style.textContent = `
        place-picker-field {
            display: block;
            position: relative;
        }
        .place-picker-wrapper {
            position: relative;
            width: 100%;
        }
        .place-picker-wrapper--fullscreen {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: #fff;
        }
        .place-picker-map {
            width: 100%;
            height: 400px;
            background: #e5e7eb;
        }
        .place-picker-wrapper--fullscreen .place-picker-map {
            height: 100dvh;
        }
        .place-picker-fullscreen-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1001;
            background: #fff;
            border: 2px solid rgba(0, 0, 0, 0.3);
            border-radius: 4px;
            width: 34px;
            height: 34px;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
        }
        .place-picker-fullscreen-btn:hover {
            background: #f4f4f4;
        }
        .place-picker-locate-btn {
            position: absolute;
            top: 10px;
            right: 52px;
            z-index: 1001;
            background: #fff;
            border: 2px solid rgba(0, 0, 0, 0.3);
            border-radius: 4px;
            width: 34px;
            height: 34px;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
        }
        .place-picker-locate-btn:hover {
            background: #f4f4f4;
        }
        .place-picker-readout {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
            padding: 6px 8px;
            font-size: 12px;
            font-family: monospace;
            background: rgba(255,255,255,0.92);
            border-top: 1px solid rgba(0,0,0,0.1);
        }
        .place-picker-readout__coord {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .place-picker-readout__label {
            text-transform: uppercase;
            font-size: 10px;
            color: #6b7280;
            letter-spacing: 0.05em;
        }
        .place-picker-readout__value--set   { color: #16a34a; font-weight: 600; }
        .place-picker-readout__value--empty { color: #9ca3af; }
        .place-picker-readout__address {
            color: #6b7280;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 280px;
        }
        .place-picker-readout__hint {
            color: #d97706;
            font-size: 11px;
        }
    `;

    document.head.appendChild(style);
    _stylesInjected = true;
}

class PlacePickerField extends LitElement {

    static properties = {
        latitude:      { type: Number },
        longitude:     { type: Number },
        zoom:          { type: Number },
        address:       { type: String },
        _isFullscreen: { type: Boolean, state: true },
    };

    // Light DOM: necessario per compatibilità con Leaflet CSS globale
    createRenderRoot() {
        return this;
    }

    constructor() {
        super();

        this.latitude      = null;
        this.longitude     = null;
        this.zoom          = 13;
        this.address       = null;
        this._isFullscreen = false;

        /** @type {L.Map|null} */
        this._map = null;
        /** @type {L.Marker|null} */
        this._marker = null;
        /** @type {L.TileLayer|null} */
        this._streetLayer = null;
        /** @type {L.TileLayer|null} */
        this._satelliteLayer = null;

        // Guard: impedisce l'emissione di coords-changed
        // durante aggiornamenti programmatici da Alpine
        this._isProgrammaticUpdate = false;
    }

    connectedCallback() {
        super.connectedCallback();
        injectStyles();
    }

    firstUpdated() {
        this._initMap();
    }

    disconnectedCallback() {
        super.disconnectedCallback();
        this._destroyMap();
    }

    updated(changed) {
        if (!this._map) return;

        if (changed.has('latitude') || changed.has('longitude')) {
            this._isProgrammaticUpdate = true;
            try {
                this._syncMarkerToProperties();
            } finally {
                this._isProgrammaticUpdate = false;
            }
        }

        if (changed.has('_isFullscreen')) {
            requestAnimationFrame(() => {
                setTimeout(() => this._map?.invalidateSize(), 250);
            });
        }
    }

    // -------------------------------------------------------------------------
    // Mappa
    // -------------------------------------------------------------------------

    _initMap() {
        const container = this.querySelector('.place-picker-map-container');

        if (!container) {
            console.error('[PlacePickerField] .place-picker-map-container non trovato.');
            return;
        }

        this._map = L.map(container, {
            center:      this._hasCoords() ? [this.latitude, this.longitude] : [45.4654, 12.3354],
            zoom:        this.zoom,
            zoomControl: true,
        });

        this._streetLayer = L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            { attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>', maxZoom: 19 },
        );

        this._satelliteLayer = L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
            { attribution: '© Esri — Earthstar Geographics', maxZoom: 19 },
        );

        this._streetLayer.addTo(this._map);

        L.control.layers({
            'Stradale':    this._streetLayer,
            'Satellitare': this._satelliteLayer,
        }).addTo(this._map);

        if (this._hasCoords()) {
            this._placeMarker(this.latitude, this.longitude);
        }

        this._map.on('click', (e) => {
            if (this._isProgrammaticUpdate) return;
            this._placeMarker(e.latlng.lat, e.latlng.lng);
            this._emitCoordsChanged(e.latlng.lat, e.latlng.lng);
        });
    }

    _destroyMap() {
        if (this._map) {
            this._map.remove();
            this._map            = null;
            this._marker         = null;
            this._streetLayer    = null;
            this._satelliteLayer = null;
        }
    }

    // -------------------------------------------------------------------------
    // Marker
    // -------------------------------------------------------------------------

    _placeMarker(lat, lng) {
        if (this._marker) {
            this._marker.setLatLng([lat, lng]);
            return;
        }

        this._marker = L.marker([lat, lng], { draggable: true }).addTo(this._map);

        this._marker.on('dragend', (e) => {
            if (this._isProgrammaticUpdate) return;
            const { lat, lng } = e.target.getLatLng();
            this._emitCoordsChanged(lat, lng);
        });
    }

    _syncMarkerToProperties() {
        if (!this._hasCoords()) return;

        this._map.setView([this.latitude, this.longitude], this._map.getZoom(), { animate: false });
        this._placeMarker(this.latitude, this.longitude);
    }

    // -------------------------------------------------------------------------
    // Evento utente — SOLO da interazione diretta, mai da updated()
    // -------------------------------------------------------------------------

    _emitCoordsChanged(latitude, longitude) {
        this.dispatchEvent(new CustomEvent('coords-changed', {
            detail:   { latitude, longitude },
            bubbles:  true,
            composed: true,
        }));
    }

    // -------------------------------------------------------------------------
    // Geolocalizzazione
    // -------------------------------------------------------------------------

    _requestGeolocation() {
        if (!navigator.geolocation) return;

        navigator.geolocation.getCurrentPosition(
            ({ coords }) => {
                if (!this._map) return;
                this._map.setView([coords.latitude, coords.longitude], Math.max(this._map.getZoom(), 15));
                this._placeMarker(coords.latitude, coords.longitude);
                this._emitCoordsChanged(coords.latitude, coords.longitude);
            },
            () => {},
            { timeout: 8000, maximumAge: 60000 },
        );
    }

    // -------------------------------------------------------------------------
    // Fullscreen
    // -------------------------------------------------------------------------

    _toggleFullscreen() {
        this._isFullscreen = !this._isFullscreen;
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    _hasCoords() {
        return (
            this.latitude  !== null && this.latitude  !== undefined && !isNaN(this.latitude)  &&
            this.longitude !== null && this.longitude !== undefined && !isNaN(this.longitude)
        );
    }

    // -------------------------------------------------------------------------
    // Render — readout visivo qui, non in Alpine
    // -------------------------------------------------------------------------

    render() {
        const hasCoords = this._hasCoords();

        return html`
            <div class="place-picker-wrapper ${this._isFullscreen ? 'place-picker-wrapper--fullscreen' : ''}">

                <button
                    type="button"
                    class="place-picker-locate-btn"
                    title="Usa posizione corrente"
                    aria-label="Usa posizione corrente"
                    @click="${() => this._requestGeolocation()}"
                >◎</button>

                <button
                    type="button"
                    class="place-picker-fullscreen-btn"
                    title="${this._isFullscreen ? 'Esci dal fullscreen' : 'Schermo intero'}"
                    aria-label="${this._isFullscreen ? 'Esci dal fullscreen' : 'Schermo intero'}"
                    @click="${() => this._toggleFullscreen()}"
                >${this._isFullscreen ? '✕' : '⛶'}</button>

                <div class="place-picker-map place-picker-map-container"></div>

                <div class="place-picker-readout">
                    <span class="place-picker-readout__coord">
                        <span class="place-picker-readout__label">Lat</span>
                        <span class="place-picker-readout__value ${hasCoords ? 'place-picker-readout__value--set' : 'place-picker-readout__value--empty'}">
                            ${hasCoords ? this.latitude.toFixed(6) : '–'}
                        </span>
                    </span>
                    <span class="place-picker-readout__coord">
                        <span class="place-picker-readout__label">Lng</span>
                        <span class="place-picker-readout__value ${hasCoords ? 'place-picker-readout__value--set' : 'place-picker-readout__value--empty'}">
                            ${hasCoords ? this.longitude.toFixed(6) : '–'}
                        </span>
                    </span>
                    ${this.address
                        ? html`<span class="place-picker-readout__address">📍 ${this.address}</span>`
                        : nothing}
                    ${!hasCoords
                        ? html`<span class="place-picker-readout__hint">Clicca sulla mappa per impostare la posizione</span>`
                        : nothing}
                </div>

            </div>
        `;
    }
}

if (!customElements.get('place-picker-field')) {
    customElements.define('place-picker-field', PlacePickerField);
}