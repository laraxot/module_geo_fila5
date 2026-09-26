<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Traits;

<<<<<<< .merge_file_gbyEYi
use Modules\Geo\Models\Traits\HasPlaceTrait;
=======
use Modules\Geo\Tests\TestCase;
>>>>>>> .merge_file_aGYq0e
use Modules\Geo\Traits\HandlesCoordinates;
use Modules\Geo\Traits\HasAddresses;
use PHPUnit\Framework\Assert;

<<<<<<< .merge_file_gbyEYi
test('HasAddresses trait exists with expected API', function (): void {
    Assert::assertTrue(trait_exists(HasAddresses::class));
    Assert::assertTrue(trait_exists(HasPlaceTrait::class));
=======
uses(TestCase::class);
test('HasAddresses trait can be used', function (): void {
    Assert::assertTrue(trait_exists(HasAddresses::class));
>>>>>>> .merge_file_aGYq0e

    $reflection = new \ReflectionClass(HasAddresses::class);
    Assert::assertTrue($reflection->hasMethod('addresses'));
    Assert::assertTrue($reflection->hasMethod('primaryAddress'));
});

test('HandlesCoordinates trait can be used', function (): void {
    Assert::assertTrue(trait_exists(HandlesCoordinates::class));

    $reflection = new \ReflectionClass(HandlesCoordinates::class);
    Assert::assertTrue($reflection->hasMethod('formatCoordinates'));
});
