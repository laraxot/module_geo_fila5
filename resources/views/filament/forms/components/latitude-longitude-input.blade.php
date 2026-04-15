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
    $btnId = 'btn-geo-locate-'.$getId();
    $defaultLat = 41.9028; // Rome as default
    $defaultLng = 12.4964;
    $defaultZoom = 13;
    $height = '340px';
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
        .latitude-longitude-map-canvas .leaflet-container {
            font-family: inherit;
            border-radius: 0.25rem;
        }
    </style>
@endonce

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div class="cmp-card">
        <div class="card has-bkg-grey shadow-sm p-big p-lg-4">
            <div class="card-header border-0 p-0 mb-lg-20 m-0">
                <div class="d-flex">
                    <h2 class="title-xxlarge mb-1">{{ $getLabel() }}</h2>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="form-group bg-white p-3 mb-0 mt-3">
                    <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                        <button
                            type="button"
                            class="btn btn-sm btn-outline-primary"
                            id="{{ $btnId }}"
                        >
                            {{ __('geo::address.fields.use_my_location.label') }}
                        </button>
                        <span class="text-muted small">{{ __('geo::leaflet_map.hint.interaction') }}</span>
                    </div>

                    <div
                        wire:ignore
                        id="{{ $mapId }}"
                        class="rounded border border-light w-100 latitude-longitude-map-canvas"
                        style="min-height: {{ $height }}; z-index: 1;"
                    ></div>

                    <div class="form-group bg-white p-3 mb-0 mt-3">
                        <div class="row">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="{{ $statePath }}_latitude" class="form-label">
                                    {{ __('geo::coordinates.fields.latitude.label') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <svg class="icon icon-sm" aria-hidden="true">
                                            <use href="{{ $sprite }}#it-arrow-up"></use>
                                        </svg>
                                    </span>
                                    <input
                                        type="number"
                                        step="0.00001"
                                        min="-90"
                                        max="90"
                                        wire:model.live="{{ $statePath }}.latitude"
                                        id="{{ $statePath }}_latitude"
                                        class="form-control @error($statePath . '.latitude') is-invalid @enderror"
                                        placeholder="{{ __('geo::coordinates.fields.latitude.placeholder') }}"
                                        required
                                    >
                                </div>
                                @error($statePath . '.latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">{{ __('geo::coordinates.fields.latitude.help') }}</small>
                            </div>
                            <div class="col-md-6">
                                <label for="{{ $statePath }}_longitude" class="form-label">
                                    {{ __('geo::coordinates.fields.longitude.label') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <svg class="icon icon-sm" aria-hidden="true">
                                            <use href="{{ $sprite }}#it-arrow-right"></use>
                                        </svg>
                                    </span>
                                    <input
                                        type="number"
                                        step="0.00001"
                                        min="-180"
                                        max="180"
                                        wire:model.live="{{ $statePath }}.longitude"
                                        id="{{ $statePath }}_longitude"
                                        class="form-control @error($statePath . '.longitude') is-invalid @enderror"
                                        placeholder="{{ __('geo::coordinates.fields.longitude.placeholder') }}"
                                        required
                                    >
                                </div>
                                @error($statePath . '.longitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">{{ __('geo::coordinates.fields.longitude.help') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dynamic-component>

<script>
    (function () {
        function round6(n) {
            return Math.round(Number(n) * 1e6) / 1e6;
        }

        function setCoords(wire, latPath, lngPath, lat, lng) {
            var la = round6(lat);
            var ln = round6(lng);
            if (wire) {
                if (typeof wire.set === 'function') {
                    wire.set(latPath, la);
                    wire.set(lngPath, ln);
                } else if (typeof wire.$set === 'function') {
                    wire.$set(latPath, la);
                    wire.$set(lngPath, ln);
                }
            }
        }

        function boot() {
            var L = window.L;
            if (!L) {
                return;
            }
            var el = document.getElementById(@json($mapId));
            if (!el || el.getAttribute('data-geo-leaflet-ready') === '1') {
                return;
            }
            el.setAttribute('data-geo-leaflet-ready', '1');

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

            var btn = document.getElementById(@json($btnId));
            if (btn && navigator.geolocation) {
                btn.addEventListener('click', function () {
                    navigator.geolocation.getCurrentPosition(
                        function (pos) {
                            var ll = [pos.coords.latitude, pos.coords.longitude];
                            map.setView(ll, Math.max(map.getZoom(), 15));
                            marker.setLatLng(ll);
                            setCoords(wire, latPath, lngPath, ll[0], ll[1]);
                        },
                        function () {
                            alert(@json(__('geo::address.geolocation.error')));
                        },
                        { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
                    );
                });
            } else if (btn) {
                btn.disabled = true;
                btn.classList.add('opacity-50');
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