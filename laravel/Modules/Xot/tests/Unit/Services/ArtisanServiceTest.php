<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Modules\Xot\Services\ArtisanService;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\ob_end_clean;
use function Safe\ob_start;

uses(TestCase::class);

beforeEach(function (): void {
    Config::set('database.connections.mysql', [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
    ]);
});

test('artisan service act method returns empty string for unknown commands', function (): void {
    Request::replace(['module' => '']);

    $result = ArtisanService::act('unknown-command');
    Assert::assertSame('', $result);
});

test('artisan service act method handles migrate command', function (): void {
    Request::replace(['module' => '']);

    Artisan::shouldReceive('call')->once()->andReturn(0);
    Artisan::shouldReceive('output')->once()->andReturn('Migration completed');

    $result = ArtisanService::act('migrate');
    Assert::assertSame('string', gettype($result));
});

test('artisan service act method handles module parameter', function (): void {
    Request::replace(['module' => 'TestModule']);

    Artisan::shouldReceive('call')->once()->andReturn(0);
    Artisan::shouldReceive('output')->once()->andReturn('Module migration');

    ob_start();
    $result = ArtisanService::act('migrate');
    ob_end_clean();
    Assert::assertSame('string', gettype($result));
});

test('artisan service handles non-string module parameter', function (): void {
    Request::replace(['module' => ['not', 'a', 'string']]);

    Artisan::shouldReceive('call')->once()->andReturn(0);
    Artisan::shouldReceive('output')->once()->andReturn('Migration');

    $result = ArtisanService::act('migrate');
    Assert::assertSame('string', gettype($result));
});
