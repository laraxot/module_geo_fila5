<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Filament;

use Modules\Geo\Filament\Actions\UpdateCoordinatesBulkAction;
use Modules\Geo\Filament\Forms\Components\AddressField;
use Modules\Geo\Filament\Forms\Components\MapPicker;
use Modules\Geo\Filament\Widgets\GeoMapWidget;
use Modules\Geo\Filament\Widgets\LatLngWidget;
use Modules\Geo\Filament\Widgets\LocationWidget;
use PHPUnit\Framework\Assert;
use ReflectionClass;

test('AddressField can be instantiated', function (): void {
    $field = AddressField::make('address');

    Assert::assertFalse((new ReflectionClass($field))->isAbstract());
});

test('MapPicker can be instantiated with coordinate columns', function (): void {
    $field = MapPicker::make('map_picker')
        ->latitudeColumn('latitude')
        ->longitudeColumn('longitude');

    Assert::assertSame('latitude', $field->getLatitudeColumn());
    Assert::assertSame('longitude', $field->getLongitudeColumn());
});

test('LocationWidget is a concrete Filament widget', function (): void {
    Assert::assertFalse((new ReflectionClass(LocationWidget::class))->isAbstract());
});

test('LatLngWidget is a concrete Filament widget', function (): void {
    Assert::assertFalse((new ReflectionClass(LatLngWidget::class))->isAbstract());
});

test('GeoMapWidget is a concrete Filament widget', function (): void {
    Assert::assertFalse((new ReflectionClass(GeoMapWidget::class))->isAbstract());
});

test('UpdateCoordinatesBulkAction can be instantiated', function (): void {
    $action = UpdateCoordinatesBulkAction::make('update_coordinates');

    Assert::assertFalse((new ReflectionClass($action))->isAbstract());
});
