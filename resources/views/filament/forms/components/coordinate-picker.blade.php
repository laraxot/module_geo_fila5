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
                this.state = {
                    ...(this.state ?? {}),
                    latitude: event.detail.latitude,
                    longitude: event.detail.longitude,
                };

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
            },

            async reverseGeocode(lat, lng) {
                try {
                    const result = await this.$wire.callSchemaComponentMethod('{{ $id }}', 'reverseGeocode', { latitude: lat, longitude: lng });
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
        @include('geo::filament.components.address-search-input')

        {{-- Lit Component --}}
        {{-- 🛡️ wire:ignore CRITICAL: prevents Livewire from destroying map DOM on re-renders --}}
        <div wire:ignore class="map-container-wrapper" style="height: {{ $field->getHeight() }}px;">
            <coordinate-picker-lit
                :state="state"
                zoom="{{ $field->getZoom() }}"
                @if($field->getGeolocateWhenEmpty()) geolocate-when-empty @endif
                labels='@json($labels)'
            ></coordinate-picker-lit>
        </div>

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
