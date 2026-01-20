<?php

declare(strict_types=1);

namespace Modules\Sigma\Http\Middleware;

use Exception;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Nwidart\Modules\Module;
use Str;

class FilamentMiddleware extends Middleware
{
    public static string $module = 'Sigma';

    public static string $context = 'filament';

    private function getModule(): Module
    {
        /** @var Module $module */
        $module = app('modules')->findOrFail(static::$module);

        return $module;
    }

    /**
     * @throws Exception
     */
    private function getContextName(): string
    {
        $module = $this->getModule();
        if (static::$context === '' || static::$context === '0') {
            throw new Exception('Context has to be defined in your class');
        }

        return Str::of($module->getLowerName())
            ->append('-')
            ->append(Str::slug(static::$context))
            ->kebab()
            ->toString();
    }

    #[\Override]
    protected function authenticate($request, array $guards): void
    {
        $contextName = $this->getContextName();
        /** @var string|null $guardName */
        $guardName = config($contextName.'.auth.guard');
        if ($guardName === null) {
            $this->unauthenticated($request, $guards);

            // unauthenticated() termina l'esecuzione con redirect/abort
        }
        $guard = $this->auth->guard($guardName);

        if (! $guard->check()) {
            $this->unauthenticated($request, $guards);

            // unauthenticated() termina l'esecuzione con redirect/abort
        }

        $this->auth->shouldUse($guardName);

        $user = $guard->user();

        if ($user instanceof FilamentUser) {
            if (! $user->canAccessFilament()) {
                abort(403);
            }

            // User ha accesso Filament, autenticazione completata
            return;
        }

        /** @var string $env */
        $env = config('app.env', 'production');
        if ($env !== 'local') {
            abort(403);
        }

        // In ambiente local, permettere accesso anche senza FilamentUser (nessun return necessario)
    }

    #[\Override]
    protected function redirectTo($request): string
    {
        $contextName = $this->getContextName();

        return route($contextName.'.auth.login');
    }
}
