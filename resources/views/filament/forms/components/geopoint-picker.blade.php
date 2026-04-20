@php
    /** @var \Modules\Geo\Filament\Forms\Components\GeopointPicker $field */
    $statePath = $getStatePath();
    $state     = $getState() ?? [];
    $initLat   = $state['latitude'] ?? null;
    $initLng   = $state['longitude'] ?? null;
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        class="geopoint-picker-wrapper"
        wire:ignore.self
        x-data="{
            lat: @js($initLat),
            lng: @js($initLng),
            address: '',
            statePath: @js($statePath),

            get picker() { return this.$refs.picker; },

            syncToPicker(loc) {
                if (!this.picker || typeof this.picker.applyExternalLocation !== 'function') return;
                this.picker.applyExternalLocation(loc);
            },

            onLocationChanged(e) {
                const { latitude, longitude } = e.detail;
                this.lat = latitude;
                this.lng = longitude;
                this.$wire.set(this.statePath, { latitude, longitude });
            },

            init() {
                this.$nextTick(() => {
                    const current = this.$wire.get(this.statePath);
                    if (current) {
                        this.lat = current.latitude ?? this.lat;
                        this.lng = current.longitude ?? this.lng;
                    }
                    this.syncToPicker(current);
                });
                this.$wire.watch(this.statePath, (val) => {
                    if (val) {
                        this.lat = val.latitude ?? this.lat;
                        this.lng = val.longitude ?? this.lng;
                    }
                    this.syncToPicker(val);
                });
            }
        }"
        @location-changed.stop="onLocationChanged($event)"
    >
        {{-- Coordinate inputs --}}
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <x-filament::input.wrapper>
                    <x-filament::input
                        type="number"
                        step="0.000001"
                        placeholder="{{ __('geo::geopoint-picker.latitude') }}"
                        x-model.number.debounce.500ms="lat"
                        x-on:change="$wire.set(statePath + '.latitude', lat)"
                    />
                </x-filament::input.wrapper>
            </div>
            <div>
                <x-filament::input.wrapper>
                    <x-filament::input
                        type="number"
                        step="0.000001"
                        placeholder="{{ __('geo::geopoint-picker.longitude') }}"
                        x-model.number.debounce.500ms="lng"
                        x-on:change="$wire.set(statePath + '.longitude', lng)"
                    />
                </x-filament::input.wrapper>
            </div>
        </div>

        {{-- Indirizzo dedotto (reverse geocoding opzionale) --}}
        <p class="mb-2 text-sm text-gray-500 min-h-5" x-show="address" x-text="address"></p>

        {{-- Lit Web Component — UI-only, nessuna conoscenza di Livewire --}}
        <geopoint-picker-lit
            x-ref="picker"
            latitude="{{ $initLat }}"
            longitude="{{ $initLng }}"
            default-latitude="{{ $field->getDefaultLatitude() }}"
            default-longitude="{{ $field->getDefaultLongitude() }}"
            zoom="{{ $field->getZoom() }}"
            height="{{ $field->getHeight() }}"
            show-search="{{ $field->isSearchVisible() ? 'true' : 'false' }}"
            @location-changed.stop="onLocationChanged($event)"
            class="w-full"
        ></geopoint-picker-lit>

        @error($statePath.'.latitude')
            <p class="text-danger-600 text-xs mt-1">{{ $message }}</p>
        @enderror
        @error($statePath.'.longitude')
            <p class="text-danger-600 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
</x-dynamic-component>
