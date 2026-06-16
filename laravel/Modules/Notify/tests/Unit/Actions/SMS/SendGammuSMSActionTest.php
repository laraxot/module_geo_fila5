<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions\SMS;
use Modules\Notify\Tests\TestCase;
use function Safe\file_get_contents;
use Modules\Notify\Actions\SMS\SendGammuSMSAction;
use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Datas\SmsData;
use PHPUnit\Framework\Assert;
use Spatie\QueueableAction\QueueableAction;

use function Safe\class_implements;
use function Safe\class_uses;

uses(\Modules\Notify\Tests\TestCase::class);

describe('SendGammuSMSAction', function () {
    // Test strutturali - la classe richiede config nel costruttore
    it('has correct class definition', function () {
        $reflection = new \ReflectionClass(SendGammuSMSAction::class);

        Assert::assertTrue($reflection->isInstantiable());
    });

    it('implements SmsActionContract', function () {
        $interfaces = class_implements(SendGammuSMSAction::class);
        Assert::assertContains(SmsActionContract::class, $interfaces);
    });

    it('uses QueueableAction trait', function () {
        $traits = class_uses(SendGammuSMSAction::class);
        Assert::assertArrayHasKey(QueueableAction::class, $traits);
    });

    it('has execute method with correct signature', function () {
        $reflection = new \ReflectionClass(SendGammuSMSAction::class);
        $method = $reflection->getMethod('execute');

        Assert::assertTrue($method->isPublic());
        Assert::assertSame(1, $method->getNumberOfParameters());
    });

    it('execute accepts SmsData parameter', function () {
        $reflection = new \ReflectionClass(SendGammuSMSAction::class);
        $method = $reflection->getMethod('execute');
        $params = $method->getParameters();

        \assertReflectionTypeName($params[0]->getType(), SmsData::class);
    });

    it('execute returns array', function () {
        $reflection = new \ReflectionClass(SendGammuSMSAction::class);
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        \assertReflectionTypeName($returnType, 'array');
    });

    it('has required properties', function () {
        $reflection = new \ReflectionClass(SendGammuSMSAction::class);

        Assert::assertTrue($reflection->hasProperty('debug'));
        Assert::assertTrue($reflection->hasProperty('defaultSender'));
        Assert::assertTrue($reflection->hasProperty('gammuData'));
        Assert::assertTrue($reflection->hasProperty('vars'));
    });

    it('uses strict types', function () {
        $reflection = new \ReflectionClass(SendGammuSMSAction::class);
        $content = \notifyReflectionSource($reflection);
        Assert::assertStringContainsString('declare(strict_types=1)', (string) $content);
    });

    it('has correct namespace', function () {
        $reflection = new \ReflectionClass(SendGammuSMSAction::class);

        Assert::assertSame('Modules\Notify\Actions\SMS', $reflection->getNamespaceName());
    });

    it('has required imports', function () {
        $content = \notifyReflectionSource(new \ReflectionClass(SendGammuSMSAction::class));
        Assert::assertStringContainsString('declare(strict_types=1)', (string) $content);
    });

    it('is final class', function () {
        $reflection = new \ReflectionClass(SendGammuSMSAction::class);

        Assert::assertTrue($reflection->isFinal());
    });
});
