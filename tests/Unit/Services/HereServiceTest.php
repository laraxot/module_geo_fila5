<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Services;

use Modules\Geo\Services\HereService;
use Modules\Geo\Tests\TestCase;

uses(TestCase::class);

it('has correct base URL', function (): void {
    $service = new HereService();
    expect($service->base_url)->toBe('https://router.hereapi.com/v8/routes');
});

it('has getDurationAndLength method', function (): void {
    $reflection = new \ReflectionClass(HereService::class);
    expect($reflection->hasMethod('getDurationAndLength'))->toBeTrue();
});
