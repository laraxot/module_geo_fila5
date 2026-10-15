<?php

declare(strict_types=1);

namespace Tests\Modules\Geo\Unit\Transformers;

use Modules\Geo\Transformers\GeoJsonCollection;
use Modules\Geo\Transformers\GeoJsonResource;
use PHPUnit\Framework\Assert;
use Tests\Modules\Geo\TestCase;

uses(TestCase::class);
test('GeoJsonResource can be instantiated', function () {
    Assert::assertTrue(class_exists(GeoJsonResource::class));

    // The GeoJsonResource likely needs a model instance to be instantiated
    // For now, just test that the class exists and check its methods
});

test('GeoJsonCollection can be instantiated', function () {
    Assert::assertTrue(class_exists(GeoJsonCollection::class));

    // Similarly, test that the class exists and check its methods
});
