<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit;

use Modules\User\Models\Permission;
use Modules\User\Models\Role;
use Modules\User\Models\Team;
use Modules\User\Tests\TestCase;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Support\Config as PermissionConfig;

uses(TestCase::class);

test('spatie permission registrar uses user module models for teams', function (): void {
    $registrar = app(PermissionRegistrar::class);

    expect(config('permission.teams'))->toBeTrue()
        ->and(config('permission.models.permission'))->toBe(Permission::class)
        ->and(config('permission.models.role'))->toBe(Role::class)
        ->and(config('permission.models.team'))->toBe(Team::class)
        ->and($registrar->getPermissionClass())->toBe(Permission::class)
        ->and($registrar->getRoleClass())->toBe(Role::class)
        ->and($registrar->getTeamClass())->toBe(Team::class)
        ->and(PermissionConfig::teamModel())->toBe(Team::class);
});
