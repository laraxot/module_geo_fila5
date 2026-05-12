<?php

declare(strict_types=1);

namespace Modules\User\Models\Policies;

use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Policies\XotBasePolicy;
use Modules\User\Models\Permission;

/**
 * @template TModel of Model
 */
abstract class UserBasePolicy extends XotBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): Response|bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): Response|bool
    {
        return true;
    }

    protected function hasPermission(UserContract $user, string $permission): bool
    {
        $exists = Permission::query()
            ->where('name', $permission)
            ->where('guard_name', 'web')
            ->exists();

        if (! $exists) {
            return false;
        }

        try {
            return $user->hasPermissionTo($permission);
        } catch (\Throwable) {
            return false;
        }
    }
}
