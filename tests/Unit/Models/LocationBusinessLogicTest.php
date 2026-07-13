<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Geo\Models\BaseModel;
use Modules\Geo\Models\Location;
<<<<<<< HEAD
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;

uses(TestCase::class);

describe('Location Business Logic', function () {
    test('location extends base model', function () {
        $parent = (new \ReflectionClass(Location::class))->getParentClass();
        Assert::assertInstanceOf(\ReflectionClass::class, $parent);
        Assert::assertSame(BaseModel::class, $parent->getName());
=======

describe('Location Business Logic', function () {
    test('location extends base model', function () {
        expect(Location::class)->toBeSubclassOf(BaseModel::class);
>>>>>>> laraxot/dev
    });

    test('location has factory trait for testing', function () {
        $traits = class_uses(Location::class);

<<<<<<< HEAD
        Assert::assertArrayHasKey(HasFactory::class, $traits);
=======
        expect($traits)->toHaveKey(HasFactory::class);
>>>>>>> laraxot/dev
    });

    test('location can be queried within distance scope', function () {
        $query = Location::withinDistance(45.4642, 9.1900, 10.0);

<<<<<<< HEAD
        Assert::assertInstanceOf(Builder::class, $query);
=======
        expect($query)->toBeInstanceOf(Builder::class);
>>>>>>> laraxot/dev
    });

    test('location has geographic coordinate properties', function () {
        $location = new Location();
        $location->lat = 45.4642;
        $location->lng = 9.1900;

<<<<<<< HEAD
        Assert::assertSame(45.4642, $location->lat);
        Assert::assertSame(9.1900, $location->lng);
=======
        expect($location->lat)->toBe(45.4642);
        expect($location->lng)->toBe(9.1900);
>>>>>>> laraxot/dev
    });

    test('location can store address components', function () {
        $location = new Location();
        $location->street = 'Via Roma 123';
        $location->city = 'Milano';
        $location->state = 'Lombardia';
        $location->zip = '20121';

<<<<<<< HEAD
        Assert::assertSame('Via Roma 123', $location->street);
        Assert::assertSame('Milano', $location->city);
        Assert::assertSame('Lombardia', $location->state);
        Assert::assertSame('20121', $location->zip);
=======
        expect($location->street)->toBe('Via Roma 123');
        expect($location->city)->toBe('Milano');
        expect($location->state)->toBe('Lombardia');
        expect($location->zip)->toBe('20121');
>>>>>>> laraxot/dev
    });

    test('location has processing status tracking', function () {
        $location = new Location();
        $location->processed = true;

<<<<<<< HEAD
        Assert::assertSame(true, $location->processed);
=======
        expect($location->processed)->toBe(true);
>>>>>>> laraxot/dev
    });

    test('location can store formatted address', function () {
        $location = new Location();
        $location->formatted_address = 'Via Roma 123, 20121 Milano MI, Italy';

<<<<<<< HEAD
        Assert::assertSame('Via Roma 123, 20121 Milano MI, Italy', $location->formatted_address);
=======
        expect($location->formatted_address)->toBe('Via Roma 123, 20121 Milano MI, Italy');
>>>>>>> laraxot/dev
    });

    test('location can be queried by city', function () {
        $query = Location::whereCity('Milano');

<<<<<<< HEAD
        Assert::assertInstanceOf(Builder::class, $query);
=======
        expect($query)->toBeInstanceOf(Builder::class);
>>>>>>> laraxot/dev
    });

    test('location can be queried by coordinates', function () {
        $query = Location::whereLat(45.4642)->whereLng(9.1900);

<<<<<<< HEAD
        Assert::assertInstanceOf(Builder::class, $query);
=======
        expect($query)->toBeInstanceOf(Builder::class);
>>>>>>> laraxot/dev
    });

    test('location can be queried by processing status', function () {
        $query = Location::whereProcessed(true);

<<<<<<< HEAD
        Assert::assertInstanceOf(Builder::class, $query);
=======
        expect($query)->toBeInstanceOf(Builder::class);
>>>>>>> laraxot/dev
    });
});
