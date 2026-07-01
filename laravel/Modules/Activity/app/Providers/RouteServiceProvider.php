<?php

declare(strict_types=1);

namespace Modules\Activity\Providers;

use Modules\Xot\Providers\XotBaseRouteServiceProvider;

/**
 * Route Service Provider per il modulo Activity.
 *
 * Gestisce la registrazione delle route per il modulo Activity.
 */
class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    public string $name = 'Activity';

    /**
     * The module namespace to assume when generating URLs to actions.
     */
    protected string $moduleNamespace = 'Modules\Activity\Http\Controllers';

    // NOTE: i nomi devono restare snake_case ($module_dir/$module_ns) perche'
    // XotBaseRouteServiceProvider legge internamente proprio queste proprieta'
    // (vedi Modules/Xot/app/Providers/XotBaseRouteServiceProvider.php). Un rename
    // in camelCase creerebbe proprieta' ombra mai lette dalla classe base,
    // rompendo silenziosamente la registrazione delle route del modulo.
    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;
}
