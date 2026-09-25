<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Traits;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Geo\Models\BaseModel;
use Modules\Geo\Models\Traits\GeoTrait;
use Modules\Geo\Models\Traits\HasPlaceTrait;
use Modules\Geo\Tests\Fixtures\Traits\HasAddressesTestModel;
use Modules\Geo\Tests\LightTestCase;
=======
use Modules\Geo\Tests\TestCase;
>>>>>>> laraxot/dev
use Modules\Geo\Traits\HandlesCoordinates;
use Modules\Geo\Traits\HasAddresses;
use PHPUnit\Framework\Assert;

<<<<<<< HEAD
use function Safe\class_uses;

uses(LightTestCase::class);
test('HasAddresses trait can be used', function (): void {
    Assert::assertTrue(trait_exists(HasAddresses::class));
    Assert::assertContains(HasAddresses::class, class_uses(HasAddressesTestModel::class));
=======
uses(TestCase::class);
test('HasAddresses trait can be used', function (): void {
    Assert::assertTrue(trait_exists(HasAddresses::class));
>>>>>>> laraxot/dev

    $reflection = new \ReflectionClass(HasAddresses::class);
    Assert::assertTrue($reflection->hasMethod('addresses'));
    Assert::assertTrue($reflection->hasMethod('primaryAddress'));
});

<<<<<<< HEAD
test('GeoTrait can be used by an Eloquent model', function (): void {
    $model = new class extends BaseModel {
        use GeoTrait;
    };

    Assert::assertContains(GeoTrait::class, class_uses($model));
});

test('HasPlaceTrait exposes place relationships', function (): void {
    $model = new class extends BaseModel {
        use HasPlaceTrait;
    };

    Assert::assertInstanceOf(MorphOne::class, $model->place());
    Assert::assertInstanceOf(MorphMany::class, $model->places());
});

=======
>>>>>>> laraxot/dev
test('HandlesCoordinates trait can be used', function (): void {
    Assert::assertTrue(trait_exists(HandlesCoordinates::class));

    $reflection = new \ReflectionClass(HandlesCoordinates::class);
    Assert::assertTrue($reflection->hasMethod('formatCoordinates'));
});
