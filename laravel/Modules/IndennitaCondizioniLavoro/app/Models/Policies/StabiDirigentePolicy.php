<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Models\Policies;

use Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoro;
use Modules\User\Models\User;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Policies\XotBasePolicy;
use Override;

class StabiDirigentePolicy extends XotBasePolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function compila(UserContract $_user, CondizioniLavoro $_condizioniLavoro): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view any models.
     */
    #[Override]
    public function viewAny(UserContract $_user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $_user, CondizioniLavoro $_condizioniLavoro): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $_user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $_user, CondizioniLavoro $_condizioniLavoro): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $_user, CondizioniLavoro $_condizioniLavoro): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $_user, CondizioniLavoro $_condizioniLavoro): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $_user, CondizioniLavoro $_condizioniLavoro): bool
    {
        return false;
    }
}
