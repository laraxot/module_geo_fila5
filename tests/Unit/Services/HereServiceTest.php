<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Services;

use Modules\Geo\Services\HereService;
use PHPUnit\Framework\Assert;

it('has correct base URL', function (): void {
    $service = new HereService();

    Assert::assertSame('https://router.hereapi.com/v8/routes', $service->base_url);
});
