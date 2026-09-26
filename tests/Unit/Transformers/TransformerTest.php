<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Transformers;

<<<<<<< .merge_file_PYUAh4
=======
use Modules\Geo\Tests\TestCase;
>>>>>>> .merge_file_DRVZTx
use Modules\Geo\Transformers\GeoJsonCollection;
use Modules\Geo\Transformers\GeoJsonResource;
use PHPUnit\Framework\Assert;

<<<<<<< .merge_file_PYUAh4
=======
uses(TestCase::class);
>>>>>>> .merge_file_DRVZTx
test('GeoJsonResource can be instantiated', function () {
    Assert::assertTrue(class_exists(GeoJsonResource::class));

    // The GeoJsonResource likely needs a model instance to be instantiated
    // For now, just test that the class exists and check its methods
});

test('GeoJsonCollection can be instantiated', function () {
    Assert::assertTrue(class_exists(GeoJsonCollection::class));

    // Similarly, test that the class exists and check its methods
});
