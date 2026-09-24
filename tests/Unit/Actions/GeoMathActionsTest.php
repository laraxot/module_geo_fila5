<?php

declare(strict_types=1);

use Modules\Geo\Actions\GoogleMaps\FetchGoogleMapsElevationAction;
use Modules\Geo\Actions\Here\GetHereRouteDurationAndLengthAction;
use Modules\Geo\Actions\Math\CalculateGeoDistanceAction;
use Modules\Geo\Actions\Math\GenerateHaversineSqlAction;

test('CalculateGeoDistanceAction can be instantiated', function (): void {
    expect(app(CalculateGeoDistanceAction::class))->toBeInstanceOf(CalculateGeoDistanceAction::class);
});

test('GenerateHaversineSqlAction can be instantiated', function (): void {
    expect(app(GenerateHaversineSqlAction::class))->toBeInstanceOf(GenerateHaversineSqlAction::class);
});

test('FetchGoogleMapsElevationAction can be instantiated', function (): void {
    expect(app(FetchGoogleMapsElevationAction::class))->toBeInstanceOf(FetchGoogleMapsElevationAction::class);
});

test('GetHereRouteDurationAndLengthAction can be instantiated', function (): void {
    expect(app(GetHereRouteDurationAndLengthAction::class))->toBeInstanceOf(GetHereRouteDurationAndLengthAction::class);
});

test('CalculateGeoDistanceAction returns zero for same point', function (): void {
    $action = app(CalculateGeoDistanceAction::class);

    expect($action->execute(45.0, 9.0, 45.0, 9.0, 'K'))->toBe(0.0);
});

test('GenerateHaversineSqlAction uses custom field names', function (): void {
    $sql = app(GenerateHaversineSqlAction::class)->execute(45.0, 9.0, 'lat', 'lng');

    expect($sql)->toContain('`lat`')->toContain('`lng`');
});
