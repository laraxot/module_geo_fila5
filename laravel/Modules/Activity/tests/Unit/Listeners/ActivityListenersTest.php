<?php

declare(strict_types=1);

uses(\Modules\Activity\Tests\TestCase::class);

use Modules\Activity\Listeners\LoginListener;
use Modules\Activity\Listeners\LogoutListener;

test('LoginListener can be instantiated', function () {
<<<<<<< HEAD
    $listener = new LoginListener;
=======
    $listener = new LoginListener();
>>>>>>> ac0ea089 (.)

    expect($listener)->toBeObject();
});

test('LogoutListener can be instantiated', function () {
<<<<<<< HEAD
    $listener = new LogoutListener;
=======
    $listener = new LogoutListener();
>>>>>>> ac0ea089 (.)

    expect($listener)->toBeObject();
});
