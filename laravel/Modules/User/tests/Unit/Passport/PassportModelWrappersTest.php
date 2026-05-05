<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Passport;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\Passport;
use Modules\User\Models\OauthAuthCode;
use Modules\User\Models\OauthClient;
use Modules\User\Models\OauthDeviceCode;
use Modules\User\Models\OauthRefreshToken;
use Modules\User\Models\OauthToken;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

test('every eloquent passport model has a local oauth wrapper', function (): void {
    /** @var array<int, string>|false $files */
    $files = glob(base_path('vendor/laravel/passport/src').'/*.php');

    if (false === $files) {
        $files = [];
    }

    $shortNames = [];

    foreach ($files as $file) {
        $class = 'Laravel\\Passport\\'.basename($file, '.php');

        if (! class_exists($class)) {
            continue;
        }

        $reflection = new \ReflectionClass($class);

        if ($reflection->isAbstract()) {
            continue;
        }

        if (! $reflection->isSubclassOf(Model::class)) {
            continue;
        }

        $shortNames[] = $reflection->getShortName();
    }

    sort($shortNames);

    foreach ($shortNames as $shortName) {
        $passportClass = 'Laravel\\Passport\\'.$shortName;
        $wrapperClass = 'Modules\\User\\Models\\Oauth'.$shortName;

        expect(class_exists($wrapperClass))
            ->toBeTrue("Missing wrapper {$wrapperClass} for {$passportClass}");
        expect(is_subclass_of($wrapperClass, $passportClass))
            ->toBeTrue("{$wrapperClass} must extend {$passportClass}");
    }
});

test('passport uses user module oauth wrappers for eloquent models', function (): void {
    expect(Passport::authCodeModel())->toBe(OauthAuthCode::class);
    expect(Passport::clientModel())->toBe(OauthClient::class);
    expect(Passport::tokenModel())->toBe(OauthToken::class);
    expect(Passport::refreshTokenModel())
        ->toBe(OauthRefreshToken::class);

    if (method_exists(Passport::class, 'deviceCodeModel')) {
        expect(Passport::deviceCodeModel())
            ->toBe(OauthDeviceCode::class);
    }
});
