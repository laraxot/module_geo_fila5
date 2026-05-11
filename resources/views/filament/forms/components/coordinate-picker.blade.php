@php
<<<<<<< HEAD
/**
 * CoordinatePicker Blade View
 * Path: laravel/Modules/Geo/resources/views/filament/forms/components/coordinate-picker.blade.php
 * 
 * @var \Modules\Geo\Filament\Forms\Components\CoordinatePicker $field
 */
$statePath = $getStatePath();
$key = $getKey();

$labels = [
    'zoom_in' => __('geo::coordinate-picker.zoom_in'),
    'zoom_out' => __('geo::coordinate-picker.zoom_out'),
    'fullscreen' => __('geo::coordinate-picker.fullscreen'),
    'close_fullscreen'=> __('geo::coordinate-picker.close_fullscreen'),
    'use_location' => __('geo::coordinate-picker.use_my_location'),
    'locating' => __('geo::coordinate-picker.locating'),
    'layers' => [
        'street' => __('geo::coordinate-picker.layers.street'),
        'humanitarian' => __('geo::coordinate-picker.layers.humanitarian'),
        'satellite' => __('geo::coordinate-picker.layers.satellite'),
        'topographic' => __('geo::coordinate-picker.layers.topographic'),
    ],
=======
/** @var \Modules\Geo\Filament\Forms\Components\CoordinatePicker $field */
$statePath = $field->getStatePath();
$id = $field->getId();

$labels = [
'zoom_in' => __('geo::coordinate-picker.zoom_in'),
'zoom_out' => __('geo::coordinate-picker.zoom_out'),
'fullscreen' => __('geo::coordinate-picker.fullscreen'),
'close_fullscreen'=> __('geo::coordinate-picker.close_fullscreen'),
'use_location' => __('geo::coordinate-picker.use_my_location'),
'locating' => __('geo::coordinate-picker.locating'),
>>>>>>> c3b9b5924 (.)
];
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="{
<<<<<<< HEAD
            state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
            isFullscreen: false,
            _suppressUpdate: false,

            init() {
                this.$watch('state', (val) => {
                    if (this._suppressUpdate) return;
                    // Force re-sync to Lit if state changes externally
                    const picker = this.$el.querySelector('coordinate-picker-lit');
                    if (picker && val) {
                        picker.lat = val.lat;
                        picker.lng = val.lng;
                    }
                });
            },

            handleCoordsChanged(event) {
                this._suppressUpdate = true;
                const lat = event.detail.lat ?? event.detail.latitude;
                const lng = event.detail.lng ?? event.detail.longitude;

                if (!Number.isFinite(Number(lat)) || !Number.isFinite(Number(lng))) {
                    this._suppressUpdate = false;
                    return;
                }
                
                this.state = {
                    ...(this.state ?? {}),
                    lat: lat,
                    lng: lng,
                    latitude: lat,
                    longitude: lng,
                };
                this.$wire.set(@js($statePath . '.lat'), lat, false);
                this.$wire.set(@js($statePath . '.lng'), lng, false);
                this.$wire.set(@js($statePath . '.latitude'), lat, false);
                this.$wire.set(@js($statePath . '.longitude'), lng, false);

                @if($field->hasReverseGeocoding())
                void this.reverseGeocode(lat, lng);
                @endif
                
                setTimeout(() => { this._suppressUpdate = false; }, 350);
=======
            state: @entangle($statePath),
            searchQuery: '',
            searchResults: [],
            isSearching: false,
            showResults: false,
            isFullscreen: false,

            handleCoordsChanged(event) {
                this.state = {
                    ...(this.state ?? {}),
                    latitude: event.detail.latitude,
                    longitude: event.detail.longitude,
                };

                @if($field->hasReverseGeocoding())
                void this.reverseGeocode(this.state.latitude, this.state.longitude);
                @endif
>>>>>>> c3b9b5924 (.)
            },

            handleFullscreenChanged(event) {
                this.isFullscreen = event.detail.isFullscreen;
            },

<<<<<<< HEAD
            handleAddressSelected(event) {
                const address = event.detail.address || event.detail.result?.display_name || '';
                if (!address) return;
                this.state = {
                    ...(this.state ?? {}),
                    address: address,
                };
                this.$wire.set(@js($statePath . '.address'), address, false);
=======
            async searchAddress() {
                if (this.searchQuery.length < 3) return;
                this.isSearching = true;
                try {
                    this.searchResults = await this.$wire.callSchemaComponentMethod('{{ $id }}', 'searchAddress', { query: this.searchQuery }) || [];
                    this.showResults = this.searchResults.length > 0;
                } finally {
                    this.isSearching = false;
                }
            },

            selectSearchResult(result) {
                const lat = parseFloat(result.lat);
                const lon = parseFloat(result.lon);
                this.showResults = false;
                this.searchQuery = result.display_name;

                const picker = this.$el.querySelector('coordinate-picker-lit');
                if (picker && typeof picker.setCoordinates === 'function') {
                    picker.setCoordinates(lat, lon, 'search');
                } else {
                    this.state = { ...(this.state ?? {}), latitude: lat, longitude: lon };
                    @if($field->hasReverseGeocoding())
                    void this.reverseGeocode(lat, lon);
                    @else
                    this.state = { ...(this.state ?? {}), address: result.display_name };
                    @endif
                }
>>>>>>> c3b9b5924 (.)
            },

            async reverseGeocode(lat, lng) {
                try {
<<<<<<< HEAD
                    const result = await this.$wire.callSchemaComponentMethod(@js($key), 'reverseGeocode', { lat: lat, lng: lng });
                    if (result) {
                        this.state = { ...(this.state ?? {}), ...result };
                        Object.entries(result).forEach(([key, value]) => {
                            this.$wire.set(`${@js($statePath)}.${key}`, value, false);
                        });
=======
                    const result = await this.$wire.callSchemaComponentMethod('{{ $id }}', 'reverseGeocode', { latitude: lat, longitude: lng });
                    if (result) {
                        this.state = { ...(this.state ?? {}), ...result };
>>>>>>> c3b9b5924 (.)
                    }
                } catch (e) {}
            }
        }"
        class="coordinate-picker-field-wrapper space-y-2"
        @coords-changed.stop="handleCoordsChanged($event)"
        @fullscreen-changed.stop="handleFullscreenChanged($event)"
<<<<<<< HEAD
        @address-selected.stop="handleAddressSelected($event)"
    >
        {{-- Lit Component Map --}}
        <div wire:ignore class="map-container-wrapper overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700" 
             :style="{ height: isFullscreen ? '100vh' : '{{ $field->getHeight() }}' }">
            <coordinate-picker-lit
                :lat="state?.lat ?? state?.latitude"
                :lng="state?.lng ?? state?.longitude"
                .state="state"
                zoom="{{ $field->getZoom() }}"
                @if($field->getGeolocateWhenEmpty()) geolocate-when-empty @endif
                .labels='@json($labels)'
=======
    >
        @include('geo::filament.components.address-search-input')

        {{-- Lit Component --}}
        {{-- 🛡️ wire:ignore CRITICAL: prevents Livewire from destroying map DOM on re-renders --}}
        <div wire:ignore class="map-container-wrapper" style="height: {{ $field->getHeight() }}px;">
            <coordinate-picker-lit
                :state="state"
                zoom="{{ $field->getZoom() }}"
                @if($field->getGeolocateWhenEmpty()) geolocate-when-empty @endif
                labels='@json($labels)'
>>>>>>> c3b9b5924 (.)
            ></coordinate-picker-lit>
        </div>

        {{-- Readout Summary --}}
<<<<<<< HEAD
        <div class="rounded-lg bg-gray-50 p-2 text-[11px] text-gray-500 dark:bg-white/5 dark:border-white/10 border border-gray-100">
            <div class="flex flex-wrap gap-x-4">
                <span>Lat: <strong x-text="(state.lat ?? state.latitude) ? Number(state.lat ?? state.latitude).toFixed(6) : '--'"></strong></span>
                <span>Lng: <strong x-text="(state.lng ?? state.longitude) ? Number(state.lng ?? state.longitude).toFixed(6) : '--'"></strong></span>
=======
        <div
            class="rounded-lg bg-gray-50 p-2 text-[11px] text-gray-500 dark:bg-white/5 dark:border-white/10 border border-gray-100">
            <div class="flex flex-wrap gap-x-4">
                <span>Lat: <strong x-text="state.latitude ? Number(state.latitude).toFixed(6) : '--'"></strong></span>
                <span>Lng: <strong x-text="state.longitude ? Number(state.longitude).toFixed(6) : '--'"></strong></span>
>>>>>>> c3b9b5924 (.)
            </div>
            <template x-if="state.address">
                <div class="mt-1 truncate max-w-full" :title="state.address">
                    <x-heroicon-o-map-pin class="inline-block h-3 w-3 mr-1" />
                    <span x-text="state.address"></span>
                </div>
            </template>
        </div>
<<<<<<< HEAD

        {{-- Accessibility Live Region --}}
        <div aria-live="polite" class="sr-only">
            <span x-text="`Lat: ${state.lat || '--'}, Lng: ${state.lng || '--'}${state.address ? ', Address: ' + state.address : ''}`"></span>
        </div>
=======
>>>>>>> c3b9b5924 (.)
    </div>
</x-dynamic-component>
