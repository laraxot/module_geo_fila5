<?php

declare(strict_types=1);

use Modules\Geo\Filament\Pages\Dashboard;
use Modules\Geo\Filament\Widgets\GeoMapWidget;
use PHPUnit\Framework\Assert;

test('geo map widget resolves embedded geojson dataset', function (): void {
    $widget = new GeoMapWidget();
    $dataset = $widget->getDataset();

<<<<<<< HEAD
   Assert::assertSame('FeatureCollection', $dataset['type']);
=======
    Assert::assertSame('FeatureCollection', $dataset['type']);
>>>>>>> laraxot/dev

    Assert::assertIsArray($dataset['features']);

    Assert::assertEmpty($dataset['features']);
});

test('geo map widget exposes categories and config', function (): void {
    $widget = new GeoMapWidget();
    $config = $widget->getMapConfig();

<<<<<<< HEAD
   foreach (['farm', 'marketplace', 'beekeeper', 'vending_machine'] as $category) {
=======
    foreach (['farm', 'marketplace', 'beekeeper', 'vending_machine'] as $category) {
>>>>>>> laraxot/dev
        Assert::assertContains($category, $widget->getCategories());
    }

    Assert::assertSame(12, $config['detailZoom']);

    Assert::assertSame(8, $config['aggregateZoom']);
});

test('geo map widget serializes dataset and config to json', function (): void {
    $widget = new GeoMapWidget();

<<<<<<< HEAD
   Assert::assertStringStartsWith('{', (string) $widget->getDatasetJson());
=======
    Assert::assertStringStartsWith('{', (string) $widget->getDatasetJson());
>>>>>>> laraxot/dev

    Assert::assertStringStartsWith('{', (string) $widget->getConfigJson());
});

test('geo dashboard registers geo map widget', function (): void {
    $dashboard = new Dashboard();

<<<<<<< HEAD
   Assert::assertContains(GeoMapWidget::class, $dashboard->getWidgets());
=======
    Assert::assertContains(GeoMapWidget::class, $dashboard->getWidgets());
>>>>>>> laraxot/dev
});
