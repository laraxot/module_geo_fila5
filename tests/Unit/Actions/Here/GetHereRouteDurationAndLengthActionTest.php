<?php

declare(strict_types=1);

use Modules\Geo\Actions\Here\GetHereRouteDurationAndLengthAction;
use Modules\Geo\Adapters\HereClient;

test('here client can be instantiated', function (): void {
    expect(new HereClient())->toBeInstanceOf(HereClient::class);
});

test('here client delegates to GetHereRouteDurationAndLengthAction', function (): void {
    expect(method_exists(HereClient::class, 'getDurationAndLength'))->toBeTrue();
    expect(method_exists(GetHereRouteDurationAndLengthAction::class, 'execute'))->toBeTrue();
});
