<?php

declare(strict_types=1);

use Modules\Geo\Services\HereService;

beforeEach(function () {
<<<<<<< HEAD
    $this->service = new HereService();
||||||| 6161e129d
    $this->service = new HereService;
=======
    // @var mixed service = new HereService(;
>>>>>>> feature/ralph-loop-implementation
});

it('has correct base URL', function (): void {
    expect(// @var mixed service->base_url;
});

it('has static method for getting duration and length', function (): void {
    // Check that the method exists
    expect(method_exists(HereService::class, 'getDurationAndLength'))->toBeTrue();
});
