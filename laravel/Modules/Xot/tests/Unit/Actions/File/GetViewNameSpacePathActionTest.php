<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Modules\Xot\Actions\File\GetViewNameSpacePathAction;
use Modules\Xot\Datas\XotData;
use PHPUnit\Framework\Assert;

it('gets view namespace path from theme fallback correctly', function (): void {
    /** @var Modules\Xot\Tests\TestCase $this */
    $ns = 'pub_theme';
    $themeName = 'TestTheme';

    // Create a concrete instance of XotData
    $xotData = XotData::from(['pub_theme' => $themeName]);

    // Inject it into the singleton instance using reflection
    $reflection = new ReflectionClass(XotData::class);
    $instanceProperty = $reflection->getProperty('instance');
    $instanceProperty->setAccessible(true);
    $instanceProperty->setValue(null, $xotData);

    $action = app(GetViewNameSpacePathAction::class);
    $result = $action->execute($ns);

    Assert::assertSame(base_path('Themes/'.$themeName), $result);
    // Reset instance for other tests
    $instanceProperty->setValue(null, null);
});
