<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Traits;

<<<<<<< HEAD
use Modules\Geo\Tests\TestCase;
use Modules\Geo\Traits\HandlesCoordinates;
use Modules\Geo\Traits\HasAddresses;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('HasAddresses trait can be used', function (): void {
    Assert::assertTrue(trait_exists(HasAddresses::class));

    $reflection = new \ReflectionClass(HasAddresses::class);
    Assert::assertTrue($reflection->hasMethod('addresses'));
    Assert::assertTrue($reflection->hasMethod('primaryAddress'));
});

test('HandlesCoordinates trait can be used', function (): void {
    Assert::assertTrue(trait_exists(HandlesCoordinates::class));

    $reflection = new \ReflectionClass(HandlesCoordinates::class);
    Assert::assertTrue($reflection->hasMethod('formatCoordinates'));
=======
uses(\Modules\Geo\Tests\TestCase::class);

use Modules\Geo\Traits\HandlesCoordinates;
use Modules\Geo\Traits\HasAddresses;

test('HasAddresses trait can be used', function () {
    // Check if trait exists
    expect(trait_exists(HasAddresses::class))->toBeTrue();

    // Create an anonymous class that uses the trait
    $model = new class extends Modules\Geo\Models\BaseModel {
        use HasAddresses;

        protected $table = 'addresses';
    };

    // Check if the trait methods exist
    expect(method_exists($model, 'address') || method_exists($model, 'addresses'))->toBeTrue();
});

test('HandlesCoordinates trait can be used', function () {
    // Check if trait exists
    expect(trait_exists(HandlesCoordinates::class))->toBeTrue();

    // Create an anonymous class that uses the trait
    $model = new class extends Modules\Geo\Models\BaseModel {
        use HandlesCoordinates;

        protected $table = 'addresses';
    };

    // Check if the trait methods exist
    expect(method_exists($model, 'formatCoordinates') || method_exists($model, 'getCoordinates'))->toBeTrue();
>>>>>>> laraxot/dev
});
