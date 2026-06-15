<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\File\AssetAction;
use Modules\Xot\Actions\File\AssetPathAction;
use Modules\Xot\Actions\File\FixPathAction;
use Modules\Xot\Actions\File\GetModulePathAction;
use Nwidart\Modules\Facades\Module;
use PHPUnit\Framework\Assert;

it('handles absolute urls in AssetAction', function (): void {
    /** @var Modules\Xot\Tests\TestCase $this */
    $action = app(AssetAction::class);
    $url = 'https://example.com/asset.js';
    Assert::assertSame($url, $action->execute($url));
});

it('returns path if asset already exists in public folder', function (): void {
    /** @var Modules\Xot\Tests\TestCase $this */
    $path = 'css/app.css';
    File::shouldReceive('exists')->with(public_path($path))->andReturn(true);

    $action = app(AssetAction::class);
    Assert::assertSame($path, $action->execute($path));
});

it('resolves module assets correctly in AssetAction', function (): void {
    /** @var Modules\Xot\Tests\TestCase $this */
    $path = 'Xot::css/style.css';
    $modulePath = '/var/www/Modules/Xot';
    $from = $modulePath.'/resources/css/style.css';
    $to = public_path('assets/Xot/css/style.css');

    $modulePathMock = $this->createUnitMock(GetModulePathAction::class);
    $modulePathMock->method('execute')->with('Xot')->willReturn($modulePath);

    app()->instance(GetModulePathAction::class, $modulePathMock);

    $fixPathMock = $this->createUnitMock(FixPathAction::class);
    $fixPathMock->method('execute')->willReturnArgument(0);

    app()->instance(FixPathAction::class, $fixPathMock);

    File::shouldReceive('exists')->with(public_path($path))->andReturn(false);
    File::shouldReceive('exists')->with($from)->andReturn(true);
    File::shouldReceive('exists')->with($to)->andReturn(true);
    File::shouldReceive('exists')->with(dirname($to))->andReturn(true);
    File::shouldReceive('copy')->once();

    $action = app(AssetAction::class);
    $result = $action->execute($path);

    Assert::assertStringContainsString('assets/Xot/css/style.css', $result);
});

it('calculates asset path correctly in AssetPathAction', function (): void {
    Module::shouldReceive('getModulePath')
        ->once()
        ->with('User')
        ->andReturn('/path/to/User/');

    $action = app(AssetPathAction::class);
    $result = $action->execute('User::js/app.js');

    Assert::assertSame('/path/to/User/resources/js/app.js', $result);
});
