<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Filament\Widgets\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;
use Modules\User\Filament\Widgets\Auth\RegisterWidget;
use Modules\User\Filament\Widgets\Auth\Schemas\UserForm;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

use function Pest\Laravel\get;

use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    config(['activitylog.enabled' => false]);

    if (! Schema::connection('user')->hasTable('users')) {
        skip('users table missing on user connection (run migrations for testing)');
    }
});

describe('Register Widget', function (): void {
    test('register page loads with livewire widget', function (): void {
        get('/it/auth/register')->assertSuccessful();
        Livewire::test(RegisterWidget::class)->assertSuccessful();
    });

    test('delegates form schema to user form via form class', function (): void {
        $reflection = new \ReflectionClass(RegisterWidget::class);

        $formClass = $reflection->getMethod('formClass');
        $formClass->setAccessible(true);
        Assert::assertSame(UserForm::class, $formClass->invoke(null));
        $schemaMethod = $reflection->getMethod('schemaMethod');
        $schemaMethod->setAccessible(true);
        Assert::assertSame('getRegisterFormSchema', $schemaMethod->invoke(null));
    });

    test('can register user via submit', function (): void {
        $email = 'pest-register-'.uniqid('', true).'@example.test';

        Livewire::test(RegisterWidget::class)
            ->fillForm([
                'first_name' => 'Mario',
                'last_name' => 'Rossi',
                'email' => $email,
                'password' => 'Password1!Secure',
                'password_confirmation' => 'Password1!Secure',
            ])
            ->call('submit')
            ->assertHasNoErrors();

        $this->assertAuthenticated();

        $this->assertDatabaseHasRow(User::class, ['email' => $email]);
    });

    test('rejects invalid email without creating user', function (): void {
        Livewire::test(RegisterWidget::class)
                    ->fillForm([
                        'first_name' => 'Mario',
                        'last_name' => 'Rossi',
                        'email' => 'not-an-email',
                        'password' => 'Password1!Secure',
                        'password_confirmation' => 'Password1!Secure',
                    ])
                    ->call('submit')
                    ->assertHasErrors();

        Assert::assertFalse(Auth::check());
    });

    test('save delegates to submit', function (): void {
        $email = 'pest-save-'.uniqid('', true).'@example.test';

        Livewire::test(RegisterWidget::class)
            ->fillForm([
                'first_name' => 'Luigi',
                'last_name' => 'Verdi',
                'email' => $email,
                'password' => 'Password1!Secure',
                'password_confirmation' => 'Password1!Secure',
            ])
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHasRow(User::class, ['email' => $email]);
    });
});
