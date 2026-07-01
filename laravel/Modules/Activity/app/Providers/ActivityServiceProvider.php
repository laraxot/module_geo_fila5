<?php

declare(strict_types=1);

namespace Modules\Activity\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;
use Override;

/**
 * Service Provider per il modulo Activity.
 *
 * Gestisce la registrazione e il boot del modulo per il tracciamento delle attività utente.
 *
 * @phpstan-type ModuleConfig array{name: string, alias: string, description: string, keywords: array<int, string>, priority: int, providers: array<int, class-string>}
 */
class ActivityServiceProvider extends XotBaseServiceProvider
{
    /**
     * Nome del modulo.
     */
    public string $name = 'Activity';

    /**
     * Directory del modulo.
     *
     * NOTE: il nome deve restare snake_case ($module_dir) perche' XotBaseServiceProvider::boot()
     * legge proprio questa proprieta' per risolvere il path delle migrations. Un rename in
     * camelCase crea una proprieta' ombra mai letta dalla classe base (bug silenzioso: le
     * migrations del modulo Activity non verrebbero piu' caricate da loadMigrationsFrom()).
     */
    protected string $module_dir = __DIR__;

    /**
     * Namespace del modulo.
     *
     * NOTE: vedi commento su $module_dir, stesso motivo (usato da XotBaseServiceProvider::register()).
     */
    protected string $module_ns = __NAMESPACE__;

    /**
     * Boot del service provider.
     *
     * Configura il modulo Activity e registra le configurazioni specifiche.
     */
    #[Override]
    public function boot(): void
    {
        parent::boot();

        // Registro solo le configurazioni specifiche del modulo
        $this->registerConfig();

        // Registra i componenti Blade personalizzati
        $this->registerBladeComponents();
    }

    /**
     * Registra i servizi del provider.
     */

    /**
     * Registra le configurazioni del modulo.
     */
    #[Override]
    protected function registerConfig(): void
    {
        $this->publishes([
            module_path($this->name, 'config/config.php') => config_path('activity.php'),
        ], 'config');

        $this->mergeConfigFrom(module_path($this->name, 'config/config.php'), 'activity');
    }
}
