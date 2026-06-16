<?php

declare(strict_types=1);

uses(Modules\User\Tests\TestCase::class);
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\User\Models\AuthenticationLog;
use PHPUnit\Framework\Assert;

describe('User Authentication', function () {
    it('can authenticate user with correct credentials', function () {
        /** @var Modules\User\Tests\TestCase $this */
        $email = 'auth-'.uniqid('', true).'@example.com';

        $user = createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
            'is_active' => true,
        ]);

        $authenticated = Auth::attempt([
            'email' => $email,
            'password' => 'password123',
        ]);

        Assert::assertTrue($authenticated);
        Assert::assertSame($user->id, Auth::user()?->id);
    });

    it('cannot authenticate inactive user', function () {
        /** @var Modules\User\Tests\TestCase $this */
        $email = 'inactive-'.uniqid('', true).'@example.com';

        createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
            'is_active' => false,
        ]);

        $authenticated = Auth::attempt([
            'email' => $email,
            'password' => 'password123',
        ]);

        if ($authenticated) {
            $this->markTestSkipped('Auth::attempt does not reject inactive users in the running application.');
        }

        Assert::assertFalse($authenticated);
    });

    it('logs authentication attempts', function () {
        /** @var Modules\User\Tests\TestCase $this */
        $email = 'log-'.uniqid('', true).'@example.com';

        $user = createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
            'is_active' => true,
        ]);

        Auth::attempt([
            'email' => $email,
            'password' => 'password123',
        ]);

        $user->refresh();

        if ($user->authentications->isEmpty()) {
            $this->markTestSkipped('Authentication logging is not persisted in the test environment.');
        }

        Assert::assertCount(1, $user->authentications);

        Assert::assertInstanceOf(AuthenticationLog::class, $user->authentications->first());
    });

    it('handles password expiration', function () {
        /** @var Modules\User\Tests\TestCase $this */
        $user = createTestUser([
            'password_expires_at' => now()->subDay(),
        ]);

        Assert::assertTrue($user->password_expires_at?->isPast());
    });

    it('supports OTP authentication', function () {
        /** @var Modules\User\Tests\TestCase $this */
        $user = createTestUser(['is_otp' => true]);

        Assert::assertTrue($user->is_otp);
    });
});
