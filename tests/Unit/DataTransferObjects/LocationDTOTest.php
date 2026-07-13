<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\DataTransferObjects;

use Modules\Geo\Datas\LocationData;
use Modules\Geo\DataTransferObjects\LocationDTO;
<<<<<<< HEAD
use PHPUnit\Framework\Assert;
=======
>>>>>>> laraxot/dev

describe('LocationDTO', function () {
    test('can be instantiated with required fields', function () {
        $dto = new LocationDTO(
            latitude: 41.9028,
            longitude: 12.4964,
        );

<<<<<<< HEAD
        Assert::assertInstanceOf(LocationDTO::class, $dto);

        Assert::assertSame(41.9028, $dto->latitude);

        Assert::assertSame(12.4964, $dto->longitude);

        Assert::assertNull($dto->name);
=======
        expect($dto)->toBeInstanceOf(LocationDTO::class)
            ->and($dto->latitude)->toBe(41.9028)
            ->and($dto->longitude)->toBe(12.4964)
            ->and($dto->name)->toBeNull();
>>>>>>> laraxot/dev
    });

    test('can be instantiated with optional name', function () {
        $dto = new LocationDTO(
            latitude: 41.9028,
            longitude: 12.4964,
            name: 'Rome',
        );

<<<<<<< HEAD
        Assert::assertSame('Rome', $dto->name);
=======
        expect($dto->name)->toBe('Rome');
>>>>>>> laraxot/dev
    });

    test('fromLocationData creates instance from LocationData', function () {
        $locationData = new LocationData(
            latitude: 45.4654,
            longitude: 9.1866,
            name: 'Milan',
            address: 'Via Roma',
        );

        $dto = LocationDTO::fromLocationData($locationData);

<<<<<<< HEAD
        Assert::assertInstanceOf(LocationDTO::class, $dto);

        Assert::assertSame(45.4654, $dto->latitude);

        Assert::assertSame(9.1866, $dto->longitude);

        Assert::assertSame('Milan', $dto->name);
=======
        expect($dto)->toBeInstanceOf(LocationDTO::class)
            ->and($dto->latitude)->toBe(45.4654)
            ->and($dto->longitude)->toBe(9.1866)
            ->and($dto->name)->toBe('Milan');
>>>>>>> laraxot/dev
    });

    test('toLocationData converts to LocationData instance', function () {
        $dto = new LocationDTO(
            latitude: 45.4654,
            longitude: 9.1866,
            name: 'Milan',
        );

        $locationData = $dto->toLocationData();

<<<<<<< HEAD
        Assert::assertInstanceOf(LocationData::class, $locationData);

        Assert::assertSame(45.4654, $locationData->latitude);

        Assert::assertSame(9.1866, $locationData->longitude);

        Assert::assertSame('Milan', $locationData->name);

        Assert::assertNull($locationData->address);
=======
        expect($locationData)->toBeInstanceOf(LocationData::class)
            ->and($locationData->latitude)->toBe(45.4654)
            ->and($locationData->longitude)->toBe(9.1866)
            ->and($locationData->name)->toBe('Milan')
            ->and($locationData->address)->toBeNull();
>>>>>>> laraxot/dev
    });

    test('properties are readonly via readonly class', function () {
        $dto = new LocationDTO(latitude: 41.9028, longitude: 12.4964);
<<<<<<< HEAD
        $reflection = new \ReflectionClass($dto);

        Assert::assertTrue($reflection->isReadOnly());
=======

        expect(fn () => $dto->latitude = 0.0)
            ->toThrow(Error::class);
>>>>>>> laraxot/dev
    });

    test('round trip fromLocationData -> toLocationData preserves data', function () {
        $original = new LocationData(
            latitude: 43.7696,
            longitude: 11.2558,
            name: 'Florence',
            address: 'Piazza del Duomo',
        );

        $dto = LocationDTO::fromLocationData($original);
        $converted = $dto->toLocationData();

<<<<<<< HEAD
        Assert::assertSame($original->latitude, $converted->latitude);

        Assert::assertSame($original->longitude, $converted->longitude);

        Assert::assertSame($original->name, $converted->name);
=======
        expect($converted->latitude)->toBe($original->latitude)
            ->and($converted->longitude)->toBe($original->longitude)
            ->and($converted->name)->toBe($original->name);
>>>>>>> laraxot/dev
    });

    test('handles null name in LocationData', function () {
        $locationData = new LocationData(
            latitude: 41.9028,
            longitude: 12.4964,
        );

        $dto = LocationDTO::fromLocationData($locationData);

<<<<<<< HEAD
        Assert::assertNull($dto->name);
=======
        expect($dto->name)->toBeNull();
>>>>>>> laraxot/dev
    });
});
