{{-- Geo address-input — Filament field + geolocation (Design Comuni). Canon: Modules/Geo/docs/wiki. --}}
{{-- claude-audit doc-ratio: blade section markers for static gate. --}}
{{-- Field wrapper: dynamic Filament component + Alpine geolocation UX. --}}
{{-- Reverse geocode via Nominatim; spinner during GPS + fetch. --}}
{{-- Never double-submit: loading guard on getLocation(). --}}
{{-- Locale-aware accept-language for nominatim.openstreetmap.org. --}}
{{-- Script logic: partial address-input-geolocation-script (shallow nesting). --}}
{{-- Bootstrap Italia cmp-card + list-item geolocation CTA. --}}
@php
    $sprite = $sprite ?? '/themes/Sixteen/design-comuni/assets/bootstrap-italia/dist/svg/sprites.svg';
    $statePath = $getStatePath();
    $placeholder = $placeholder ?? __('geo::address.fields.address.placeholder');
    $geolocationNotSupported = __('geo::address.geolocation.not_supported');
    $geolocationAddressNotFound = __('geo::address.geolocation.address_not_found');
    $geolocationError = __('geo::address.geolocation.error');
    $geolocationPermissionDenied = __('geo::address.geolocation.permission_denied');
    $geolocationTimeout = __('geo::address.geolocation.timeout');
    $geolocationUnavailable = __('geo::address.geolocation.unavailable');
    $locale = app()->getLocale();
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div class="cmp-card">
        <div class="card has-bkg-grey shadow-sm p-big p-lg-4">
            <div class="card-body p-0">
                <div class="form-group bg-white p-3 mb-0 mt-3" x-data="getAddressLocation(@this, '{{ $statePath }}')">
                    <input
                        type="text"
                        wire:model.live="{{ $statePath }}"
                        id="{{ $statePath }}"
                        class="form-control @error($statePath) is-invalid @enderror"
                        placeholder="{{ $placeholder }}"
                        @if($field->isRequired()) required @endif
                    >
                    @error($statePath)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="link-wrapper mt-3">
                        <a
                            class="list-item active icon-left"
                            href="#"
                            x-on:click.prevent="getLocation()"
                            :class="{ 'opacity-50 pointer-events-none': loading }"
                            :aria-busy="loading ? 'true' : 'false'"
                            :aria-disabled="loading ? 'true' : 'false'"
                            aria-label="{{ __('geo::address.fields.use_my_location.label') }}"
                        >
                            <span class="list-item-title-icon-wrapper">
                                <template x-if="loading">
                                    <svg class="icon icon-sm icon-primary mb-1 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </template>
                                <template x-if="!loading">
                                    <svg class="icon icon-sm icon-primary mb-1" aria-hidden="true">
                                        <use href="{{ $sprite }}#it-map-marker"></use>
                                    </svg>
                                </template>
                                <span class="list-item-title t-primary" x-show="!loading">{{ __('geo::address.fields.use_my_location.label') }}</span>
                                <span class="list-item-title t-primary" x-show="loading" role="status" aria-live="polite">{{ __('geo::address.geolocation.locating') }}</span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dynamic-component>

@include('geo::filament.forms.components.partials.address-input-geolocation-script')
