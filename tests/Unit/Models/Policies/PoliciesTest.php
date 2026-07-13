<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models\Policies;

<<<<<<< HEAD
=======
uses(\Modules\Geo\Tests\TestCase::class);

>>>>>>> laraxot/dev
use Modules\Geo\Models\Policies\CountyPolicy;
use Modules\Geo\Models\Policies\GeoNamesCapPolicy;
use Modules\Geo\Models\Policies\LocalityPolicy;
use Modules\Geo\Models\Policies\PlacePolicy;
use Modules\Geo\Models\Policies\PlaceTypePolicy;
use Modules\Geo\Models\Policies\StatePolicy;
<<<<<<< HEAD
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('StatePolicy can be instantiated', function () {
    $policy = new StatePolicy();

    Assert::assertInstanceOf(StatePolicy::class, $policy);
=======

test('StatePolicy can be instantiated', function () {
    $policy = new StatePolicy();

    expect($policy)->toBeInstanceOf(StatePolicy::class);
>>>>>>> laraxot/dev
});

test('CountyPolicy can be instantiated', function () {
    $policy = new CountyPolicy();

<<<<<<< HEAD
    Assert::assertInstanceOf(CountyPolicy::class, $policy);
=======
    expect($policy)->toBeInstanceOf(CountyPolicy::class);
>>>>>>> laraxot/dev
});

test('LocalityPolicy can be instantiated', function () {
    $policy = new LocalityPolicy();

<<<<<<< HEAD
    Assert::assertInstanceOf(LocalityPolicy::class, $policy);
=======
    expect($policy)->toBeInstanceOf(LocalityPolicy::class);
>>>>>>> laraxot/dev
});

test('PlacePolicy can be instantiated', function () {
    $policy = new PlacePolicy();

<<<<<<< HEAD
    Assert::assertInstanceOf(PlacePolicy::class, $policy);
=======
    expect($policy)->toBeInstanceOf(PlacePolicy::class);
>>>>>>> laraxot/dev
});

test('PlaceTypePolicy can be instantiated', function () {
    $policy = new PlaceTypePolicy();

<<<<<<< HEAD
    Assert::assertInstanceOf(PlaceTypePolicy::class, $policy);
=======
    expect($policy)->toBeInstanceOf(PlaceTypePolicy::class);
>>>>>>> laraxot/dev
});

test('GeoNamesCapPolicy can be instantiated', function () {
    $policy = new GeoNamesCapPolicy();

<<<<<<< HEAD
    Assert::assertInstanceOf(GeoNamesCapPolicy::class, $policy);
=======
    expect($policy)->toBeInstanceOf(GeoNamesCapPolicy::class);
>>>>>>> laraxot/dev
});
