<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions\SMS;
use Modules\Notify\Tests\TestCase;
use function Safe\file_get_contents;
use Modules\Notify\Actions\SMS\SendAgiletelecomSMSAction;
use Modules\Notify\Datas\SmsData;
use PHPUnit\Framework\Assert;
use Spatie\QueueableAction\QueueableAction;

use function Safe\class_uses;

uses(\Modules\Notify\Tests\TestCase::class);

describe('SendAgiletelecomSMSAction', function () {
        it('can be instantiated', function () {
        Assert::assertTrue(class_exists(SendAgiletelecomSMSAction::class));
    });

    it('implements SmsActionContract', function () {
        Assert::assertTrue(class_exists(SendAgiletelecomSMSAction::class));
    });

    it('has execute method with correct signature', function () {
        $reflection = new \ReflectionClass(SendAgiletelecomSMSAction::class);
        $method = $reflection->getMethod('execute');

        Assert::assertTrue($method->isPublic());
        Assert::assertSame(1, $method->getNumberOfParameters());
    });

    it('execute accepts SmsData parameter', function () {
        $reflection = new \ReflectionClass(SendAgiletelecomSMSAction::class);
        $method = $reflection->getMethod('execute');
        $params = $method->getParameters();

        \assertReflectionTypeName($params[0]->getType(), SmsData::class);
    });

    it('execute returns array', function () {
        $reflection = new \ReflectionClass(SendAgiletelecomSMSAction::class);
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        \assertReflectionTypeName($returnType, 'array');
    });

    it('uses strict types', function () {
        $reflection = new \ReflectionClass(SendAgiletelecomSMSAction::class);
        $content = \notifyReflectionSource($reflection);
        Assert::assertStringContainsString('declare(strict_types=1)', $content);
    });

    it('has correct namespace', function () {
        $reflection = new \ReflectionClass(SendAgiletelecomSMSAction::class);

        Assert::assertSame('Modules\Notify\Actions\SMS', $reflection->getNamespaceName());
    });

    it('has required imports', function () {
        $content = \notifyReflectionSource(new \ReflectionClass(SendAgiletelecomSMSAction::class));

        Assert::assertStringContainsString('use Modules\Notify\Contracts\SMS\SmsActionContract', $content);
        Assert::assertStringContainsString('use Modules\Notify\Datas\SmsData', $content);
        Assert::assertStringContainsString('use Override', $content);
    });

    it('does not use QueueableAction trait', function () {
        $traits = class_uses(SendAgiletelecomSMSAction::class);

        Assert::assertArrayNotHasKey(QueueableAction::class, $traits);
    });
});
