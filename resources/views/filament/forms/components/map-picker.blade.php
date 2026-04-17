@php
    use Illuminate\Support\Str;
    $statePath = $getStatePath();
    $prefixPath = Str::beforeLast((string) $statePath, '.');
    $latPath = $prefixPath.'.'.$getLatitudeField();
    $lngPath = $prefixPath.'.'.$getLongitudeField();
    $lw = $getLivewire();
    /** @var array<string, mixed>|null $root */
    $root = $lw->data ?? null;
    $scopeKey = Str::after($prefixPath, 'data.');
    $initialLat = $root !== null ? data_get($root, $scopeKey.'.'.$getLatitudeField()) : null;
    $initialLng = $root !== null ? data_get($root, $scopeKey.'.'.$getLongitudeField()) : null;

    $defaultLat = $getDefaultLatitude();
    $defaultLng = $getDefaultLongitude();
    $defaultZoom = $getDefaultZoom();
    $height = $getHeight();
    $showSearch = $isAutocompleteVisible();
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        class="map-picker-component"
        x-data="{
            lat: @entangle($latPath).live,
            lng: @entangle($lngPath).live,
            updateCoords(e) {
                this.lat = e.detail.lat;
                this.lng = e.detail.lng;
            }
        }"
        @coords-changed="updateCoords"
    >
        @once
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
            <script type="module">
                import { LitElement, html, css } from 'https://cdn.jsdelivr.net/gh/lit/dist@3/core/lit-core.min.js';

                export class MapPickerLit extends LitElement {
                    static properties = {
                        lat: { type: Number },
                        lng: { type: Number },
                        zoom: { type: Number },
                        height: { type: String },
                        showSearch: { type: Boolean, attribute: 'show-search' },
                    };

                    static styles = css`
                        :host {
                            display: block;
                            width: 100%;
                        }
                        .map-container {
                            width: 100%;
                            border-radius: 0.5rem;
                            overflow: hidden;
                            position: relative;
                            border: 1px solid #e5e7eb;
                        }
                        #map {
                            width: 100%;
                            z-index: 1;
                        }
                        .controls {
                            position: absolute;
                            top: 10px;
                            right: 10px;
                            z-index: 1000;
                            display: flex;
                            flex-direction: column;
                            gap: 5px;
                        }
                        .control-btn {
                            background: white;
                            border: 1px solid #ccc;
                            border-radius: 4px;
                            padding: 5px;
                            cursor: pointer;
                            box-shadow: 0 1px 4px rgba(0,0,0,0.3);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            width: 30px;
                            height: 30px;
                        }
                        .control-btn:hover {
                            background: #f4f4f4;
                        }
                        .search-box {
                            position: absolute;
                            top: 10px;
                            left: 50px;
                            z-index: 1000;
                            background: white;
                            padding: 5px;
                            border-radius: 4px;
                            box-shadow: 0 1px 4px rgba(0,0,0,0.3);
                            display: flex;
                            gap: 5px;
                        }
                        .search-box input {
                            border: 1px solid #ccc;
                            border-radius: 2px;
                            padding: 2px 5px;
                            font-size: 12px;
                            outline: none;
                        }
                    `;

                    constructor() {
                        super();
                        this.lat = 41.9028;
                        this.lng = 12.4964;
                        this.zoom = 13;
                        this.height = '400px';
                        this.showSearch = true;
                        this._map = null;
                        this._marker = null;
                        this._layers = {};
                    }

                    render() {
                        return html`
                            <div class="map-container" style="height: ${this.height}">
                                <div id="map" style="height: ${this.height}"></div>
                                <div class="controls">
                                    <button class="control-btn" title="Locate Me" @click="${this.locateMe}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                        </svg>
                                    </button>
                                    <button class="control-btn" title="Toggle Fullscreen" @click="${this.toggleFullscreen}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M1.5 1a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H3.707l3.147 3.146a.5.5 0 0 1-.708.708L3 2.707V4.5a.5.5 0 0 1-1 0v-3zM10.5.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V2.707l-3.146 3.147a.5.5 0 0 1-.708-.708L13.293 2H11.5a.5.5 0 0 1 0-1h-4zm-9 9.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-4a.5.5 0 0 1 0-1h2.293L.146 11.354a.5.5 0 0 1 .708-.708L4 13.293V11.5a.5.5 0 0 1 1 0v4h-4a.5.5 0 0 1 0-1h2.293L.146 11.354a.5.5 0 0 1 .708-.708L4 13.293V11.5a.5.5 0 0 1 1 0v4zM14.5 10.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-4a.5.5 0 0 1 0-1h2.293l-3.147-3.146a.5.5 0 0 1 .708-.708L13 13.293V11.5a.5.5 0 0 1 1 0v4h-4a.5.5 0 0 1 0-1h2.293l-3.147-3.146a.5.5 0 0 1 .708-.708L13 13.293V11.5a.5.5 0 0 1 1 0v4z"/>
                                        </svg>
                                    </button>
                                    <button class="control-btn" title="Switch Layer" @click="${this.switchLayer}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                            <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zM3 10.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z"/>
                                        </svg>
                                    </button>
                                </div>
                                ${this.showSearch ? html`
                                    <div class="search-box">
                                        <input type="text" id="search-input" placeholder="Search address..." @keydown="${this.handleSearchKeyDown}">
                                        <button class="control-btn" @click="${this.searchAddress}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                            </svg>
                                        </button>
                                    </div>
                                ` : ''}
                            </div>
                        `;
                    }

                    firstUpdated() {
                        this.initMap();
                    }

                    initMap() {
                        if (typeof L === 'undefined') {
                            setTimeout(() => this.initMap(), 100);
                            return;
                        }

                        const mapEl = this.renderRoot.querySelector('#map');
                        this._map = L.map(mapEl).setView([this.lat || 41.9028, this.lng || 12.4964], this.zoom);

                        this._layers.street = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; OpenStreetMap contributors'
                        });

                        this._layers.satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EBP, and the GIS User Community'
                        });

                        this._layers.street.addTo(this._map);
                        this._currentLayer = 'street';

                        this._marker = L.marker([this.lat || 41.9028, this.lng || 12.4964], {
                            draggable: true
                        }).addTo(this._map);

                        this._marker.on('dragend', () => {
                            const pos = this._marker.getLatLng();
                            this.updateCoords(pos.lat, pos.lng);
                        });

                        this._map.on('click', (e) => {
                            this._marker.setLatLng(e.latlng);
                            this.updateCoords(e.latlng.lat, e.latlng.lng);
                        });

                        if (!this.lat || !this.lng) {
                            this.locateMe();
                        }

                        requestAnimationFrame(() => {
                            this._map.invalidateSize();
                        });
                    }

                    updateCoords(lat, lng) {
                        this.lat = lat;
                        this.lng = lng;
                        this.dispatchEvent(new CustomEvent('coords-changed', {
                            detail: { lat, lng },
                            bubbles: true,
                            composed: true
                        }));
                    }

                    locateMe() {
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition((position) => {
                                const { latitude, longitude } = position.coords;
                                this._map.setView([latitude, longitude], 15);
                                this._marker.setLatLng([latitude, longitude]);
                                this.updateCoords(latitude, longitude);
                            }, () => {}, { enableHighAccuracy: true });
                        }
                    }

                    toggleFullscreen() {
                        const container = this.renderRoot.querySelector('.map-container');
                        if (!document.fullscreenElement) {
                            container.requestFullscreen().catch(() => {});
                        } else {
                            document.exitFullscreen();
                        }
                        setTimeout(() => this._map.invalidateSize(), 100);
                    }

                    switchLayer() {
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

                    handleSearchKeyDown(e) {
                        if (e.key === 'Enter') {
                            this.searchAddress();
                        }
                    }

                    async searchAddress() {
                        const input = this.renderRoot.querySelector('#search-input');
                        const query = input.value;
                        if (!query) return;

                        try {
                            const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`);
                            const data = await response.json();
                            if (data && data.length > 0) {
                                const { lat, lon } = data[0];
                                const latitude = parseFloat(lat);
                                const longitude = parseFloat(lon);
                                this._map.setView([latitude, longitude], 15);
                                this._marker.setLatLng([latitude, longitude]);
                                this.updateCoords(latitude, longitude);
                            }
                        } catch (error) {
                            console.error('Error searching address:', error);
                        }
                    }

                    updated(changedProperties) {
                        if (this._map && (changedProperties.has('lat') || changedProperties.has('lng'))) {
                            const currentCenter = this._map.getCenter();
                            if (Math.abs(currentCenter.lat - this.lat) > 0.0001 || Math.abs(currentCenter.lng - this.lng) > 0.0001) {
                                this._map.setView([this.lat, this.lng]);
                                this._marker.setLatLng([this.lat, this.lng]);
                            }
                        }
                    }
                }

                if (!customElements.get('map-picker-lit')) {
                    customElements.define('map-picker-lit', MapPickerLit);
                }
            </script>
        @endonce

        <div class="grid grid-cols-2 gap-2 mb-2">
            <div>
                <x-filament::input.wrapper :valid="!$errors->has($latPath)">
                    <x-filament::input
                        type="number"
                        step="0.000001"
                        x-model.number="lat"
                        placeholder="Latitude"
                    />
                </x-filament::input.wrapper>
            </div>
            <div>
                <x-filament::input.wrapper :valid="!$errors->has($lngPath)">
                    <x-filament::input
                        type="number"
                        step="0.000001"
                        x-model.number="lng"
                        placeholder="Longitude"
                    />
                </x-filament::input.wrapper>
            </div>
        </div>

        <div class="rounded-lg overflow-hidden border border-gray-300 dark:border-gray-700">
            <map-picker-lit
                :lat="lat"
                :lng="lng"
                zoom="{{ $defaultZoom }}"
                height="{{ $height }}"
                ?show-search="{{ $showSearch ? 'true' : 'false' }}"
                x-ref="map"
                @coords-changed="updateCoords"
            ></map-picker-lit>
        </div>

        @error($latPath)
            <p class="text-danger-600 text-sm mt-1">{{ $message }}</p>
        @enderror
        @error($lngPath)
            <p class="text-danger-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
</x-dynamic-component>
