<?php

declare(strict_types=1);

use Modules\Geo\Adapters\HereClient;
use PHPUnit\Framework\Assert;

test('here client uses here router base url', function (): void {
    $client = new HereClient();

    Assert::assertSame('https://router.hereapi.com/v8/routes', $client->base_url);
});
