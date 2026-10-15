<?php

declare(strict_types=1);

use Modules\Geo\Actions\Map\ExportMapDataAction;
use Modules\Geo\Actions\Map\GetMapMarkersAction;
use Modules\Geo\Actions\Map\GetMapStatsAction;
use PHPUnit\Framework\Assert;
use Tests\Modules\Geo\LightTestCase;

uses(LightTestCase::class);

test('map markers action accepts typed filters and returns marker list', function (): void {
    $markers = app(GetMapMarkersAction::class)->execute(['category' => 'farm', 'limit' => 10]);

    Assert::assertSame([], $markers);
});

test('map stats action returns typed stats shape', function (): void {
    $stats = app(GetMapStatsAction::class)->execute([]);

    Assert::assertSame(['total' => 0, 'categories' => 0], $stats);
});

test('export map data action supports typed format constants', function (): void {
    $action = app(ExportMapDataAction::class);

    Assert::assertSame('[]', $action->execute([], ExportMapDataAction::FORMAT_JSON));
    Assert::assertSame('', $action->execute([], ExportMapDataAction::FORMAT_CSV));
    Assert::assertStringContainsString('FeatureCollection', $action->execute([], ExportMapDataAction::FORMAT_GEOJSON));
    Assert::assertStringContainsString('<kml', $action->execute([], ExportMapDataAction::FORMAT_KML));
});
