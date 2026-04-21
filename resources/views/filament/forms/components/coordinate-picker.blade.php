@php
    /** @var \Modules\Geo\Filament\Forms\Components\CoordinatePicker $field */
    $statePath = $getStatePath();
    $state = $getState() ?? [];
    $latitude = $state['latitude'] ?? null;
    $longitude = $state['longitude'] ?? null;
    $fieldKey = $getKey();
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        class="coordinate-picker-wrapper"
        wire:ignore
        x-data="{
            statePath: @js($statePath),
            fieldKey: @js($fieldKey),
            address: '',
            lat: @js($latitude),
            lng: @js($longitude),
            hasReverse: @js($field->hasReverseGeocoding()),

            get picker() { return this.$el.querySelector('.coordinate-picker-core'); },

            onCoordsChanged(e) {
                const { latitude, longitude } = e.detail;
                this.lat = latitude;
                this.lng = longitude;
                // Livewire v4 API
                this.$wire.$set(this.statePath, { latitude, longitude }, false);

                if (this.hasReverse) {
                    this.updateAddress(latitude, longitude);
                }
            },

            async updateAddress(lat, lng) {
                const result = await this.$wire.callSchemaComponentMethod(this.fieldKey, 'reverseGeocode', { latitude: lat, longitude: lng });
                if (typeof result === 'string') {
                    this.address = result || 'Indirizzo non rilevato';
                    return;
                }

                if (result && typeof result === 'object') {
                    this.address = result.display_name ?? result.address ?? 'Indirizzo non rilevato';
                    return;
                }

                this.address = 'Indirizzo non rilevato';
            },

            init() {
                this.$wire.$watch(this.statePath, (value) => {
                    if (this.picker && typeof this.picker.applyExternalLocation === 'function') {
                        this.picker.applyExternalLocation(value ?? null);
                    }

                    if (value && typeof value === 'object') {
                        this.lat = value.latitude ?? null;
                        this.lng = value.longitude ?? null;
                    } else {
                        this.lat = null;
                        this.lng = null;
                    }
                });

                if ((!this.lat || !this.lng) && this.picker && typeof this.picker.autolocateWhenCoordinatesMissing === 'function') {
                    this.picker.autolocateWhenCoordinatesMissing();
                }
                
                if (this.lat && this.lng && this.hasReverse) {
                    this.updateAddress(this.lat, this.lng);
                }
            }
        }"
        @coords-changed="onCoordsChanged($event)"
    >
        {{-- Readout minimale e pulito --}}
        <div class="mb-3 flex flex-wrap items-center gap-4 text-sm bg-gray-50 dark:bg-gray-800/50 p-2 rounded-lg border border-gray-100 dark:border-gray-700">
            <template x-if="lat && lng">
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 w-full">
                    <span class="inline-flex items-center gap-1.5 px-2 py-1 bg-white dark:bg-gray-800 rounded shadow-sm border border-gray-200 dark:border-gray-600">
                        <span class="text-gray-400 font-mono text-xs">LAT</span>
                        <span x-text="lat.toFixed(6)" class="font-mono font-bold text-primary-600 dark:text-primary-400"></span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-2 py-1 bg-white dark:bg-gray-800 rounded shadow-sm border border-gray-200 dark:border-gray-600">
                        <span class="text-gray-400 font-mono text-xs">LNG</span>
                        <span x-text="lng.toFixed(6)" class="font-mono font-bold text-primary-600 dark:text-primary-400"></span>
                    </span>
                    <span x-show="address" class="text-gray-500 dark:text-gray-400 italic truncate flex-1" x-text="address"></span>
                </div>
            </template>
            <template x-if="!lat || !lng">
                <div class="flex items-center gap-2 text-amber-600 dark:text-amber-400 py-1">
                    <span>⚠️</span>
                    <span class="italic font-medium">Nessuna coordinata impostata. Clicca sulla mappa o usa la tua posizione.</span>
                </div>
            </template>
        </div>

        <coordinate-picker-field
            class="coordinate-picker-core w-full block"
            latitude="{{ is_numeric($latitude) ? (string) $latitude : 'NaN' }}"
            longitude="{{ is_numeric($longitude) ? (string) $longitude : 'NaN' }}"
            default-latitude="{{ $field->getLatitude() }}"
            default-longitude="{{ $field->getLongitude() }}"
            zoom="{{ $field->getZoom() }}"
            height="{{ $field->getHeight() }}"
        ></coordinate-picker-field>

        {{-- Validazione feedback --}}
        @error($statePath)
            <p class="text-danger-600 text-xs mt-2 font-medium">{{ $message }}</p>
        @enderror
    </div>
</x-dynamic-component>
