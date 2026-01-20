<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models\Policies;

use Modules\Progressioni\Models\Schede;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Policies\XotBasePolicy;
use Override;

class SchedePolicy extends XotBasePolicy
{
    #[Override]
    public function before(UserContract $user, string $ability): ?bool
    {
        return null;
    }

    #[Override]
    public function viewAny(UserContract $userContract): bool
    {
        return true;
    }

    public function index(UserContract $userContract, Schede $model): bool
    {
        return true;
    }

    public function edit(UserContract $userContract, Schede $model): bool
    {
        return false;
    }

    public function destroy(UserContract $userContract, Schede $model): bool
    {
        return false;
    }

    public function update(UserContract $userContract, Schede $model): bool
    {
        return true;
    }

    public function create(UserContract $userContract): bool
    {
        return false;
    }

    public function schedaMassMail(UserContract $userContract, Schede $model): bool
    {
        return true;
    }

    public function xlsrows(UserContract $userContract, Schede $model): bool
    {
        return true;
    }

    public function graduatoriaPdf(UserContract $userContract, Schede $model): bool
    {
        return true;
    }

    public function compila(UserContract $userContract, Schede $model): bool
    {
        return (bool) $model->ha_diritto;
    }

    public function schedaPdf(UserContract $userContract, Schede $model): bool
    {
        return (bool) $model->ha_diritto;
    }

    public function schedaMail(UserContract $userContract, Schede $model): bool
    {
        return (bool) $model->ha_diritto;
    }

    public function sendMail(UserContract $userContract, Schede $model): bool
    {
        return (bool) $model->ha_diritto;
    }
}
