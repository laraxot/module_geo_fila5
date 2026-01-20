<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoro;
use Modules\User\Models\User;
use Modules\Xot\Contracts\UserContract;

/**
 * Policy for CondizioniLavoro.
 *
 * @SuppressWarnings("PMD.UnusedFormalParameter")
 */
class CodizioniLavoroPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, CondizioniLavoro $condizioniLavoro): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, CondizioniLavoro $condizioniLavoro): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, CondizioniLavoro $condizioniLavoro): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, CondizioniLavoro $condizioniLavoro): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, CondizioniLavoro $condizioniLavoro): bool
    {
        return false;
    }
}
