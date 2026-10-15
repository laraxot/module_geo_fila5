<?php

declare(strict_types=1);

namespace Tests\Modules\Geo\Unit\Adapters;

use Modules\Geo\Adapters\GoogleMapsClient;
use PHPUnit\Framework\Assert;
use Tests\Modules\Geo\LightTestCase;

uses(LightTestCase::class);

it('can be instantiated as the Google Maps adapter', function (): void {
    Assert::assertInstanceOf(GoogleMapsClient::class, new GoogleMapsClient);
});

it('exposes the Google Maps operations', function (): void {
    $methods = get_class_methods(GoogleMapsClient::class);

    Assert::assertContains('reverseGeocode', $methods);
    Assert::assertContains('getDistanceMatrix', $methods);
    Assert::assertContains('getElevation', $methods);
});
