<?php

declare(strict_types=1);

namespace Tests\Modules\Geo\Unit\Actions;

use Modules\Geo\Actions\Distance\CalculateGeoDistanceAction;
use Modules\Geo\Actions\GoogleMapsAction;
use PHPUnit\Framework\Assert;
use Tests\Modules\Geo\TestCase;

uses(TestCase::class);

test('CalculateGeoDistanceAction can be resolved', function (): void {
    $action = app(CalculateGeoDistanceAction::class);

    Assert::assertInstanceOf(CalculateGeoDistanceAction::class, $action);
});

test('GoogleMapsAction can be instantiated', function (): void {
    $service = new GoogleMapsAction;

    Assert::assertInstanceOf(GoogleMapsAction::class, $service);
});
