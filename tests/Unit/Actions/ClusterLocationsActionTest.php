<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use Modules\Geo\Actions\ClusterLocationsAction;
<<<<<<< HEAD
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Exceptions\InvalidLocationException;
use Modules\Geo\Tests\Fixtures\ClusterDistanceStub;
use Modules\Geo\Tests\Fixtures\FixedPairDistanceStub;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('clusters locations that are close together', function (): void {
    $location1 = new LocationData(latitude: 45.4642, longitude: 9.1900);
    $location2 = new LocationData(latitude: 45.4643, longitude: 9.1901);
    $location3 = new LocationData(latitude: 46.4642, longitude: 10.1900);

    $clusters = (new ClusterLocationsAction(new ClusterDistanceStub()))->execute(
        [$location1, $location2, $location3],
        1.0,
    );

    Assert::assertCount(2, $clusters);
    Assert::assertCount(2, $clusters[0]['points']);
    Assert::assertCount(1, $clusters[1]['points']);
=======
use Modules\Geo\Contracts\CalculateDistanceActionContract;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Exceptions\InvalidLocationException;
use Modules\Geo\Tests\TestCase;

uses(TestCase::class);
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.

it('clusters locations that are close together', function (): void {
    $location1 = new LocationData(latitude: 45.4642, longitude: 9.1900);
    $location2 = new LocationData(latitude: 45.4643, longitude: 9.1901); // Very close
    $location3 = new LocationData(latitude: 46.4642, longitude: 10.1900); // Far away

    $locations = [$location1, $location2, $location3];

    // Create a mock CalculateDistanceAction
    $mockDistanceCalculator = Mockery::mock(CalculateDistanceActionContract::class);
    $mockDistanceCalculator->shouldReceive('execute')->withAnyArgs()->andReturn(['distance' => ['value' => 150000]]);
    $mockDistanceCalculator->shouldReceive('execute')
        ->with(Mockery::on(function ($arg1) use ($location1, $location2) {
            return ($arg1->latitude === $location1->latitude && $arg1->longitude === $location1->longitude)
                || ($arg1->latitude === $location2->latitude && $arg1->longitude === $location2->longitude);
        }), Mockery::on(function ($arg2) use ($location1, $location2) {
            return ($arg2->latitude === $location1->latitude && $arg2->longitude === $location1->longitude)
                || ($arg2->latitude === $location2->latitude && $arg2->longitude === $location2->longitude);
        }))
        ->andReturn(['distance' => ['value' => 100]]); // 100 meters (within 1km)

    $action = new ClusterLocationsAction($mockDistanceCalculator);

    $clusters = $action->execute($locations, 1.0); // 1km max distance

    expect($clusters)->toHaveCount(2); // Should have 2 clusters: [loc1,loc2] and [loc3]
    expect($clusters[0]['points'])->toHaveCount(2); // First cluster should have 2 points
    expect($clusters[1]['points'])->toHaveCount(1); // Second cluster should have 1 point
>>>>>>> laraxot/dev
});

it('creates separate clusters for distant locations', function (): void {
    $location1 = new LocationData(latitude: 45.4642, longitude: 9.1900);
<<<<<<< HEAD
    $location2 = new LocationData(latitude: 47.0000, longitude: 11.0000);

    $clusters = (new ClusterLocationsAction(new FixedPairDistanceStub(200000)))->execute(
        [$location1, $location2],
        1.0,
    );

    Assert::assertCount(2, $clusters);
    Assert::assertCount(1, $clusters[0]['points']);
    Assert::assertCount(1, $clusters[1]['points']);
});

function invokeClusterLocations(ClusterLocationsAction $action, mixed $locations, float $maxDistance = 1.0): mixed
{
    $method = new \ReflectionMethod(ClusterLocationsAction::class, 'execute');

    return $method->invoke($action, $locations, $maxDistance);
}

it('throws exception when location is null', function (): void {
    $action = new ClusterLocationsAction(new FixedPairDistanceStub(1000));

    try {
        invokeClusterLocations($action, [null]);
        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertSame('Dati della posizione non validi', $exception->getMessage());
    }
});

it('throws exception when location is string', function (): void {
    $action = new ClusterLocationsAction(new FixedPairDistanceStub(1000));

    try {
        invokeClusterLocations($action, ['not a location']);
        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertSame('Dati della posizione non validi', $exception->getMessage());
    }
});

it('throws exception when location is integer', function (): void {
    $action = new ClusterLocationsAction(new FixedPairDistanceStub(1000));

    try {
        invokeClusterLocations($action, [123]);
        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertSame('Dati della posizione non validi', $exception->getMessage());
=======
    $location2 = new LocationData(latitude: 47.0000, longitude: 11.0000); // Very far away
    $locations = [$location1, $location2];

    $mockDistanceCalculator = Mockery::mock(CalculateDistanceActionContract::class);
    $mockDistanceCalculator->shouldReceive('execute')
        ->with($location1, $location2)
        ->andReturn(['distance' => ['value' => 200000]]); // 200km

    $action = new ClusterLocationsAction($mockDistanceCalculator);

    $clusters = $action->execute($locations, 1.0);

    expect($clusters)->toHaveCount(2); // Should have 2 separate clusters
    expect($clusters[0]['points'])->toHaveCount(1);
    expect($clusters[1]['points'])->toHaveCount(1);
});

it('throws exception when location is not LocationData', function (): void {
    $mockDistanceCalculator = Mockery::mock(CalculateDistanceActionContract::class);
    $action = new ClusterLocationsAction($mockDistanceCalculator);

    $invalidLocations = [null, 'not a location', 123];

    foreach ($invalidLocations as $invalidLocation) {
        expect(fn () => $action->execute([$invalidLocation]))
            ->toThrow(InvalidLocationException::class);
>>>>>>> laraxot/dev
    }
});

it('handles single location correctly', function (): void {
    $location = new LocationData(latitude: 45.4642, longitude: 9.1900);
<<<<<<< HEAD
    $clusters = (new ClusterLocationsAction(new FixedPairDistanceStub(100)))->execute([$location], 1.0);

    Assert::assertCount(1, $clusters);
    Assert::assertCount(1, $clusters[0]['points']);
    Assert::assertSame($location, $clusters[0]['points'][0]);
});

it('handles empty locations array', function (): void {
    Assert::assertCount(0, (new ClusterLocationsAction(new FixedPairDistanceStub(100)))->execute([], 1.0));
=======
    $locations = [$location];

    $mockDistanceCalculator = Mockery::mock(CalculateDistanceActionContract::class);
    $action = new ClusterLocationsAction($mockDistanceCalculator);

    $clusters = $action->execute($locations, 1.0);

    expect($clusters)->toHaveCount(1);
    expect($clusters[0]['points'])->toHaveCount(1);
    expect($clusters[0]['points'][0])->toBe($location);
});

it('handles empty locations array', function (): void {
    $mockDistanceCalculator = Mockery::mock(CalculateDistanceActionContract::class);
    $action = new ClusterLocationsAction($mockDistanceCalculator);

    $clusters = $action->execute([], 1.0);

    expect($clusters)->toBeArray()->toHaveCount(0);
>>>>>>> laraxot/dev
});

it('works with different max distance parameter', function (): void {
    $location1 = new LocationData(latitude: 45.4642, longitude: 9.1900);
<<<<<<< HEAD
    $location2 = new LocationData(latitude: 45.4700, longitude: 9.1950);
    $stub = new FixedPairDistanceStub(1500);

    Assert::assertCount(1, (new ClusterLocationsAction($stub))->execute([$location1, $location2], 2.0));
    Assert::assertCount(2, (new ClusterLocationsAction($stub))->execute([$location1, $location2], 1.0));
=======
    $location2 = new LocationData(latitude: 45.4700, longitude: 9.1950); // About 1km apart
    $locations = [$location1, $location2];

    // Create calculator mock for this test
    $mockDistanceCalculator = Mockery::mock(CalculateDistanceActionContract::class);
    $mockDistanceCalculator->shouldReceive('execute')
        ->andReturn(['distance' => ['value' => 1500]]); // 1.5km

    $action = new ClusterLocationsAction($mockDistanceCalculator);

    // With 2km max distance, they should be in same cluster
    $clusters = $action->execute($locations, 2.0);
    expect($clusters)->toHaveCount(1);
    expect($clusters[0]['points'])->toHaveCount(2);

    // With 1km max distance, they should be in separate clusters
    $mockDistanceCalculator2 = Mockery::mock(CalculateDistanceActionContract::class);
    $mockDistanceCalculator2->shouldReceive('execute')
        ->andReturn(['distance' => ['value' => 1500]]); // 1.5km

    $action2 = new ClusterLocationsAction($mockDistanceCalculator2);

    $clusters = $action2->execute($locations, 1.0);
    expect($clusters)->toHaveCount(2);
>>>>>>> laraxot/dev
});

it('updates cluster centers correctly', function (): void {
    $location1 = new LocationData(latitude: 45.0, longitude: 9.0);
    $location2 = new LocationData(latitude: 46.0, longitude: 10.0);
<<<<<<< HEAD

    $clusters = (new ClusterLocationsAction(new FixedPairDistanceStub(100)))->execute(
        [$location1, $location2],
        5.0,
    );

    Assert::assertCount(1, $clusters);
    $center = $clusters[0]['center'];
    Assert::assertInstanceOf(LocationData::class, $center);
    Assert::assertSame(45.5, $center->latitude);
    Assert::assertSame(9.5, $center->longitude);
=======
    $locations = [$location1, $location2];

    // Create calculator mock for this test
    $mockDistanceCalculator = Mockery::mock(CalculateDistanceActionContract::class);
    $mockDistanceCalculator->shouldReceive('execute')
        ->andReturn(['distance' => ['value' => 100]]); // 100m

    $action = new ClusterLocationsAction($mockDistanceCalculator);

    $clusters = $action->execute($locations, 5.0); // 5km max distance

    expect($clusters)->toHaveCount(1);

    // The center should be the average of the two locations
    $center = $clusters[0]['center'];
    expect($center->latitude)->toBe(45.5); // average of 45 and 46
    expect($center->longitude)->toBe(9.5); // average of 9 and 10
>>>>>>> laraxot/dev
});
