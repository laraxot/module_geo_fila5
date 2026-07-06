<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Services;

use Modules\Geo\Services\HereService;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

uses(LightTestCase::class);

it('has correct base URL', function (): void {
    $service = new HereService();

    Assert::assertSame('https://router.hereapi.com/v8/routes', $service->base_url);
});

it('has route duration and length method', function (): void {
    Assert::assertTrue((new \ReflectionClass(HereService::class))->hasMethod('getDurationAndLength'));
});
