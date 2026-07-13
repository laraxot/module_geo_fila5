<?php

declare(strict_types=1);

use Modules\Geo\Adapters\GoogleMapsClient;

beforeEach(function () {
    $this->service = new GoogleMapsClient();
});

test('google maps client can be instantiated', function () {
    expect($this->service)->toBeInstanceOf(GoogleMapsClient::class);
});

test('google maps client has expected public methods', function () {
    expect(method_exists(GoogleMapsClient::class, 'reverseGeocode'))->toBeTrue();
    expect(method_exists(GoogleMapsClient::class, 'getDistanceMatrix'))->toBeTrue();
    expect(method_exists(GoogleMapsClient::class, 'getElevation'))->toBeTrue();
});

test('google maps client exposes geocoding methods', function () {
    expect(method_exists($this->service, 'reverseGeocode'))->toBeTrue();
    expect(method_exists($this->service, 'getDistanceMatrix'))->toBeTrue();
    expect(method_exists($this->service, 'getElevation'))->toBeTrue();
});
