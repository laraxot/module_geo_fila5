<?php

declare(strict_types=1);

use Modules\Xot\Services\UrlService;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('can be instantiated', function (): void {
    $service = new UrlService();
    Assert::assertInstanceOf(UrlService::class, $service);
});

it('can get instance via getInstance', function (): void {
    $service = UrlService::getInstance();
    Assert::assertInstanceOf(UrlService::class, $service);
});

it('can get instance via make', function (): void {
    $service = UrlService::make();
    Assert::assertInstanceOf(UrlService::class, $service);
});

it('validates correct urls', function (): void {
    $service = UrlService::make();
    Assert::assertTrue($service->checkValidUrl('https://google.com'));
    Assert::assertTrue($service->checkValidUrl('http://localhost'));
    Assert::assertTrue($service->checkValidUrl('ftp://server.com'));
});

it('invalidates incorrect urls', function (): void {
    $service = UrlService::make();
    Assert::assertFalse($service->checkValidUrl('not-a-url'));
    Assert::assertFalse($service->checkValidUrl('http:///double-slash'));
    Assert::assertFalse($service->checkValidUrl(''));
});
