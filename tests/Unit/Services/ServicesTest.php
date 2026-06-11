<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Services;

uses(\Modules\Geo\Tests\TestCase::class);

use Exception;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use PHPUnit\Framework\Assert;
use Modules\Geo\Services\GeoService;
use Modules\Geo\Services\GoogleMapsService;
use Modules\Geo\Services\HereService;
use Modules\Geo\Tests\TestCase;
test('GeoService can be instantiated', function () {
    $service = app(GeoService::class);

    Assert::assertInstanceOf(GeoService::class, $service);
});

test('GoogleMapsService can be instantiated', function () {
    $service = app(GoogleMapsService::class);

    Assert::assertInstanceOf(GoogleMapsService::class, $service);
});

test('HereService can be instantiated', function () {
    $service = app(HereService::class);

    Assert::assertInstanceOf(HereService::class, $service);
});
