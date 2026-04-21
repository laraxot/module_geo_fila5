@php
    $sprite = $sprite ?? '/themes/Sixteen/design-comuni/assets/bootstrap-italia/dist/svg/sprites.svg';
    $statePath = $getStatePath();
    $latPath = $statePath.'.latitude';
    $lngPath = $statePath.'.longitude';
    $lw = $field->getLivewire();
    /** @var array<string, mixed>|null $root */
    $root = $lw->data ?? null;
    $scopeKey = Str::after($statePath, 'data.');
    $initialLat = $root !== null ? data_get($root, $scopeKey.'.latitude') : null;
    $initialLng = $root !== null ? data_get($root, $scopeKey.'.longitude') : null;
    $mapId = 'latitude-longitude-map-'.$getId();
    $shellId = 'latitude-longitude-map-shell-'.$getId();
    $btnId = 'btn-geo-locate-'.$getId();
    $btnFullscreenId = 'btn-geo-fullscreen-'.$getId();
    $layerControlId = 'map-layer-ctrl-'.$getId();
    $defaultLat = $field->getDefaultLatitude();
    $defaultLng = $field->getDefaultLongitude();
    $defaultZoom = $field->getDefaultZoom();
    $height = '340px';
@endphp

{{-- Leaflet CSS/JS - only load once per page --}}
@once
<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""
/>
<script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""
></script>
<style>
    .latitude-longitude-map-canvas .leaflet-container {
        font-family: inherit;
        border-radius: 0.375rem;
    }
</style>
<script>
    // Initialize a global counter for map instances
    if (!window.geoMapCounter) {
        window.geoMapCounter = 0;
    }
</script>
@endonce

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div class="space-y-2 geo-latlng-field" x-data="latitudeLongitudeMap({
            mapId: @js($mapId),
            shellId: @js($shellId),
            btnId: @js($btnId),
            btnFullscreenId: @js($btnFullscreenId),
            layerControlId: @js($layerControlId),
            latPath: @js($latPath),
            lngPath: @js($lngPath),
            defaultLat: @js($defaultLat),
            defaultLng: @js($defaultLng),
            defaultZoom: @js($defaultZoom),
            initialLat: @js($initialLat),
            initialLng: @js($initialLng),
            height: @js($height),
            wire: @js($lw)
        })">
        {{-- Layer switcher (Tailwind + Alpine) --}}
        <div
            x-data="{ activeLayer: 'osm' }"
            x-on:map-layer-change.window="
                if ($event.detail.mapId === @js($mapId)) {
                    activeLayer = $event.detail.layer;
                }
            "
            class="flex gap-1"
            id="{{ $layerControlId }}"
        >
            <button
                type="button"
                @click="activeLayer='osm'; $dispatch('map-layer-select', { mapId: @js($mapId), layer: 'osm' })"
                :class="activeLayer==='osm' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'"
                class="px-2 py-1 text-xs font-medium rounded border shadow-sm transition-colors"
            >{{ __('geo::latitude_longitude_input.layers.osm') }}</button>
            <button
                type="button"
                @click="activeLayer='satellite'; $dispatch('map-layer-select', { mapId: @js($mapId), layer: 'satellite' })"
                :class="activeLayer==='satellite' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'"
                class="px-2 py-1 text-xs font-medium rounded border shadow-sm transition-colors"
            >{{ __('geo::latitude_longitude_input.layers.satellite') }}</button>
            <button
                type="button"
                @click="activeLayer='terrain'; $dispatch('map-layer-select', { mapId: @js($mapId), layer: 'terrain' })"
                :class="activeLayer==='terrain' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'"
                class="px-2 py-1 text-xs font-medium rounded border shadow-sm transition-colors"
            >{{ __('geo::latitude_longitude_input.layers.terrain') }}</button>

            <div class="ml-auto">
                <button
                    type="button"
                    id="{{ $btnId }}"
                    x-data="{ loading: false }"
                    :disabled="loading"
                    @click="loading = true"
                    x-on:geo-done.window="if ($event.detail.mapId === @js($mapId)) loading = false"
                    class="flex items-center gap-1 px-2 py-1 text-xs font-medium rounded border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 shadow-sm transition-colors disabled:opacity-50"
                    aria-label="{{ __('geo::address.fields.use_my_location.label') }}"
                >
                    <span x-show="!loading">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="12" cy="12" r="3" stroke-width="2"/><path stroke-width="2" d="M12 2v3m0 14v3M2 12h3m14 0h3"/>
                        </svg>
                    </span>
                    <span x-show="loading" class="w-3 h-3 border-2 border-blue-500 border-t-transparent rounded-full animate-spin"></span>
                    <span>{{ __('geo::address.fields.use_my_location.label') }}</span>
                </button>
            </div>
        </div>

        {{-- Mappa --}}
        <div
            wire:ignore
            id="{{ $shellId }}"
            class="latitude-longitude-map-shell w-full rounded border border-gray-200 bg-white relative overflow-hidden"
            style="min-height: {{ $height }}; z-index: 1;"
        >
            <div
                id="{{ $mapId }}"
                class="w-full latitude-longitude-map-canvas"
                style="min-height: {{ $height }}; z-index: 1;"
            ></div>
            <!-- Fullscreen button -->
            <button
                type="button"
                class="map-fullscreen-btn"
                id="{{ $btnFullscreenId }}"
                x-data="{ isFullscreen: false }"
                x-on:map-fullscreen-change.window="if ($event.detail.mapId === '{{ $mapId }}') isFullscreen = $event.detail.isFullscreen"
                x-bind:aria-label="isFullscreen ? @js(__('geo::latitude_longitude_input.actions.fullscreen_exit')) : @js(__('geo::latitude_longitude_input.actions.fullscreen_enter'))"
                x-bind:title="isFullscreen ? @js(__('geo::latitude_longitude_input.actions.fullscreen_exit')) : @js(__('geo::latitude_longitude_input.actions.fullscreen_enter'))"
                aria-label="{{ __('geo::latitude_longitude_input.actions.fullscreen_enter') }}"
                title="{{ __('geo::latitude_longitude_input.actions.fullscreen_enter') }}"
            >
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/>
                </svg>
            </button>
        </div>

        {{-- Coordinate --}}
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label for="{{ $statePath }}_latitude" class="sr-only">
                    {{ __('geo::coordinates.fields.latitude.label') }}
                </label>
                <input
                    type="number"
                    step="0.000001"
                    min="-90"
                    max="90"
                    wire:model.change="{{ $statePath }}.latitude"
                    id="{{ $statePath }}_latitude"
                    class="block w-full rounded border border-gray-300 px-2 py-1.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    placeholder="{{ __('geo::coordinates.fields.latitude.placeholder') }}"
                    required
                >
            </div>
            <div>
                <label for="{{ $statePath }}_longitude" class="sr-only">
                    {{ __('geo::coordinates.fields.longitude.label') }}
                </label>
                <input
                    type="number"
                    step="0.000001"
                    min="-180"
                    max="180"
                    wire:model.change="{{ $statePath }}.longitude"
                    id="{{ $statePath }}_longitude"
                    class="block w-full rounded border border-gray-300 px-2 py-1.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    placeholder="{{ __('geo::coordinates.fields.longitude.placeholder') }}"
                    required
                >
            </div>
        </div>
    </div>
</x-dynamic-component>

<script>
    /**
     * latitudeLongitudeMap — Alpine component for the latitude/longitude input with Leaflet map.
     *
     * Provides:
     * - Interactive map with draggable marker (updates coordinates via Livewire)
     * - Layer switcher (OSM, Satellite, Terrain)
     * - Geolocation button to center on user location
     * - Coordinate inputs bound to Livewire via wire:model.change for non-destructive sync
     *
     * Parameters received via x-data:
     *   - mapId: string (HTML id of the map container)
     *   - btnId: string (HTML id of the geolocation button)
     *   - layerControlId: string (HTML id of the layer switcher container)
     *   - latPath: string (Livewire path to latitude, e.g., 'data.location.latitude')
     *   - lngPath: string (Livewire path to longitude)
     *   - defaultLat, defaultLng: numbers (default center coordinates)
     *   - defaultZoom: number (default zoom level)
     *   - initialLat, initialLng: numbers|null (initial coordinates from Livewire, if any)
     *   - height: string (CSS height for the map container)
     *   - wire: Livewire component instance (the parent form's Livewire)
     */
    (function () {
        latitudeLongitudeMap = function ({
            mapId,
            shellId,
            btnId,
            btnFullscreenId,
            layerControlId,
            latPath,
            lngPath,
            defaultLat,
            defaultLng,
            defaultZoom,
            initialLat,
            initialLng,
            height,
            wire
        }) {
            // Initialize global instances registry
            if (!window.geoMapInstances) {
                window.geoMapInstances = {};
            }

            // Check if component is already initialized
            if (window.geoMapInstances[mapId]) {
                console.log('[Geo] Using existing instance:', mapId);
                return window.geoMapInstances[mapId];
            }

            const component = {
                map: null,
                marker: null,
                layers: {},
                currentLayer: 'osm',
                loading: false,
                inputSyncTimer: null,
                isProgrammaticInputUpdate: false,
                currentLat: null,
                currentLng: null,

                init() {
                    // Wait for Leaflet to be loaded
                    if (!window.L) {
                        console.error('[Geo] Leaflet not loaded');
                        return;
                    }

                    const el = document.getElementById(mapId);
                    const shell = document.getElementById(shellId);
                    if (!el) {
                        console.error('[Geo] Map element not found:', mapId);
                        return;
                    }
                    if (!shell) {
                        console.error('[Geo] Map shell not found:', shellId);
                        return;
                    }

                    // Prevent re-initialization
                    if (el.getAttribute('data-geo-leaflet-ready') === '1') {
                        console.log('[Geo] Map already initialized:', mapId);
                        return;
                    }

                    // Mark as initialized
                    el.setAttribute('data-geo-leaflet-ready', '1');

                    // Store instance globally
                    window.geoMapInstances[mapId] = component;

                    // Set map height
                    el.style.minHeight = height;

                    // Parse initial coordinates — Livewire state takes precedence
                    let lat = parseFloat(initialLat);
                    let lng = parseFloat(initialLng);
                    let usedDefaults = false;

                    if (!Number.isFinite(lat) || !Number.isFinite(lng)) {
                        lat = defaultLat;
                        lng = defaultLng;
                        usedDefaults = true;
                    }

                    this.currentLat = lat;
                    this.currentLng = lng;

                    // Define tile layers
                    this.layers = {
                        osm: L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                            maxZoom: 19,
                        }),
                        satellite: L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
                            maxZoom: 19,
                        }),
                        terrain: L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
                            attribution: 'Map data: &copy; OpenStreetMap contributors, SRTM | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (CC-BY-SA)',
                            maxZoom: 17,
                        }),
                    };

                    // Initialize map
                    this.map = L.map(el, {
                        zoomControl: false, // optional: we can add our own later
                    }).setView([lat, lng], defaultZoom);

                    // Add default layer
                    this.layers.osm.addTo(this.map);
                    this.currentLayer = 'osm';

                    // Add marker
                    this.marker = L.marker([lat, lng], { draggable: true }).addTo(this.map);

                    // Sync inputs to match marker position
                    this.setInputValues(lat, lng, false);

                    // Only commit to Livewire if we used defaults (new initialization)
                    if (usedDefaults) {
                        this.commitCoordinates(lat, lng);
                    }

                    let dragUpdateTimer = null;

                    // During drag, debounce DOM updates to reduce churn
                    this.marker.on('drag', (e) => {
                        const pos = e.target.getLatLng();
                        this.currentLat = pos.lat;
                        this.currentLng = pos.lng;

                        // Throttle input updates to every ~200ms during drag
                        if (!dragUpdateTimer) {
                            dragUpdateTimer = setTimeout(() => {
                                this.setInputValues(pos.lat, pos.lng, false);
                                dragUpdateTimer = null;
                            }, 200);
                        }
                    });

                    // Commit once when drag ends (sync to Livewire)
                    this.marker.on('dragend', (e) => {
                        if (dragUpdateTimer) {
                            clearTimeout(dragUpdateTimer);
                            dragUpdateTimer = null;
                        }
                        const pos = e.target.getLatLng();
                        this.setInputValues(pos.lat, pos.lng, false);
                        this.commitCoordinates(pos.lat, pos.lng);
                    });

                    // Watch for manual changes to latitude/longitude inputs
                    // When user types in the inputs, recenter map and move marker to those coordinates
                    const latInput = document.getElementById(`${@js($statePath)}_latitude`);
                    const lngInput = document.getElementById(`${@js($statePath)}_longitude`);

                    const syncMapFromInputs = (commit = false) => {
                        if (this.isProgrammaticInputUpdate) {
                            return;
                        }

                        const lat = parseFloat(latInput?.value);
                        const lng = parseFloat(lngInput?.value);

                        if (!Number.isFinite(lat) || !Number.isFinite(lng)) {
                            return;
                        }

                        if (lat < -90 || lat > 90 || lng < -180 || lng > 180) {
                            return;
                        }

                        this.currentLat = lat;
                        this.currentLng = lng;

                        if (this.map && this.marker) {
                            this.marker.setLatLng([lat, lng]);
                            this.map.setView([lat, lng], this.map.getZoom());
                        }

                        if (commit) {
                            this.commitCoordinates(lat, lng, { updateInputs: false });
                        }
                    };

                    if (latInput) {
                        latInput.addEventListener('input', () => {
                            clearTimeout(this.inputSyncTimer);
                            this.inputSyncTimer = setTimeout(() => syncMapFromInputs(false), 160);
                        });
                        latInput.addEventListener('change', () => syncMapFromInputs(true));
                    }
                    if (lngInput) {
                        lngInput.addEventListener('input', () => {
                            clearTimeout(this.inputSyncTimer);
                            this.inputSyncTimer = setTimeout(() => syncMapFromInputs(false), 160);
                        });
                        lngInput.addEventListener('change', () => syncMapFromInputs(true));
                    }

                    // Update coordinates when map is clicked
                    this.map.on('click', (e) => {
                        this.marker.setLatLng(e.latlng);
                        this.commitCoordinates(e.latlng.lat, e.latlng.lng);
                    });

                    // Layer switcher listener (from Alpine component)
                    document.addEventListener('map-layer-select', (e) => {
                        if (!e.detail || e.detail.mapId !== mapId) { return; }
                        const name = e.detail.layer;
                        if (name && this.layers[name] && this.layers[name] !== this.layers[this.currentLayer]) {
                            this.map.removeLayer(this.layers[this.currentLayer]);
                            this.layers[name].addTo(this.map);
                            this.currentLayer = name;
                        }
                    });

                    // Geolocation button
                    const btn = document.getElementById(btnId);
                    if (btn && navigator.geolocation) {
                        btn.addEventListener('click', () => {
                            this.setLoading(true);
                            navigator.geolocation.getCurrentPosition(
                                (pos) => {
                                    const ll = [pos.coords.latitude, pos.coords.longitude];
                                    this.map.setView(ll, Math.max(this.map.getZoom(), 15));
                                    this.marker.setLatLng(ll);
                                    this.commitCoordinates(ll[0], ll[1]);
                                    this.setLoading(false);
                                },
                                () => {
                                    this.setLoading(false);
                                    alert(@json(__('geo::address.geolocation.error')));
                                },
                                { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
                            );
                        });
                    } else if (btn) {
                        btn.disabled = true;
                        btn.classList.add('opacity-50');
                    }

                    // Invalidate size after a short delay to ensure map renders correctly
                    setTimeout(() => {
                        if (this.map) {
                            this.map.invalidateSize();
                        }
                    }, 400);

                    const fullscreenBtn = document.getElementById(btnFullscreenId);
                    const requestFullscreen = () => {
                        if (shell.requestFullscreen) {
                            return shell.requestFullscreen();
                        }
                        if (shell.webkitRequestFullscreen) {
                            return shell.webkitRequestFullscreen();
                        }
                        if (shell.msRequestFullscreen) {
                            return shell.msRequestFullscreen();
                        }
                    };

                    const exitFullscreen = () => {
                        if (document.exitFullscreen) {
                            return document.exitFullscreen();
                        }
                        if (document.webkitExitFullscreen) {
                            return document.webkitExitFullscreen();
                        }
                        if (document.msExitFullscreen) {
                            return document.msExitFullscreen();
                        }
                    };

                    const isMapFullscreen = () => {
                        const fullscreenElement =
                            document.fullscreenElement ||
                            document.webkitFullscreenElement ||
                            document.msFullscreenElement ||
                            null;

                        return fullscreenElement === shell;
                    };

                    const syncFullscreenState = () => {
                        const fullscreen = isMapFullscreen();
                        shell.classList.toggle('is-browser-fullscreen', fullscreen);
                        window.dispatchEvent(new CustomEvent('map-fullscreen-change', {
                            detail: { mapId, isFullscreen: fullscreen }
                        }));
                        setTimeout(() => {
                            if (this.map) {
                                this.map.invalidateSize();
                            }
                        }, 180);
                    };

                    if (fullscreenBtn && !fullscreenBtn.dataset.geoFullscreenBound) {
                        fullscreenBtn.dataset.geoFullscreenBound = '1';
                        fullscreenBtn.addEventListener('click', () => {
                            if (isMapFullscreen()) {
                                exitFullscreen();
                            } else {
                                requestFullscreen();
                            }
                        });
                    }

                    if (!shell.dataset.geoFullscreenListenersBound) {
                        shell.dataset.geoFullscreenListenersBound = '1';
                        document.addEventListener('fullscreenchange', syncFullscreenState);
                        document.addEventListener('webkitfullscreenchange', syncFullscreenState);
                        document.addEventListener('msfullscreenchange', syncFullscreenState);
                    }

                    if (!shell._geoIntersectionObserver) {
                        shell._geoIntersectionObserver = new IntersectionObserver((entries) => {
                            entries.forEach((entry) => {
                                if (entry.isIntersecting && this.map) {
                                    setTimeout(() => this.map.invalidateSize(), 120);
                                }
                            });
                        }, { threshold: 0.1 });
                        shell._geoIntersectionObserver.observe(shell);
                    }
                },

                destroy() {
                    // Clean up map instance
                    if (this.map) {
                        this.map.remove();
                        this.map = null;
                    }
                    // Remove from global instances
                    if (window.geoMapInstances) {
                        delete window.geoMapInstances[mapId];
                    }
                },

                setInputValues(lat, lng, commit = false) {
                    const la = Math.round(lat * 1e6) / 1e6;
                    const ln = Math.round(lng * 1e6) / 1e6;
                    const latInput = document.getElementById(`${@js($statePath)}_latitude`);
                    const lngInput = document.getElementById(`${@js($statePath)}_longitude`);

                    this.currentLat = la;
                    this.currentLng = ln;
                    this.isProgrammaticInputUpdate = true;

                    if (latInput) {
                        latInput.value = String(la);
                        if (commit) {
                            latInput.dispatchEvent(new Event('change', { bubbles: true }));
                        }
                    }

                    if (lngInput) {
                        lngInput.value = String(ln);
                        if (commit) {
                            lngInput.dispatchEvent(new Event('change', { bubbles: true }));
                        }
                    }

                    // Clear flag after a microtask to ensure programmatic updates don't trigger reverse sync
                    queueMicrotask(() => {
                        this.isProgrammaticInputUpdate = false;
                    });
                },

                commitCoordinates(lat, lng, options = {}) {
                    const { updateInputs = true } = options;
                    const la = Math.round(lat * 1e6) / 1e6;
                    const ln = Math.round(lng * 1e6) / 1e6;

                    const latInput = document.getElementById(`${@js($statePath)}_latitude`);
                    const lngInput = document.getElementById(`${@js($statePath)}_longitude`);

                    if (updateInputs) {
                        this.setInputValues(la, ln, false);
                    }

                    // Trigger change event on inputs to activate wire:model.change
                    // This ensures proper Livewire sync without aggressive re-renders
                    if (latInput) {
                        latInput.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                    if (lngInput) {
                        lngInput.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                },

                setLoading(isLoading) {
                    this.loading = isLoading;
                    const btn = document.getElementById(btnId);
                    if (btn) {
                        if (isLoading) {
                            btn.setAttribute('disabled', '');
                        } else {
                            btn.removeAttribute('disabled');
                        }
                    }
                },
            };

            return component;
        };
    })();
</script>
