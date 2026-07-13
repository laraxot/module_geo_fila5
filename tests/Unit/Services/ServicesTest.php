<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Services;

<<<<<<< HEAD
use Modules\Geo\Services\GeoService;
use Modules\Geo\Services\GoogleMapsService;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('GeoService can be instantiated', function () {
    $service = app(GeoService::class);

    Assert::assertInstanceOf(GeoService::class, $service);
=======
uses(\Modules\Geo\Tests\TestCase::class);

use Modules\Geo\Services\GeoService;
use Modules\Geo\Services\GoogleMapsService;
use Modules\Geo\Services\HereService;

test('GeoService can be instantiated', function () {
    $service = app(GeoService::class);

    expect($service)->toBeInstanceOf(GeoService::class);
>>>>>>> laraxot/dev
});

test('GoogleMapsService can be instantiated', function () {
    $service = app(GoogleMapsService::class);

<<<<<<< HEAD
    Assert::assertInstanceOf(GoogleMapsService::class, $service);
=======
    expect($service)->toBeInstanceOf(GoogleMapsService::class);
});

test('HereService can be instantiated', function () {
    $service = app(HereService::class);

    expect($service)->toBeInstanceOf(HereService::class);
>>>>>>> laraxot/dev
});
