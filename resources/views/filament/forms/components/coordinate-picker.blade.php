@php
/** @var \Modules\Geo\Filament\Forms\Components\CoordinatePicker $field */
$statePath = $field->getStatePath();
$id = $field->getId();
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="{
            state: $wire.entangle('{{ $statePath }}'),
            address: '',

            init() {
                // Initial sync handled by web component updated() via properties if passed
            },

            handleCoordsChanged(event) {
                const { latitude, longitude, source } = event.detail;

                // Avoid spamming Livewire during drag, but update local state so watchers work
                // Use false for 'live' to avoid constant server roundtrips if not needed
                this.state = { latitude, longitude };

                if (source === 'drag' || source === 'click' || source === 'geolocation') {
                    // Force Livewire sync on important events
                    this.$wire.$set('{{ $statePath }}', { latitude, longitude }, false);
                }

                if (@js($field->hasReverseGeocoding())) {
                    this.reverseGeocode(latitude, longitude);
                }
            },

            async reverseGeocode(lat, lng) {
                if (!lat || !lng) return;
                try {
                    // Call the exposed Livewire method
                    const result = await this.$wire.callSchemaComponentMethod('{{ $id }}', 'reverseGeocode', { latitude: lat, longitude: lng });
                    this.address = result || '';
                } catch (e) {
                    this.address = '';
                }
            }
        }" class="coordinate-picker-field-wrapper space-y-2">
        {{-- The Web Component Core --}}
        <coordinate-picker-lit x-ref="picker" :latitude="state?.latitude" :longitude="state?.longitude"
            :zoom="@js($field->getZoom())" :height="@js($field->getHeight())"
            @coords-changed="handleCoordsChanged"></coordinate-picker-lit>

        {{-- Status Readout & Feedbacks --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-[10px] sm:text-xs text-gray-500 bg-gray-50 p-2 rounded-md border border-gray-100">
            <div class="flex gap-3 sm:gap-4">
                <span>Lat: <strong class="text-gray-700"
                        x-text="state?.latitude ? state.latitude.toFixed(6) : '--'"></strong></span>
                <span>Lng: <strong class="text-gray-700"
                        x-text="state?.longitude ? state.longitude.toFixed(6) : '--'"></strong></span>
            </div>
            <div class="truncate max-w-full sm:max-w-[250px]" x-show="address">
                <span x-text="address"></span>
            </div>
            <template x-if="!state?.latitude">
                <span class="text-warning-600 italic">Posizione non impostata</span>
            </template>
        </div>

    </div>
</x-dynamic-component>