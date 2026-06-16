<?php

declare(strict_types=1);

use Modules\User\Models\Profile;
use Modules\User\Models\Team;
use Modules\User\Models\User;

/*
 * Bootstrap Pest — modulo User.
 * Helper globali: tests/Support/helpers.php (composer autoload-dev files).
 * Ogni file Pest dichiara uses(\Modules\User\Tests\TestCase::class).
 */

expect()->extend('toBeUser', function () {
    /* @phpstan-ignore-next-line */
    return $this->toBeInstanceOf(User::class);
});

expect()->extend('toBeTeam', function () {
    /* @phpstan-ignore-next-line */
    return $this->toBeInstanceOf(Team::class);
});

expect()->extend('toBeProfile', function () {
    /* @phpstan-ignore-next-line */
    return $this->toBeInstanceOf(Profile::class);
});
