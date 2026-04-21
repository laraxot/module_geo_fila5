<?php

declare(strict_types=1);

/** @var \Modules\Geo\Filament\Forms\Components\MapPicker $field */
$latitudeStatePath = $field->getLatitudeStatePath();
$longitudeStatePath = $field->getLongitudeStatePath();
$latitudeHasServerError = $errors->has($latitudeStatePath);
$longitudeHasServerError = $errors->has($longitudeStatePath);
?>

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        x-data="geoMapPickerField({
            latitude: $wire.entangle(@js($latitudeStatePath)).live,
            longitude: $wire.entangle(@js($longitudeStatePath)).live,
            geolocateWhenEmpty: @js($field->shouldGeolocateWhenEmpty()),
            reverseGeocoding: @js($field->shouldReverseGeocode()),
            zoom: @js($field->getZoom()),
            latitudeStatePath: @js($latitudeStatePath),
            longitudeStatePath: @js($longitudeStatePath),
            hasServerErrors: @js($latitudeHasServerError || $longitudeHasServerError),
        })"
        x-init="init()"
        class="geo-map-picker-input space-y-4"
    >
        <geo-map-picker
            x-ref="map"
            class="block"
            x-on:coords-changed="handleCoordsChanged($event)"
        ></geo-map-picker>

        <div class="grid gap-4 md:grid-cols-2">
            <label class="space-y-1">
                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Latitude</span>
                <input
                    type="number"
                    step="0.000001"
                    inputmode="decimal"
                    x-model.live="latitude"
                    class="block w-full rounded-lg border bg-white px-3 py-2 text-sm shadow-sm outline-none transition dark:bg-gray-900"
                    :class="inputClass(latitudeValid)"
                >
                @error($latitudeStatePath)
                    <span class="text-xs text-danger-600 dark:text-danger-400">{{ $message }}</span>
                @enderror
            </label>

            <label class="space-y-1">
                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Longitude</span>
                <input
                    type="number"
                    step="0.000001"
                    inputmode="decimal"
                    x-model.live="longitude"
                    class="block w-full rounded-lg border bg-white px-3 py-2 text-sm shadow-sm outline-none transition dark:bg-gray-900"
                    :class="inputClass(longitudeValid)"
                >
                @error($longitudeStatePath)
                    <span class="text-xs text-danger-600 dark:text-danger-400">{{ $message }}</span>
                @enderror
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
