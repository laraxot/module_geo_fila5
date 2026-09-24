<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Services;

use Modules\Geo\Services\GeoService;
use Modules\Geo\Services\GoogleMapsService;
use Modules\Geo\Services\HereService;
use PHPUnit\Framework\Assert;

test('GeoService can be resolved from container', function (): void {
    $service = app(GeoService::class);

    Assert::assertTrue($service instanceof GeoService);
});

test('GoogleMapsService can be resolved from container', function (): void {
    $service = app(GoogleMapsService::class);

    Assert::assertTrue($service instanceof GoogleMapsService);
});

test('HereService can be resolved from container', function (): void {
    $service = app(HereService::class);

    Assert::assertTrue($service instanceof HereService);
});
