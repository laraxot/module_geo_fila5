<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use Modules\Geo\Actions\Distance\CalculateGeoDistanceAction;
use Modules\Geo\Actions\GoogleMapsAction;
<<<<<<< .merge_file_QyCFmL
use PHPUnit\Framework\Assert;

=======
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

>>>>>>> .merge_file_GpVU74
test('CalculateGeoDistanceAction can be resolved', function (): void {
    $action = app(CalculateGeoDistanceAction::class);

    Assert::assertInstanceOf(CalculateGeoDistanceAction::class, $action);
});

test('GoogleMapsAction can be instantiated', function (): void {
    $service = new GoogleMapsAction();

    Assert::assertInstanceOf(GoogleMapsAction::class, $service);
});
