<?php

declare(strict_types=1);

namespace Modules\User\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\User\Models\AuthenticationLog;

/**
 * Interfaccia che definisce i metodi per gestire i log di autenticazione associati a un utente.
 */
interface HasAuthentications
{
    /**
     * Ottiene tutti i log di autenticazione associati all'utente.
     *
     * @return MorphMany<AuthenticationLog, Model>
     */
    public function authentications(): MorphMany;
}
