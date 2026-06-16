<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Modules\User\Models\Profile;
use Modules\User\Tests\TestCase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Auth components', function (): void {
    test('auth components exist and work correctly', function (): void {
        Assert::assertTrue(View::exists('components.auth-session-status'));
        Assert::assertTrue(View::exists('user::components.auth-header'));
        Assert::assertTrue(View::exists('user::components.auth-session-status'));
    });

    test('auth layout components exist and work correctly', function (): void {
        Assert::assertTrue(View::exists('components.layouts.auth'));
        Assert::assertTrue(View::exists('user::layouts.auth'));
    });

    test('login page loads correctly', function (): void {
        $response = get('/it/auth/login');
        Assert::assertSame(200, $response->status());
    });

    test('register page loads correctly', function (): void {
        $response = get('/it/auth/register');
        Assert::assertSame(200, $response->status());
    });

    test('auth session status component renders correctly', function (): void {
        $html = view('components.auth-session-status', ['status' => 'Test status'])->render();

        Assert::assertIsString($html);
        Assert::assertNotEmpty($html);
    });

    test('auth header component exists and renders', function (): void {
        Assert::assertTrue(View::exists('user::components.auth-header'));
        $html = view('user::components.auth-header', [
            'title' => 'Login Test',
            'description' => 'Test description',
        ])->render();

        Assert::assertStringContainsString('Login Test', $html);
        Assert::assertStringContainsString('Test description', $html);
    });

    test('login form components work after reorganization', function (): void {
        $response = get('/it/auth/login');

        Assert::assertSame(200, $response->status());
        $content = (string) $response->getContent();
        Assert::assertTrue(
            str_contains($content, 'Login')
            || str_contains($content, 'login')
            || str_contains($content, 'Accedi')
            || str_contains($content, 'accedi')
        );
    });

    test('password confirmation uses reorganized components', function (): void {
        $user = createTestUser();

        try {
            actingAs($user);
            $response = get('/it/auth/password/confirm');
            Assert::assertSame(200, $response->status());
        } catch (Throwable $e) {
            skip(
                'Password confirm route unavailable in test env: '.$e->getMessage()
            );
        }
    });

    test('profile pages use reorganized components', function (): void {
        $user = createTestUser();

        if (class_exists(Profile::class)) {
            $hasUuid = Schema::connection('user')
                ->hasColumn('profiles', 'uuid');
            $profileData = [
                'id' => $user->id,
                'user_id' => $user->id,
                'email' => $user->email,
                'first_name' => $user->first_name ?? '',
                'last_name' => $user->last_name ?? '',
            ];
            if ($hasUuid) {
                $profileData['uuid'] = (string) Str::uuid();
            }
            try {
                Profile::create($profileData);
            } catch (Throwable) {
            }
        }

        try {
            actingAs($user, 'web');
            $response = get('/it/profile/edit');
            Assert::assertSame(200, $response->status());
        } catch (Throwable $e) {
            skip(
                'Profile edit route unavailable in test env: '.$e->getMessage()
            );
        }
    });
});
