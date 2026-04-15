@php
    use Illuminate\Support\Str;
    $statePath = $getStatePath();
    $prefixPath = Str::beforeLast((string) $statePath, '.');
    $latPath = $prefixPath.'.'.$field->getLatitudeField();
    $lngPath = $prefixPath.'.'.$field->getLongitudeField();
    $lw = $field->getLivewire();
    /** @var array<string, mixed>|null $root */
    $root = $lw->data ?? null;
    $scopeKey = Str::after($prefixPath, 'data.');
    $initialLat = $root !== null ? data_get($root, $scopeKey.'.'.$field->getLatitudeField()) : null;
    $initialLng = $root !== null ? data_get($root, $scopeKey.'.'.$field->getLongitudeField()) : null;
    $mapId = 'leaflet-marker-map-'.$getId();
    $shellId = 'leaflet-marker-map-shell-'.$getId();
    $btnLocateId = 'btn-geo-locate-'.$getId();
    $btnFullscreenId = 'btn-geo-fullscreen-'.$getId();
    $defaultLat = $field->getDefaultLatitude();
    $defaultLng = $field->getDefaultLongitude();
    $defaultZoom = $field->getDefaultZoom();
    $height = $field->getMapHeight();
@endphp

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
        .leaflet-marker-map-canvas .leaflet-container {
            font-family: inherit;
            border-radius: 0.25rem;
        }
        .leaflet-marker-map-controls .btn {
            min-width: 2.25rem;
            min-height: 2.25rem;
            padding: 0.25rem 0.35rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endonce

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div class="leaflet-marker-map-input space-y-2">
        <p class="text-muted small mb-0">{{ __('geo::leaflet_map.hint.interaction') }}</p>

        <div
            wire:ignore
            id="{{ $shellId }}"
            class="leaflet-marker-map-shell position-relative rounded border border-light w-100 overflow-hidden bg-white"
            style="min-height: {{ $height }};"
        >
            <div
                id="{{ $mapId }}"
                class="w-100 leaflet-marker-map-canvas"
                style="height: {{ $height }}; min-height: {{ $height }}; z-index: 1;"
            ></div>
            <div
                class="leaflet-marker-map-controls position-absolute top-0 end-0 p-2 d-flex flex-column gap-1"
                style="z-index: 1000;"
            >
                <button
                    type="button"
                    class="btn btn-sm btn-light border shadow-sm"
                    id="{{ $btnLocateId }}"
                    title="{{ __('geo::leaflet_map.actions.locate.label') }}"
                    aria-label="{{ __('geo::leaflet_map.actions.locate.label') }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                    </svg>
                </button>
                <button
                    type="button"
                    class="btn btn-sm btn-light border shadow-sm"
                    id="{{ $btnFullscreenId }}"
                    data-fullscreen-enter="{{ __('geo::leaflet_map.actions.fullscreen.enter') }}"
                    data-fullscreen-exit="{{ __('geo::leaflet_map.actions.fullscreen.exit') }}"
                    title="{{ __('geo::leaflet_map.actions.fullscreen.enter') }}"
                    aria-label="{{ __('geo::leaflet_map.actions.fullscreen.enter') }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16" class="geo-icon-fullscreen-enter" aria-hidden="true">
                        <path d="M1.5 1a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H3.707l3.147 3.146a.5.5 0 0 1-.708.708L3 2.707V4.5a.5.5 0 0 1-1 0v-3zm9.5.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0V2.707l-3.146 3.147a.5.5 0 0 1-.708-.708L13.293 2H11.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V2.707l-3.146 3.147a.5.5 0 0 1-.708.708L9.293 2H11.5a.5.5 0 0 1 0-1h-4a.5.5 0 0 1-.5.5v4a.5.5 0 0 1-1 0v-4z"/>
                        <path d="M1.5 1a.5.5 0 0 0-.5.5v4a.5.5 0 0 0 1 0v-2.293l3.146 3.147a.5.5 0 0 0 .708-.708L2.707 2H4.5a.5.5 0 0 0 0-1h-3zm14.5-.5a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0V2.707l-3.146 3.147a.5.5 0 0 1-.708-.708L13.293 2H11.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V2.707l-3.146 3.147a.5.5 0 0 1-.708.708L9.293 2H11.5a.5.5 0 0 1 0-1h-4a.5.5 0 0 1-.5.5v4a.5.5 0 0 1-1 0v-4a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-2.293l3.146 3.147a.5.5 0 0 0 .708-.708L8.293 2H10.5a.5.5 0 0 0 0-1H6a.5.5 0 0 0-.5.5v4a.5.5 0 0 1-1 0v-4z"/>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16" class="geo-icon-fullscreen-exit d-none" aria-hidden="true">
                        <path d="M5.5 0a.5.5 0 0 1 .5.5v4A1.5 1.5 0 0 1 4.5 6h-4a.5.5 0 0 1 0-1h4a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 1 .5-.5zm5 0a.5.5 0 0 1 .5.5v4a.5.5 0 0 0 .5.5h4a.5.5 0 0 1 0 1h-4A1.5 1.5 0 0 1 10 4.5v-4a.5.5 0 0 1 .5-.5zM0 10.5a.5.5 0 0 1 .5-.5h4A1.5 1.5 0 0 1 6 11.5v4a.5.5 0 0 1-1 0v-4a.5.5 0 0 0-.5-.5h-4a.5.5 0 0 1-.5-.5zm10 1a1.5 1.5 0 0 1 1.5-1.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 0-.5.5v4a.5.5 0 0 1-1 0v-4z"/>
                    </svg>
                </button>
            </div>
        </div>

        @error($latPath)
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
        @error($lngPath)
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <script>
        (function () {
            function round6(n) {
                return Math.round(Number(n) * 1e6) / 1e6;
            }

            function setCoords(wire, latPath, lngPath, lat, lng) {
                var la = round6(lat);
                var ln = round6(lng);
                if (typeof wire.set === 'function') {
                    wire.set(latPath, la);
                    wire.set(lngPath, ln);
                } else if (typeof wire.$set === 'function') {
                    wire.$set(latPath, la);
                    wire.$set(lngPath, ln);
                }
            }

            function requestFs(el) {
                if (el.requestFullscreen) {
                    return el.requestFullscreen();
                }
                if (el.webkitRequestFullscreen) {
                    return el.webkitRequestFullscreen();
                }
                if (el.msRequestFullscreen) {
                    return el.msRequestFullscreen();
                }
                return Promise.reject();
            }

            function exitFs() {
                if (document.exitFullscreen) {
                    return document.exitFullscreen();
                }
                if (document.webkitExitFullscreen) {
                    return document.webkitExitFullscreen();
                }
                if (document.msExitFullscreen) {
                    return document.msExitFullscreen();
                }
                return Promise.reject();
            }

            function getFullscreenElement() {
                return (
                    document.fullscreenElement ||
                    document.webkitFullscreenElement ||
                    document.msFullscreenElement ||
                    null
                );
            }

            function syncFullscreenButton(btn) {
                if (!btn) {
                    return;
                }
                var enter = btn.getAttribute('data-fullscreen-enter') || '';
                var exit = btn.getAttribute('data-fullscreen-exit') || '';
                var shell = document.getElementById(@json($shellId));
                var fsEl = getFullscreenElement();
                var active = Boolean(shell && fsEl === shell);
                btn.querySelectorAll('.geo-icon-fullscreen-enter').forEach(function (n) {
                    n.classList.toggle('d-none', active);
                });
                btn.querySelectorAll('.geo-icon-fullscreen-exit').forEach(function (n) {
                    n.classList.toggle('d-none', !active);
                });
                btn.setAttribute('title', active ? exit : enter);
                btn.setAttribute('aria-label', active ? exit : enter);
            }

            function boot() {
                var L = window.L;
                if (!L) {
                    return;
                }
                var el = document.getElementById(@json($mapId));
                var shell = document.getElementById(@json($shellId));
                if (!el || !shell) {
                    return;
                }

                if (el._geoLeafletMap) {
                    setTimeout(function () {
                        el._geoLeafletMap.invalidateSize();
                    }, 200);
                    return;
                }

                var wire = @this;
                var latPath = @json($latPath);
                var lngPath = @json($lngPath);
                var defaultLat = @json($defaultLat);
                var defaultLng = @json($defaultLng);
                var defaultZoom = @json($defaultZoom);
                var initialLat = @json($initialLat);
                var initialLng = @json($initialLng);

                var lat = parseFloat(initialLat);
                var lng = parseFloat(initialLng);
                if (!Number.isFinite(lat) || !Number.isFinite(lng)) {
                    lat = defaultLat;
                    lng = defaultLng;
                    setCoords(wire, latPath, lngPath, lat, lng);
                }

                var map = L.map(el).setView([lat, lng], defaultZoom);
                el._geoLeafletMap = map;

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                    maxZoom: 19,
                }).addTo(map);

                var marker = L.marker([lat, lng], { draggable: true }).addTo(map);

                marker.on('dragend', function (e) {
                    var p = e.target.getLatLng();
                    setCoords(wire, latPath, lngPath, p.lat, p.lng);
                });

                map.on('click', function (e) {
                    marker.setLatLng(e.latlng);
                    setCoords(wire, latPath, lngPath, e.latlng.lat, e.latlng.lng);
                });

                var btnLocate = document.getElementById(@json($btnLocateId));
                if (btnLocate && navigator.geolocation) {
                    btnLocate.addEventListener('click', function () {
                        navigator.geolocation.getCurrentPosition(
                            function (pos) {
                                var ll = [pos.coords.latitude, pos.coords.longitude];
                                map.setView(ll, Math.max(map.getZoom(), 15));
                                marker.setLatLng(ll);
                                setCoords(wire, latPath, lngPath, ll[0], ll[1]);
                                setTimeout(function () {
                                    map.invalidateSize();
                                }, 100);
                            },
                            function () {
                                alert(@json(__('geo::address.geolocation.error')));
                            },
                            { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
                        );
                    });
                } else if (btnLocate) {
                    btnLocate.disabled = true;
                    btnLocate.classList.add('opacity-50');
                    btnLocate.title = @json(__('geo::address.geolocation.error'));
                }

                var btnFs = document.getElementById(@json($btnFullscreenId));
                if (btnFs) {
                    syncFullscreenButton(btnFs);
                    btnFs.addEventListener('click', function () {
                        var fsEl = getFullscreenElement();
                        if (fsEl === shell) {
                            exitFs().catch(function () {});
                        } else {
                            requestFs(shell).catch(function () {});
                        }
                    });
                    document.addEventListener('fullscreenchange', function () {
                        syncFullscreenButton(btnFs);
                        setTimeout(function () {
                            map.invalidateSize();
                        }, 200);
                    });
                    document.addEventListener('webkitfullscreenchange', function () {
                        syncFullscreenButton(btnFs);
                        setTimeout(function () {
                            map.invalidateSize();
                        }, 200);
                    });
                }

                if (!shell._geoIntersectionObserver) {
                    shell._geoIntersectionObserver = new IntersectionObserver(
                        function (entries) {
                            entries.forEach(function (entry) {
                                if (entry.isIntersecting && el._geoLeafletMap) {
                                    setTimeout(function () {
                                        el._geoLeafletMap.invalidateSize();
                                    }, 150);
                                }
                            });
                        },
                        { threshold: 0.05 }
                    );
                    shell._geoIntersectionObserver.observe(shell);
                }

                setTimeout(function () {
                    map.invalidateSize();
                }, 400);
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', boot);
            } else {
                boot();
            }

            document.addEventListener('livewire:navigated', boot);
        })();
    </script>
</x-dynamic-component>
