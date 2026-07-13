<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

<<<<<<< HEAD
=======
uses(\Modules\Geo\Tests\TestCase::class);

>>>>>>> laraxot/dev
use Modules\Geo\Models\County;
use Modules\Geo\Models\GeoNamesCap;
use Modules\Geo\Models\Locality;
use Modules\Geo\Models\Place;
use Modules\Geo\Models\PlaceType;
use Modules\Geo\Models\State;
<<<<<<< HEAD
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('State model can be instantiated', function () {
    $state = new State();

    Assert::assertInstanceOf(State::class, $state);
=======

test('State model can be instantiated', function () {
    $state = new State();

    expect($state)->toBeInstanceOf(State::class);
>>>>>>> laraxot/dev
});

test('County model can be instantiated', function () {
    $county = new County();

<<<<<<< HEAD
    Assert::assertInstanceOf(County::class, $county);
=======
    expect($county)->toBeInstanceOf(County::class);
>>>>>>> laraxot/dev
});

test('Locality model can be instantiated', function () {
    $locality = new Locality();

<<<<<<< HEAD
    Assert::assertInstanceOf(Locality::class, $locality);
=======
    expect($locality)->toBeInstanceOf(Locality::class);
>>>>>>> laraxot/dev
});

test('Place model can be instantiated', function () {
    $place = new Place();

<<<<<<< HEAD
    Assert::assertInstanceOf(Place::class, $place);
=======
    expect($place)->toBeInstanceOf(Place::class);
>>>>>>> laraxot/dev
});

test('PlaceType model can be instantiated', function () {
    $placeType = new PlaceType();

<<<<<<< HEAD
    Assert::assertInstanceOf(PlaceType::class, $placeType);
=======
    expect($placeType)->toBeInstanceOf(PlaceType::class);
>>>>>>> laraxot/dev
});

test('GeoNamesCap model can be instantiated', function () {
    $geoNamesCap = new GeoNamesCap();

<<<<<<< HEAD
    Assert::assertInstanceOf(GeoNamesCap::class, $geoNamesCap);
=======
    expect($geoNamesCap)->toBeInstanceOf(GeoNamesCap::class);
>>>>>>> laraxot/dev
});
