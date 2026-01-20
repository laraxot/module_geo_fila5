<?php

declare(strict_types=1);

namespace Modules\Setting\Models\Policies;

use Modules\Setting\Models\DatabaseConnection;
use Modules\Xot\Contracts\ProfileContract;

class DatabaseConnectionPolicy extends SettingBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(ProfileContract $user): bool
    {
        return $user->hasPermissionTo('database_connection.viewAny'); /** @phpstan-ignore method.nonObject */
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(ProfileContract $user, DatabaseConnection $database_connection): bool
    {
        return $user->hasPermissionTo('database_connection.view'); /** @phpstan-ignore method.nonObject */
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(ProfileContract $user): bool
    {
        return $user->hasPermissionTo('database_connection.create'); /** @phpstan-ignore method.nonObject */
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(ProfileContract $user, DatabaseConnection $database_connection): bool
    {
        return $user->hasPermissionTo('database_connection.update'); /** @phpstan-ignore method.nonObject */
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(ProfileContract $user, DatabaseConnection $database_connection): bool
    {
        return $user->hasPermissionTo('database_connection.delete'); /** @phpstan-ignore method.nonObject */
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(ProfileContract $user, DatabaseConnection $database_connection): bool
    {
        return $user->hasPermissionTo('database_connection.restore'); /** @phpstan-ignore method.nonObject */
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(ProfileContract $user, DatabaseConnection $database_connection): bool
    {
        return $user->hasPermissionTo('database_connection.forceDelete'); /** @phpstan-ignore method.nonObject */
    }
}
