<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Geo\Models\BaseModel;
use Modules\Geo\Models\Location;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;

uses(TestCase::class);

describe('Location Business Logic', function () {
    test('location extends base model', function () {
        $parent = (new \ReflectionClass(Location::class))->getParentClass();
        Assert::assertInstanceOf(\ReflectionClass::class, $parent);
        Assert::assertSame(BaseModel::class, $parent->getName());
    });

    test('location has factory trait for testing', function () {
        $traits = class_uses(Location::class);

<<<<<<< HEAD
       Assert::assertArrayHasKey(HasFactory::class, $traits);
=======
        Assert::assertArrayHasKey(HasFactory::class, $traits);
>>>>>>> laraxot/dev
    });

    test('location can be queried within distance scope', function () {
        $query = Location::withinDistance(45.4642, 9.1900, 10.0);

<<<<<<< HEAD
       Assert::assertInstanceOf(Builder::class, $query);
=======
        Assert::assertInstanceOf(Builder::class, $query);
>>>>>>> laraxot/dev
    });

    test('location has geographic coordinate properties', function () {
        $location = new Location();
        $location->lat = 45.4642;
        $location->lng = 9.1900;

<<<<<<< HEAD
       Assert::assertSame(45.4642, $location->lat);
=======
        Assert::assertSame(45.4642, $location->lat);
>>>>>>> laraxot/dev
        Assert::assertSame(9.1900, $location->lng);
    });

    test('location can store address components', function () {
        $location = new Location();
        $location->street = 'Via Roma 123';
        $location->city = 'Milano';
        $location->state = 'Lombardia';
        $location->zip = '20121';

<<<<<<< HEAD
       Assert::assertSame('Via Roma 123', $location->street);
=======
        Assert::assertSame('Via Roma 123', $location->street);
>>>>>>> laraxot/dev
        Assert::assertSame('Milano', $location->city);
        Assert::assertSame('Lombardia', $location->state);
        Assert::assertSame('20121', $location->zip);
    });

    test('location has processing status tracking', function () {
        $location = new Location();
        $location->processed = true;

<<<<<<< HEAD
       Assert::assertSame(true, $location->processed);
=======
        Assert::assertSame(true, $location->processed);
>>>>>>> laraxot/dev
    });

    test('location can store formatted address', function () {
        $location = new Location();
        $location->formatted_address = 'Via Roma 123, 20121 Milano MI, Italy';

<<<<<<< HEAD
       Assert::assertSame('Via Roma 123, 20121 Milano MI, Italy', $location->formatted_address);
=======
        Assert::assertSame('Via Roma 123, 20121 Milano MI, Italy', $location->formatted_address);
>>>>>>> laraxot/dev
    });

    test('location can be queried by city', function () {
        $query = Location::whereCity('Milano');

<<<<<<< HEAD
       Assert::assertInstanceOf(Builder::class, $query);
=======
        Assert::assertInstanceOf(Builder::class, $query);
>>>>>>> laraxot/dev
    });

    test('location can be queried by coordinates', function () {
        $query = Location::whereLat(45.4642)->whereLng(9.1900);

<<<<<<< HEAD
       Assert::assertInstanceOf(Builder::class, $query);
=======
        Assert::assertInstanceOf(Builder::class, $query);
>>>>>>> laraxot/dev
    });

    test('location can be queried by processing status', function () {
        $query = Location::whereProcessed(true);

<<<<<<< HEAD
       Assert::assertInstanceOf(Builder::class, $query);
=======
        Assert::assertInstanceOf(Builder::class, $query);
>>>>>>> laraxot/dev
    });
});
