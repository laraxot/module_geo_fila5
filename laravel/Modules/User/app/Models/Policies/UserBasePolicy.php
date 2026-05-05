<?php

declare(strict_types=1);

/**
 * ----------------------------------------------------------------.
 * EX XotBasePolicy.
 */

namespace Modules\User\Models\Policies;

use Illuminate\Auth\Access\Response;
use Modules\Fixcity\Models\Ticket;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Policies\XotBasePolicy;

abstract class UserBasePolicy extends XotBasePolicy
{
    // Only user-specific authorization rules here
    // Universal rules come from parent XotBasePolicy
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): Response|bool
    {
        return true;
        // return $user->can('List tickets');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Ticket $ticket): Response|bool
    {
        return true;
        /*
        return $user->can('View ticket')
            && (
                $ticket->owner_id === $user->id
                || $ticket->responsible_id === $user->id
                || $ticket->project->users()->where('users.id', authId())->count()
                || $ticket->project->owner_id === $user->id
            );
        */
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): Response|bool
    {
        return $user->hasPermissionTo('Create ticket');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return Response|bool
     */
    public function update(UserContract $user, Ticket $ticket)
    {
        return true;
        /*
        return $user->can('Update ticket')
            && (
                $ticket->owner_id === $user->id
                || $ticket->responsible_id === $user->id
                || $ticket->project->users()->where('users.id', authId())->count()
                || $ticket->project->owner_id === $user->id
            );
        */
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Ticket $ticket): Response|bool
    {
        return $user->hasPermissionTo('Delete ticket');
    }
}
