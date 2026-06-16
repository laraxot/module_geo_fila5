<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Channels;
use function Safe\file_get_contents;
use Modules\Notify\Channels\NetfunChannel;

use PHPUnit\Framework\Assert;
describe('NetfunChannel', function () {
    it('can be instantiated', function () {
        // NetfunChannel requires SendNetfunSMSAction in constructor
        // but we can test structure via reflection
        $reflection = new \ReflectionClass(NetfunChannel::class);
        Assert::assertTrue($reflection->isInstantiable());
    });

    it('has send method', function () {
        $reflection = new \ReflectionClass(NetfunChannel::class);
        $method = $reflection->getMethod('send');

        Assert::assertTrue($method->isPublic());
    });

    it('has correct namespace', function () {
        $reflection = new \ReflectionClass(NetfunChannel::class);

        Assert::assertSame('Modules\Notify\Channels', $reflection->getNamespaceName());
    });

    it('uses strict types', function () {
        $reflection = new \ReflectionClass(NetfunChannel::class);
        $content = \notifyReflectionSource($reflection);
        Assert::assertStringContainsString('declare(strict_types=1)', $content);
    });

    it('has protected sendSMSAction property', function () {
        $reflection = new \ReflectionClass(NetfunChannel::class);
        $property = $reflection->getProperty('sendSMSAction');

        Assert::assertTrue($property->isProtected());
    });
});
