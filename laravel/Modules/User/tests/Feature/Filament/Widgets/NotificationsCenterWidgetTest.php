<?php

declare(strict_types=1);

uses(Modules\User\Tests\TestCase::class);
use Modules\User\Filament\Widgets\Auth\NotificationsCenterWidget;
use PHPUnit\Framework\Assert;

it('redirects guests from notifiche page', function (): void {
    /** @var Modules\User\Tests\TestCase $this */
    $response = $this->get('/it/area-personale/notifications');

    $response->assertRedirect();
});

it('uses notifications center widget view', function (): void {
    /** @var Modules\User\Tests\TestCase $this */
    $widget = new NotificationsCenterWidget();
    $reflection = new ReflectionClass($widget);
    $property = $reflection->getProperty('view');
    $property->setAccessible(true);
    $view = $property->getValue($widget);

    Assert::assertSame('user::widgets.auth.notifications-center-widget', $view);
});
