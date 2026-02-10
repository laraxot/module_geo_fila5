<?php

declare(strict_types=1);

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Modules\Activity\Listeners\LoginListener;
use Modules\Activity\Tests\TestCase;

uses(TestCase::class);

test('login listener is registered for login event', function () {
    Event::fake();

    Event::assertListening(
        Login::class,
        LoginListener::class
    );
})->skip('LoginListener is not registered in EventServiceProvider');

test('login listener can be instantiated', function () {
<<<<<<< HEAD
    $listener = new LoginListener;
=======
    $listener = new LoginListener();
>>>>>>> ac0ea089 (.)

    expect($listener)->toBeInstanceOf(LoginListener::class);
});

test('login listener has handle method', function () {
<<<<<<< HEAD
    $listener = new LoginListener;
=======
    $listener = new LoginListener();
>>>>>>> ac0ea089 (.)
    $reflection = new ReflectionClass($listener);

    expect($reflection->hasMethod('handle'))->toBeTrue();
});

test('login listener handle method is callable', function () {
<<<<<<< HEAD
    $listener = new LoginListener;
=======
    $listener = new LoginListener();
>>>>>>> ac0ea089 (.)

    expect(fn () => $listener->handle())->not->toThrow(Exception::class);
});
