<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Filament\Forms\Components;

use Modules\Geo\Filament\Forms\Components\CoordinatePicker;
use Modules\Geo\Filament\Forms\Components\LatitudeLongitudeInput;
use Modules\Geo\Filament\Forms\Components\MapPicker;
use Modules\Geo\Tests\UnitTestCase;
use Modules\Xot\Filament\Forms\Components\XotBaseField;

uses(UnitTestCase::class);

test('CoordinatePicker extends XotBaseField', function (): void {
    expect(CoordinatePicker::make('test'))->toBeInstanceOf(XotBaseField::class);
});

test('LatitudeLongitudeInput extends XotBaseField', function (): void {
    expect(LatitudeLongitudeInput::make('test'))->toBeInstanceOf(XotBaseField::class);
});

test('LatitudeLongitudeInput DOES NOT extend CoordinatePicker', function (): void {
    expect(LatitudeLongitudeInput::make('test'))->not->toBeInstanceOf(CoordinatePicker::class);
});

test('MapPicker extends XotBaseField', function (): void {
    expect(MapPicker::make('test'))->toBeInstanceOf(XotBaseField::class);
});

test('MapPicker DOES NOT extend CoordinatePicker', function (): void {
    expect(MapPicker::make('test'))->not->toBeInstanceOf(CoordinatePicker::class);
});

test('CoordinatePicker uses clean naming convention (No Default prefixes)', function (): void {
    $field = CoordinatePicker::make('test');

    expect(method_exists($field, 'getDefaultLatitude'))->toBeFalse()
        ->and(method_exists($field, 'getDefaultZoom'))->toBeFalse();
});

test('LatitudeLongitudeInput has legacy center/zoom aliases for convenience', function (): void {
    $field = LatitudeLongitudeInput::make('test')
        ->defaultCenter(44.0, 10.0);

    expect($field->getLatitude())->toBe(44.0)
        ->and($field->getLongitude())->toBe(10.0);
});

test('extractCoordinates utility works correctly', function (): void {
    $data = ['coords' => ['latitude' => 1.2, 'longitude' => 3.4]];
    $extracted = CoordinatePicker::extractCoordinates($data, 'coords', 'lat', 'lng');

    expect($extracted)->toHaveKeys(['lat', 'lng'])
        ->and($extracted['lat'])->toBe(1.2)
        ->and($extracted['lng'])->toBe(3.4)
        ->and($extracted)->not->toHaveKey('coords');
});
