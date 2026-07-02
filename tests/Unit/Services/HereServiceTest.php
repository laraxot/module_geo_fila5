<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Services;

use Modules\Geo\Services\HereService;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('has correct base URL', function (): void {
    $service = new HereService();

    expect($service->base_url)->toBe('https://router.hereapi.com/v8/routes');
});

it('has static method for getting duration and length', function (): void {
    $reflection = new \ReflectionClass(HereService::class);

    Assert::assertTrue($reflection->hasMethod('getDurationAndLength'));
    Assert::assertTrue($reflection->getMethod('getDurationAndLength')->isStatic());
});
