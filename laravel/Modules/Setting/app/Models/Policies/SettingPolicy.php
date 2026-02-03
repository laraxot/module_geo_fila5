<?php

declare(strict_types=1);

namespace Modules\Setting\Models\Policies;

use Modules\Setting\Models\Setting;
use Modules\Xot\Contracts\ProfileContract;

class SettingPolicy extends SettingBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(ProfileContract $user): bool
    {
        return $user->hasPermissionTo('setting.viewAny'); /* @phpstan-ignore method.nonObject */
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(ProfileContract $user, Setting $setting): bool
    {
        return $user->hasPermissionTo('setting.view'); /* @phpstan-ignore method.nonObject */
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(ProfileContract $user): bool
    {
        return $user->hasPermissionTo('setting.create'); /* @phpstan-ignore method.nonObject */
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(ProfileContract $user, Setting $setting): bool
    {
        return $user->hasPermissionTo('setting.update'); /* @phpstan-ignore method.nonObject */
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(ProfileContract $user, Setting $setting): bool
    {
        return $user->hasPermissionTo('setting.delete'); /* @phpstan-ignore method.nonObject */
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(ProfileContract $user, Setting $setting): bool
    {
        return $user->hasPermissionTo('setting.restore'); /* @phpstan-ignore method.nonObject */
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(ProfileContract $user, Setting $setting): bool
    {
        return $user->hasPermissionTo('setting.forceDelete'); /* @phpstan-ignore method.nonObject */
    }
}
