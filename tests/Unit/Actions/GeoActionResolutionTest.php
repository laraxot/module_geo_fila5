<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use Modules\Geo\Actions\GeoAction;
use Modules\Geo\Actions\GoogleMapsAction;
use PHPUnit\Framework\Assert;

test('GeoAction can be instantiated', function () {
    $service = new GeoAction();

    Assert::assertInstanceOf(GeoAction::class, $service);
});

test('GoogleMapsAction can be instantiated', function () {
    $service = new GoogleMapsAction();

    Assert::assertInstanceOf(GoogleMapsAction::class, $service);
});
