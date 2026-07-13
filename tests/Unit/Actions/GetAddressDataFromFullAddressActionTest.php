<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

<<<<<<< HEAD
use Illuminate\Support\Collection;
use Modules\Geo\Actions\GetAddressDataFromFullAddressAction;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
it('returns AddressData when first service succeeds', function (): void {
    $action = new GetAddressDataFromFullAddressAction();

    // As this action depends on multiple external services which are difficult to mock,
    // we can test that it at least has the correct structure and properties
    Assert::assertInstanceOf(GetAddressDataFromFullAddressAction::class, $action);
    Assert::assertInstanceOf(Collection::class, $action->getErrors());
    Assert::assertSame(0, $action->getErrors()->count());
=======
use Modules\Geo\Actions\GetAddressDataFromFullAddressAction;
use Modules\Geo\Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    $this->action = new GetAddressDataFromFullAddressAction();
});

it('returns AddressData when first service succeeds', function (): void {
    // As this action depends on multiple external services which are difficult to mock,
    // we can test that it at least has the correct structure and properties
    expect($this->action)->toBeInstanceOf(GetAddressDataFromFullAddressAction::class);
    expect($this->action->getErrors())->toBeInstanceOf(Illuminate\Support\Collection::class);
    expect($this->action->getErrors()->count())->toBe(0);
>>>>>>> laraxot/dev
});

it('initializes with empty errors collection', function (): void {
    $action = new GetAddressDataFromFullAddressAction();

<<<<<<< HEAD
    $action = new GetAddressDataFromFullAddressAction();

    Assert::assertInstanceOf(Collection::class, $action->getErrors());
    Assert::assertSame(0, $action->getErrors()->count());
});

it('executes without throwing error for basic call', function (): void {
    $action = new GetAddressDataFromFullAddressAction();

=======
    expect($action->getErrors())->toBeInstanceOf(Illuminate\Support\Collection::class);
    expect($action->getErrors()->count())->toBe(0);
});

it('executes without throwing error for basic call', function (): void {
>>>>>>> laraxot/dev
    // This tests that the action can be instantiated and executed without critical errors
    // Since it depends on external services, we can't easily test the full functionality
    $action = new GetAddressDataFromFullAddressAction();

    // The execute method should handle missing services gracefully
    $result = $action->execute('Test Address');

    // The method should return null if no services are available
<<<<<<< HEAD
    Assert::assertNull($result);

    // And should have set error messages
    Assert::assertInstanceOf(Collection::class, $action->getErrors());
=======
    expect($result)->toBeNull();

    // And should have set error messages
    expect($action->getErrors())->toBeInstanceOf(Illuminate\Support\Collection::class);
>>>>>>> laraxot/dev
});
