<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Models;

use Illuminate\Contracts\Auth\Access\Authorizable;
use Laravel\Passport\AuthCode;
use Laravel\Passport\Client as PassportClient;
use Laravel\Passport\DeviceCode;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use Modules\User\Models\OauthAuthCode;
use Modules\User\Models\OauthClient;
use Modules\User\Models\OauthDeviceCode;
use Modules\User\Models\OauthRefreshToken;
use Modules\User\Models\OauthToken;
use Modules\User\Tests\TestCase;
use Spatie\Permission\Traits\HasRoles;

uses(TestCase::class);

test('passport eloquent models have oauth wrappers in user module', function (): void {
    $expectedWrappers = [
        AuthCode::class => OauthAuthCode::class,
        PassportClient::class => OauthClient::class,
        DeviceCode::class => OauthDeviceCode::class,
        RefreshToken::class => OauthRefreshToken::class,
        Token::class => OauthToken::class,
    ];

    foreach ($expectedWrappers as $passportClass => $wrapperClass) {
        expect(class_exists($passportClass))->toBeTrue();
        expect(class_exists($wrapperClass))->toBeTrue();
        expect(is_subclass_of($wrapperClass, $passportClass))->toBeTrue();
        expect((new $wrapperClass())->getConnectionName())->toBe('user');
    }
});

test('oauth client implements authorizable contract', function (): void {
    $client = new OauthClient();
    expect($client)->toBeInstanceOf(Authorizable::class);
});

test('oauth client uses has roles trait', function (): void {
    $client = new OauthClient();
    expect(in_array(HasRoles::class, class_uses_recursive($client), true))->toBeTrue();
});

test('oauth client has guard name property', function (): void {
    $client = new OauthClient();
    expect($client->guard_name)->toBe('api');
});

test('oauth client has required attributes', function (): void {
    $client = new OauthClient();

    // Verify attributes are accessible (Eloquent magic via __get/__isset)
    expect(isset($client->id))->toBeTrue();
    expect(isset($client->name))->toBeTrue();
    expect(isset($client->secret))->toBeTrue();
    expect(isset($client->provider))->toBeTrue();
    expect(isset($client->redirect))->toBeTrue();
    expect(isset($client->personal_access_client))->toBeTrue();
    expect(isset($client->password_client))->toBeTrue();
    expect(isset($client->revoked))->toBeTrue();
    expect(isset($client->user_id))->toBeTrue();
});
