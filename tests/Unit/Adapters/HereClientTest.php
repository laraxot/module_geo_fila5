<?php

declare(strict_types=1);

namespace Tests\Modules\Geo\Unit\Adapters;

use Modules\Geo\Adapters\HereClient;
use PHPUnit\Framework\Assert;
use Tests\Modules\Geo\LightTestCase;

uses(LightTestCase::class);

it('uses the HERE routing endpoint', function (): void {
    Assert::assertSame('https://router.hereapi.com/v8/routes', (new HereClient)->base_url);
});

it('exposes route summary lookup', function (): void {
    Assert::assertContains('getDurationAndLength', get_class_methods(HereClient::class));
});
