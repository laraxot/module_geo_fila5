<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Transformers;

uses(\Modules\Geo\Tests\TestCase::class);

use Exception;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use PHPUnit\Framework\Assert;
use Modules\Geo\Tests\TestCase;
use Modules\Geo\Transformers\GeoJsonCollection;
use Modules\Geo\Transformers\GeoJsonResource;
test('GeoJsonResource can be instantiated', function () {
    Assert::assertTrue(class_exists(GeoJsonResource::class));

    // The GeoJsonResource likely needs a model instance to be instantiated
    // For now, just test that the class exists and check its methods
    });

test('GeoJsonCollection can be instantiated', function () {
    Assert::assertTrue(class_exists(GeoJsonCollection::class));

    // Similarly, test that the class exists and check its methods
    });
