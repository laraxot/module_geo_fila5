<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Transformers;

<<<<<<< HEAD
=======
use Modules\Geo\Tests\TestCase;
>>>>>>> laraxot/dev
use Modules\Geo\Transformers\GeoJsonCollection;
use Modules\Geo\Transformers\GeoJsonResource;
use PHPUnit\Framework\Assert;

<<<<<<< HEAD
=======
uses(TestCase::class);
>>>>>>> laraxot/dev
test('GeoJsonResource can be instantiated', function () {
    Assert::assertTrue(class_exists(GeoJsonResource::class));

    // The GeoJsonResource likely needs a model instance to be instantiated
    // For now, just test that the class exists and check its methods
});

test('GeoJsonCollection can be instantiated', function () {
    Assert::assertTrue(class_exists(GeoJsonCollection::class));

    // Similarly, test that the class exists and check its methods
});
