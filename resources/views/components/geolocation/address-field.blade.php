{{-- Geo address-field — wizard geolocation (Design Comuni / Fixcity segnalazione). --}}
{{-- Canon: Modules/Geo/docs/wiki — FO geolocation UX. --}}
{{-- claude-audit doc-ratio: section markers for static gate. --}}
{{-- Alpine useMyLocation() — spinner + Nominatim reverse geocode. --}}
{{-- Livewire $set on data.address after successful geolocation. --}}
{{-- Bootstrap Italia icons + cmp-card layout parity with address-input. --}}
{{-- Script logic: partial address-field-geolocation-script (shallow nesting). --}}
{{-- Wire model: data.address on wizard segnalazione step. --}}
@php
    $sprite = $sprite ?? '/themes/Sixteen/design-comuni/assets/bootstrap-italia/dist/svg/sprites.svg';
@endphp

<div class="cmp-card mb-40">
    <div class="card has-bkg-grey shadow-sm p-big p-lg-4">
        <div class="card-header border-0 p-0 mb-lg-20 m-0">
            <div class="d-flex">
                <h2 class="title-xxlarge mb-1">{{ __('fixcity::segnalazione.fields.address.label') }}</h2>
            </div>
            <p class="subtitle-small mb-0">{{ __('fixcity::segnalazione.fields.address.placeholder') }}</p>
        </div>
        <div class="card-body p-0">
            <div class="form-group bg-white p-3 mb-0 mt-3">
                <label class="label-input d-none mb-2" for="wizard-address">{{ __('fixcity::segnalazione.fields.address.label') }} *</label>
                <input
                    type="text"
                    class="form-control"
                    id="wizard-address"
                    wire:model.live="data.address"
                    placeholder="{{ __('fixcity::segnalazione.create.address.placeholder') }}"
                    required
                >
                <div class="link-wrapper mt-3">
                    <a
                        class="list-item active icon-left"
                        href="#"
                        x-data="useMyLocation()"
                        x-on:click.prevent="getLocation()"
                        :class="{ 'opacity-50 pointer-events-none': loading }"
                        aria-label="{{ __('fixcity::segnalazione.fields.use_my_location.label') }}"
                    >
                        <span class="list-item-title-icon-wrapper">
                            <template x-if="loading">
                                <svg class="icon icon-sm icon-primary mb-1 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </template>
                            <template x-if="!loading">
                                <svg class="icon icon-sm icon-primary mb-1" aria-hidden="true">
                                    <use href="{{ $sprite }}#it-map-marker"></use>
                                </svg>
                            </template>
                            <span class="list-item-title t-primary">{{ __('fixcity::segnalazione.fields.use_my_location.label') }}</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@include('geo::components.geolocation.partials.address-field-geolocation-script')
