<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

use Modules\Geo\Models\County;
use Modules\Geo\Models\GeoNamesCap;
use Modules\Geo\Models\Locality;
use Modules\Geo\Models\Place;
use Modules\Geo\Models\PlaceType;
use Modules\Geo\Models\State;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('State model can be instantiated', function () {
    $state = new State();

    Assert::assertInstanceOf(State::class, $state);
});

test('County model can be instantiated', function () {
    $county = new County();

<<<<<<< HEAD
   Assert::assertInstanceOf(County::class, $county);
=======
    Assert::assertInstanceOf(County::class, $county);
>>>>>>> laraxot/dev
});

test('Locality model can be instantiated', function () {
    $locality = new Locality();

<<<<<<< HEAD
   Assert::assertInstanceOf(Locality::class, $locality);
=======
    Assert::assertInstanceOf(Locality::class, $locality);
>>>>>>> laraxot/dev
});

test('Place model can be instantiated', function () {
    $place = new Place();

<<<<<<< HEAD
   Assert::assertInstanceOf(Place::class, $place);
=======
    Assert::assertInstanceOf(Place::class, $place);
>>>>>>> laraxot/dev
});

test('PlaceType model can be instantiated', function () {
    $placeType = new PlaceType();

<<<<<<< HEAD
   Assert::assertInstanceOf(PlaceType::class, $placeType);
=======
    Assert::assertInstanceOf(PlaceType::class, $placeType);
>>>>>>> laraxot/dev
});

test('GeoNamesCap model can be instantiated', function () {
    $geoNamesCap = new GeoNamesCap();

<<<<<<< HEAD
   Assert::assertInstanceOf(GeoNamesCap::class, $geoNamesCap);
=======
    Assert::assertInstanceOf(GeoNamesCap::class, $geoNamesCap);
>>>>>>> laraxot/dev
});
