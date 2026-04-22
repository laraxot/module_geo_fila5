@php
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
];
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="{
            state: @entangle($statePath),
            searchQuery: '',
            searchResults: [],
            isSearching: false,
            showResults: false,
            isFullscreen: false,

            handleCoordsChanged(event) {
                this.state.latitude = event.detail.latitude;
                this.state.longitude = event.detail.longitude;

                @if($field->hasReverseGeocoding())
                void this.reverseGeocode(this.state.latitude, this.state.longitude);
                @endif
            },

            handleFullscreenChanged(event) {
                this.isFullscreen = event.detail.isFullscreen;
            },

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
                this.state.latitude = lat;
                this.state.longitude = lon;
                this.showResults = false;
                this.searchQuery = result.display_name;
                @if($field->hasReverseGeocoding())
                void this.reverseGeocode(lat, lon);
                @else
                this.state.address = result.display_name;
                @endif
            },

            async reverseGeocode(lat, lng) {
                try {
                    const result = await this.$wire.callSchemaComponentMethod('{{ $id }}', 'reverseGeocode', { latitude: lat, longitude: lng });
                    if (result) {
                        Object.assign(this.state, result);
                    }
                } catch (e) {}
            }
        }"
        class="coordinate-picker-field-wrapper space-y-2"
        @coords-changed.stop="handleCoordsChanged($event)"
        @fullscreen-changed.stop="handleFullscreenChanged($event)"
    >
        {{-- Search Input --}}
        <div class="relative items-center gap-2" x-show="!isFullscreen">
            <div class="relative group">
                <input type="text" x-model="searchQuery" @input.debounce.500ms="searchAddress()"
                    @keydown.escape="showResults = false"
                    placeholder="{{ __('geo::coordinate-picker.search_placeholder') }}"
                    class="fi-input block w-full border-none bg-white py-1.5 pl-10 pr-3 text-sm text-gray-950 shadow-sm ring-1 ring-gray-950/10 transition duration-75 focus-within:ring-2 focus-within:ring-primary-600 dark:bg-white/5 dark:text-white dark:ring-white/20 dark:focus-within:ring-primary-500 rounded-lg">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <x-heroicon-o-magnifying-glass class="h-4 w-4" />
                </div>
                <div x-show="isSearching" class="absolute right-3 top-1/2 -translate-y-1/2">
                    <x-filament::loading-indicator class="h-4 w-4" />
                </div>
            </div>

            {{-- Results Dropdown --}}
            <ul x-show="showResults" @click.away="showResults = false"
                class="absolute z-50 mt-1 max-h-60 w-full overflow-auto rounded-lg bg-white py-1 shadow-lg ring-1 ring-gray-950/5 dark:bg-gray-800 dark:ring-white/10">
                <template x-for="res in searchResults" :key="res.place_id">
                    <li @click="selectSearchResult(res)"
                        class="cursor-pointer px-4 py-2 text-sm text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-white/5">
                        <span x-text="res.display_name"></span>
                    </li>
                </template>
            </ul>
        </div>

        {{-- Lit Component --}}
        <coordinate-picker-lit :state="state" zoom="{{ $field->getZoom() }}"
            height="{{ $field->getHeight() }}" 
            geolocate-when-empty="{{ $field->getGeolocateWhenEmpty() }}"
            labels='@json($labels)'></coordinate-picker-lit>

        {{-- Readout Summary --}}
        <div
            class="rounded-lg bg-gray-50 p-2 text-[11px] text-gray-500 dark:bg-white/5 dark:border-white/10 border border-gray-100">
            <div class="flex flex-wrap gap-x-4">
                <span>Lat: <strong x-text="state.latitude ? Number(state.latitude).toFixed(6) : '--'"></strong></span>
                <span>Lng: <strong x-text="state.longitude ? Number(state.longitude).toFixed(6) : '--'"></strong></span>
            </div>
            <template x-if="state.address">
                <div class="mt-1 truncate max-w-full" :title="state.address">
                    <x-heroicon-o-map-pin class="inline-block h-3 w-3 mr-1" />
                    <span x-text="state.address"></span>
                </div>
            </template>
        </div>
    </div>
</x-dynamic-component>