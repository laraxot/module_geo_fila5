<?php

declare(strict_types=1);

use Modules\Geo\Http\Livewire\FormSearchAddressCategories;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;

test('Http Livewire Test e ritirato', function (): void {
    $path = dirname(__DIR__, 2).'/app/Http/Livewire/Test.php';
    Assert::assertFileDoesNotExist($path);
    Assert::assertFalse(class_exists('Modules\\Geo\\Http\\Livewire\\Test', false));
});

test('FormSearchAddressCategories resta Livewire HTTP', function (): void {
    Assert::assertTrue(class_exists(FormSearchAddressCategories::class));
    Assert::assertFileDoesNotExist(dirname(__DIR__, 2).'/app/Filament/Widgets/FormSearchAddressCategoriesWidget.php');
});

test('map widgets FQCN restano nelle viste', function (): void {
    $root = dirname(__DIR__, 2).'/resources/views';
    $files = [
        $root.'/components/blocks/map.blade.php',
        $root.'/components/blocks/map/location-map.blade.php',
        $root.'/components/blocks/map/location-map-table.blade.php',
    ];
    foreach ($files as $file) {
        Assert::assertFileExists($file);
        $contents = file_get_contents($file);
        Assert::assertStringContainsString('Modules\\Geo\\Filament\\Widgets\\LocationMapWidget', $contents);
        Assert::assertStringContainsString('Modules\\Geo\\Filament\\Widgets\\LocationMapTableWidget', $contents);
    }
});
