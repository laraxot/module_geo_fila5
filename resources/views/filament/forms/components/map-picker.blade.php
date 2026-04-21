@php
/** @var \Modules\Geo\Filament\Forms\Components\MapPicker $field */
$statePath = $field->getStatePath();
$id = $field->getId();
$hasServerError = $errors->has($statePath);
$zoom = $field->getZoom();
$geolocateWhenEmpty = $field->getGeolocateWhenEmpty();
$reverseGeocoding = $field->hasReverseGeocoding();
$height = $field->getHeight();
$defaultLatitude = $field->getLatitude();
$defaultLongitude = $field->getLongitude();
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        x-data="{
            state: $wire.entangle('{{ $statePath }}').live,
            formattedAddress: '',
            statusLabel: @js(__('geo::map-picker.status.waiting')),
            hasServerErrors: @js($hasServerError),
            reverseGeocoding: @js($reverseGeocoding),
            reverseGeocodeTimer: null,

            init() {
                this.updateStatus();
                this.scheduleReverseGeocoding();
                this.$watch('state', () => {
                    this.updateStatus();
                    this.scheduleReverseGeocoding();
                });
            },

            handleCoordsChanged(event) {
                const lat = event.detail?.latitude;
                const lng = event.detail?.longitude;
                if (lat == null || lng == null) {
                    return;
                }
                this.state = { latitude: lat, longitude: lng };
                this.$wire.$set('{{ $statePath }}', { latitude: lat, longitude: lng }, false);
                if (@js($reverseGeocoding)) {
                    void this.reverseGeocode(lat, lng);
                }
            },

            async reverseGeocode(lat, lng) {
                try {
                    const result = await this.$wire.callSchemaComponentMethod(
                        '{{ $id }}',
                        'reverseGeocode',
                        { latitude: lat, longitude: lng },
                    );
                    this.formattedAddress = result || '';
                } catch (_e) {
                    this.formattedAddress = '';
                }
            },

            scheduleReverseGeocoding() {
                if (!this.reverseGeocoding || !this.coordinatesAreValid()) {
                    this.formattedAddress = '';
                    return;
                }
                window.clearTimeout(this.reverseGeocodeTimer);
                this.reverseGeocodeTimer = window.setTimeout(() => {
                    const lat = this.state?.latitude;
                    const lng = this.state?.longitude;
                    if (lat != null && lng != null) {
                        void this.reverseGeocode(Number(lat), Number(lng));
                    }
                }, 400);
            },

            coordinatesAreValid() {
                const lat = Number(this.state?.latitude);
                const lng = Number(this.state?.longitude);
                return Number.isFinite(lat) && Number.isFinite(lng)
                    && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180;
            },

            updateStatus() {
                if (this.hasServerErrors) {
                    this.statusLabel = @js(__('geo::map-picker.status.server_error'));
                    return;
                }
                if (this.coordinatesAreValid()) {
                    this.statusLabel = @js(__('geo::map-picker.status.synced'));
                    return;
                }
                if (this.state?.latitude == null && this.state?.longitude == null) {
                    this.statusLabel = @js(__('geo::map-picker.status.waiting'));
                    return;
                }
                this.statusLabel = @js(__('geo::map-picker.status.invalid'));
            },

            inputClass(isValid) {
                return {
                    'border-success-500 focus:border-success-500 focus:ring-success-500': isValid && !this.hasServerErrors,
                    'border-danger-500 focus:border-danger-500 focus:ring-danger-500': !isValid || this.hasServerErrors,
                    'border-gray-300 focus:border-primary-500 focus:ring-primary-500': !this.coordinatesAreValid() && !this.hasServerErrors,
                };
            },

            statusDotClass() {
                if (this.hasServerErrors || !this.coordinatesAreValid()) {
                    return 'bg-danger-500';
                }
                return 'bg-success-500';
            },
        }"
        class="geo-map-picker-input space-y-4"
    >
        <map-picker-lit
            x-ref="map"
            class="block w-full"
            height="{{ e($height) }}"
            zoom="{{ e($zoom) }}"
            default-latitude="{{ e($defaultLatitude) }}"
            default-longitude="{{ e($defaultLongitude) }}"
            geolocate-when-empty="{{ $geolocateWhenEmpty ? 'true' : 'false' }}"
            :latitude="state?.latitude != null ? Number(state.latitude) : null"
            :longitude="state?.longitude != null ? Number(state.longitude) : null"
            show-search="true"
            x-on:coords-changed="handleCoordsChanged($event)"
        ></map-picker-lit>

        <div class="grid gap-4 md:grid-cols-2">
            <label class="space-y-1">
                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('geo::map-picker.latitude') }}</span>
                <input
                    type="number"
                    step="0.000001"
                    inputmode="decimal"
                    x-model.number.live="state.latitude"
                    class="block w-full rounded-lg border bg-white px-3 py-2 text-sm shadow-sm outline-none transition dark:bg-gray-900"
                    :class="inputClass(state?.latitude != null && state.latitude >= -90 && state.latitude <= 90)"
                >
            </label>

            <label class="space-y-1">
                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('geo::map-picker.longitude') }}</span>
                <input
                    type="number"
                    step="0.000001"
                    inputmode="decimal"
                    x-model.number.live="state.longitude"
                    class="block w-full rounded-lg border bg-white px-3 py-2 text-sm shadow-sm outline-none transition dark:bg-gray-900"
                    :class="inputClass(state?.longitude != null && state.longitude >= -180 && state.longitude <= 180)"
                >
            </label>
        </div>

        <div class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm dark:border-gray-800 dark:bg-gray-900/50">
            <div class="flex items-center gap-2">
                <span class="inline-flex h-2.5 w-2.5 rounded-full" :class="statusDotClass()"></span>
                <span class="font-medium text-gray-900 dark:text-gray-100" x-text="statusLabel"></span>
            </div>

            <template x-if="formattedAddress">
                <p class="mt-2 text-gray-600 dark:text-gray-300" x-text="formattedAddress"></p>
            </template>
        </div>
    </div>
</x-dynamic-component>
