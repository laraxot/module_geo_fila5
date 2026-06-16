<?php

declare(strict_types=1);

uses(Modules\User\Tests\TestCase::class);
use Modules\User\Filament\Widgets\Auth\SocialLoginWidget;
use PHPUnit\Framework\Assert;

describe('Microsoft Login Button', function () {
    test('social login widget renders correctly when microsoft is configured', function () {
        config(['services.microsoft.client_id' => 'test-client-id']);

        $widget = new SocialLoginWidget();
        $providers = $widget->getProviders();

        Assert::assertCount(1, $providers);
        Assert::assertSame('microsoft', $providers[0]['driver']);
        Assert::assertSame(__('user::auth.social.microsoft'), $providers[0]['label']);
    });

    test('social login widget returns empty when no providers configured', function () {
        config(['services.microsoft.client_id' => null]);
        config(['services.google.client_id' => null]);
        config(['services.github.client_id' => null]);

        $widget = new SocialLoginWidget();
        $providers = $widget->getProviders();

        Assert::assertEmpty($providers);
    });

    test('socialite microsoft redirect route exists', function () {
        $url = route('socialite.oauth.redirect', ['provider' => 'microsoft']);
        Assert::assertStringContainsString((string) 'microsoft', (string) $url);
    });
});
