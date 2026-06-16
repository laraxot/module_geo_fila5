<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions;
use Modules\Notify\Tests\TestCase;
use function Safe\file_get_contents;
use Modules\Notify\Actions\NetfunSendAction;
use Modules\Notify\Datas\SmsData;
use PHPUnit\Framework\Assert;
use Spatie\QueueableAction\QueueableAction;

use function Safe\class_uses;

uses(\Modules\Notify\Tests\TestCase::class);

describe('NetfunSendAction', function () {
    // Test strutturali senza istanziazione - la classe richiede config() nel costruttore
    it('has correct class definition', function () {
        $reflection = new \ReflectionClass(NetfunSendAction::class);

        Assert::assertTrue($reflection->isInstantiable());
    });

    it('uses QueueableAction trait', function () {
        $traits = class_uses(NetfunSendAction::class);
        Assert::assertArrayHasKey(QueueableAction::class, $traits);
    });

    it('has execute method with correct signature', function () {
        $reflection = new \ReflectionClass(NetfunSendAction::class);
        $method = $reflection->getMethod('execute');

        Assert::assertTrue($method->isPublic());
        Assert::assertSame(1, $method->getNumberOfParameters());
    });

    it('execute accepts SmsData parameter', function () {
        $reflection = new \ReflectionClass(NetfunSendAction::class);
        $method = $reflection->getMethod('execute');
        $params = $method->getParameters();

        \assertReflectionTypeName($params[0]->getType(), SmsData::class);
    });

    it('execute returns array', function () {
        $reflection = new \ReflectionClass(NetfunSendAction::class);
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        \assertReflectionTypeName($returnType, 'array');
    });

    it('has token property', function () {
        $reflection = new \ReflectionClass(NetfunSendAction::class);

        Assert::assertTrue($reflection->hasProperty('token'));
    });

    it('has vars property', function () {
        $reflection = new \ReflectionClass(NetfunSendAction::class);

        Assert::assertTrue($reflection->hasProperty('vars'));
    });

    it('uses strict types', function () {
        $reflection = new \ReflectionClass(NetfunSendAction::class);
        $content = \notifyReflectionSource($reflection);
        Assert::assertStringContainsString('declare(strict_types=1)', (string) $content);
    });

    it('has correct namespace', function () {
        $reflection = new \ReflectionClass(NetfunSendAction::class);

        Assert::assertSame('Modules\Notify\Actions', $reflection->getNamespaceName());
    });
});
