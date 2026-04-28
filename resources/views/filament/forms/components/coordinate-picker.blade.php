@php
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
];
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="{
            state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
            searchQuery: '',
            searchResults: [],
            isSearching: false,
            showResults: false,
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
                const { lat, lng } = event.detail;
                
                this.state = {
                    ...(this.state ?? {}),
                    lat: lat,
                    lng: lng,
                };

                @if($field->hasReverseGeocoding())
                void this.reverseGeocode(lat, lng);
                @endif
                
                setTimeout(() => { this._suppressUpdate = false; }, 350);
            },

            handleFullscreenChanged(event) {
                this.isFullscreen = event.detail.isFullscreen;
            },

            async searchAddress() {
                if (this.searchQuery.length < 3) {
                    this.showResults = false;
                    return;
                }
                this.isSearching = true;
                try {
                    this.searchResults = await this.$wire.callSchemaComponentMethod(@js($key), 'searchAddress', { query: this.searchQuery }) || [];
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
                if (picker) {
                    picker.setCoordinates(lat, lon, 'search');
                }
                
                this.state = { 
                    ...(this.state ?? {}), 
                    lat: lat, 
                    lng: lon,
                    address: result.display_name 
                };
                
                @if($field->hasReverseGeocoding())
                void this.reverseGeocode(lat, lon);
                @endif
            },

            async reverseGeocode(lat, lng) {
                try {
                    const result = await this.$wire.callSchemaComponentMethod(@js($key), 'reverseGeocode', { lat: lat, lng: lng });
                    if (result) {
                        this.state = { ...(this.state ?? {}), ...result };
                    }
                } catch (e) {}
            }
        }"
        class="coordinate-picker-field-wrapper space-y-2"
        @coords-changed.stop="handleCoordsChanged($event)"
        @fullscreen-changed.stop="handleFullscreenChanged($event)"
    >
        {{-- Search Input --}}
        <div class="relative w-full">
            <div class="relative">
                <input type="text"
                    x-model="searchQuery"
                    @input.debounce.500ms="searchAddress()"
                    @keydown.escape="showResults = false"
                    placeholder="{{ __('geo::coordinate-picker.search_placeholder') }}"
                    autocomplete="off"
                    class="w-full rounded-lg border border-gray-300 py-2 pl-10 pr-4 text-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/30 dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                >
                <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <x-heroicon-o-magnifying-glass class="h-4 w-4" />
                </span>
                <span x-show="isSearching" class="absolute inset-y-0 right-3 flex items-center">
                    <svg class="h-4 w-4 animate-spin text-gray-400" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                </span>
            </div>

            <ul x-show="showResults"
                x-transition
                class="absolute z-50 mt-1 w-full overflow-hidden rounded-lg border border-gray-200 bg-white shadow-lg dark:bg-gray-800 dark:border-gray-700"
                @click.outside="showResults = false"
            >
                <template x-for="(result, idx) in searchResults" :key="idx">
                    <li class="cursor-pointer px-4 py-2 text-sm text-gray-700 hover:bg-primary/10 dark:text-gray-300 dark:hover:bg-primary/20"
                        @click="selectSearchResult(result)"
                        x-text="result.display_name"
                    ></li>
                </template>
            </ul>
        </div>

        {{-- Lit Component Map --}}
        <div wire:ignore class="map-container-wrapper overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700" 
             :style="{ height: isFullscreen ? '100vh' : '{{ $field->getHeight() }}' }">
            <coordinate-picker-lit
                :lat="state?.lat"
                :lng="state?.lng"
                zoom="{{ $field->getZoom() }}"
                @if($field->getGeolocateWhenEmpty()) geolocate-when-empty @endif
                .labels='@json($labels)'
            ></coordinate-picker-lit>
        </div>

        {{-- Readout Summary --}}
        <div class="rounded-lg bg-gray-50 p-2 text-[11px] text-gray-500 dark:bg-white/5 dark:border-white/10 border border-gray-100">
            <div class="flex flex-wrap gap-x-4">
                <span>Lat: <strong x-text="state.lat ? Number(state.lat).toFixed(6) : '--'"></strong></span>
                <span>Lng: <strong x-text="state.lng ? Number(state.lng).toFixed(6) : '--'"></strong></span>
            </div>
            <template x-if="state.address">
                <div class="mt-1 truncate max-w-full" :title="state.address">
                    <x-heroicon-o-map-pin class="inline-block h-3 w-3 mr-1" />
                    <span x-text="state.address"></span>
                </div>
            </template>
        </div>

        {{-- Accessibility Live Region --}}
        <div aria-live="polite" class="sr-only">
            <span x-text="`Lat: ${state.lat || '--'}, Lng: ${state.lng || '--'}${state.address ? ', Address: ' + state.address : ''}`"></span>
        </div>
    </div>
</x-dynamic-component>
