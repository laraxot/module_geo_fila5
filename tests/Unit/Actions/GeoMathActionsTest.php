<?php

declare(strict_types=1);

use Modules\Geo\Actions\GoogleMaps\FetchGoogleMapsElevationAction;
use Modules\Geo\Actions\Here\GetHereRouteDurationAndLengthAction;
use Modules\Geo\Actions\Math\CalculateGeoDistanceAction;
use Modules\Geo\Actions\Math\GenerateHaversineSqlAction;
use PHPUnit\Framework\Assert;

test('CalculateGeoDistanceAction returns zero for same point', function (): void {
    $action = app(CalculateGeoDistanceAction::class);

    Assert::assertSame(0.0, $action->execute(45.0, 9.0, 45.0, 9.0, 'K'));
});

test('GenerateHaversineSqlAction uses custom field names', function (): void {
    $sql = app(GenerateHaversineSqlAction::class)->execute(45.0, 9.0, 'lat', 'lng');

    Assert::assertStringContainsString('`lat`', $sql);
    Assert::assertStringContainsString('`lng`', $sql);
});

test('FetchGoogleMapsElevationAction is resolvable', function (): void {
    Assert::assertSame(
        FetchGoogleMapsElevationAction::class,
        app(FetchGoogleMapsElevationAction::class)::class,
    );
});

test('GetHereRouteDurationAndLengthAction is resolvable', function (): void {
    Assert::assertSame(
        GetHereRouteDurationAndLengthAction::class,
        app(GetHereRouteDurationAndLengthAction::class)::class,
    );
});
