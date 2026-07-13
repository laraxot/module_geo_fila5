<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Filament;

use Modules\Geo\Filament\Actions\UpdateCoordinatesBulkAction;
use Modules\Geo\Filament\Forms\Components\AddressField;
use Modules\Geo\Filament\Forms\Components\MapPicker;
use Modules\Geo\Filament\Widgets\GeoMapWidget;
use Modules\Geo\Filament\Widgets\LatLngWidget;
use Modules\Geo\Filament\Widgets\LocationWidget;
<<<<<<< HEAD
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('AddressField can be instantiated', function () {
    $field = AddressField::make('address');
=======
use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);

test('AddressField can be instantiated', function () {
    $field = AddressField::make('address');

    expect($field)->toBeObject();
>>>>>>> laraxot/dev
});

test('MapPicker can be instantiated', function () {
    $field = MapPicker::make('map_picker')
<<<<<<< HEAD
        ->latitudeColumn('latitude')
        ->longitudeColumn('longitude');
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
    Assert::assertInstanceOf(MapPicker::class, $field);
});

test('LocationWidget can be instantiated', function () {
    Assert::assertTrue(class_exists(LocationWidget::class));
});

test('LatLngWidget can be instantiated', function () {
    Assert::assertTrue(class_exists(LatLngWidget::class));
});

test('GeoMapWidget can be instantiated', function () {
    Assert::assertTrue(class_exists(GeoMapWidget::class));
=======
        ->latitude('latitude')
        ->longitude('longitude');

    expect($field)->toBeObject();
});

test('LocationWidget can be instantiated', function () {
    expect(class_exists(LocationWidget::class))->toBeTrue();
});

test('LatLngWidget can be instantiated', function () {
    expect(class_exists(LatLngWidget::class))->toBeTrue();
});

test('GeoMapWidget can be instantiated', function () {
    expect(class_exists(GeoMapWidget::class))->toBeTrue();
>>>>>>> laraxot/dev
});

test('UpdateCoordinatesBulkAction can be instantiated', function () {
    $action = UpdateCoordinatesBulkAction::make('update_coordinates');
<<<<<<< HEAD
=======

    expect($action)->toBeObject();
>>>>>>> laraxot/dev
});
