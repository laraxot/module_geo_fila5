<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Services;

<<<<<<< HEAD
use ReflectionClass;
=======
>>>>>>> laraxot/dev
use Modules\Geo\Services\GoogleMapsService;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('can be instantiated', function (): void {
    Assert::assertInstanceOf(GoogleMapsService::class, new GoogleMapsService());
});

it('has correct constants defined', function (): void {
<<<<<<< HEAD
    $reflection = new ReflectionClass(GoogleMapsService::class);
=======
    $reflection = new \ReflectionClass(GoogleMapsService::class);
>>>>>>> laraxot/dev
    Assert::assertTrue($reflection->hasConstant('GEOCODING_URL'));
    Assert::assertTrue($reflection->hasConstant('DISTANCE_MATRIX_URL'));
    Assert::assertTrue($reflection->hasConstant('ELEVATION_URL'));

    // Test that the constants have the correct values
    Assert::assertSame('https://maps.googleapis.com/maps/api/geocode/json', $reflection->getConstant('GEOCODING_URL'));
    Assert::assertSame('https://maps.googleapis.com/maps/api/distancematrix/json', $reflection->getConstant('DISTANCE_MATRIX_URL'));
    Assert::assertSame('https://maps.googleapis.com/maps/api/elevation/json', $reflection->getConstant('ELEVATION_URL'));
});

it('has required methods', function (): void {
    $methods = get_class_methods(new GoogleMapsService());
    Assert::assertContains('reverseGeocode', $methods);
    Assert::assertContains('getDistanceMatrix', $methods);
    Assert::assertContains('getElevation', $methods);
});
