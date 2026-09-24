<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Services;

use Modules\Geo\Services\GoogleMapsService;
use PHPUnit\Framework\Assert;
use ReflectionClass;

it('has correct API endpoint constants', function (): void {
    $reflection = new ReflectionClass(GoogleMapsService::class);

    Assert::assertSame(
        'https://maps.googleapis.com/maps/api/geocode/json',
        $reflection->getConstant('GEOCODING_URL'),
    );
    Assert::assertSame(
        'https://maps.googleapis.com/maps/api/distancematrix/json',
        $reflection->getConstant('DISTANCE_MATRIX_URL'),
    );
    Assert::assertSame(
        'https://maps.googleapis.com/maps/api/elevation/json',
        $reflection->getConstant('ELEVATION_URL'),
    );
});
