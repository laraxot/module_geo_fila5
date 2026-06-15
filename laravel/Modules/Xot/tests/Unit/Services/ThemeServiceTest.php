<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Illuminate\Support\Facades\Config;
use Modules\Xot\Services\ThemeService;
use PHPUnit\Framework\Assert;

it('sets and gets theme', function (): void {
    ThemeService::setTheme('test-theme');
    Assert::assertSame('test-theme', Config::get('theme.active'));
    Assert::assertSame('test-theme', ThemeService::getTheme());
});

it('checks if theme is active', function (): void {
    ThemeService::setTheme('active-theme');
    Assert::assertTrue(ThemeService::isTheme('active-theme'));
    Assert::assertFalse(ThemeService::isTheme('other-theme'));
});

it('gets theme path', function (): void {
    ThemeService::setTheme('my-path-theme');
    $path = ThemeService::getThemePath();
    Assert::assertSame(resource_path('themes/my-path-theme'), $path);
});
