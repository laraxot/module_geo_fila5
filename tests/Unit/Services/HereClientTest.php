<?php

declare(strict_types=1);

use Modules\Geo\Adapters\HereClient;

beforeEach(function () {
    $this->service = new HereClient();
});

test('here client can be instantiated', function () {
    expect($this->service)->toBeInstanceOf(HereClient::class);
});

test('here client has getDurationAndLength method', function () {
    expect(method_exists(HereClient::class, 'getDurationAndLength'))->toBeTrue();
});
