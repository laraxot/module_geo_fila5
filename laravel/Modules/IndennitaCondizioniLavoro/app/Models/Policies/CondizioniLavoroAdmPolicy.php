<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Models\Policies;

use Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoroAdm as MyModel;
use Modules\User\Models\User;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Policies\XotBasePolicy;
use Override;

class CondizioniLavoroAdmPolicy extends XotBasePolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function compila(UserContract $user, MyModel $condizioniLavoro): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view any models.
     */
    #[Override]
    public function viewAny(UserContract $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, MyModel $condizioniLavoro): bool
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
    public function update(UserContract $user, MyModel $condizioniLavoro): bool
    {
        return false; // puo' far modifica solo superadmin
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, MyModel $condizioniLavoro): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, MyModel $condizioniLavoro): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, MyModel $condizioniLavoro): bool
    {
        return false;
    }
}
