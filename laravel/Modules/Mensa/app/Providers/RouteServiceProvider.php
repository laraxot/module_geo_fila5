<?php

declare(strict_types=1);

namespace Modules\Mensa\Providers;

// --- bases ---
use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     */
    protected string $moduleNamespace = 'Modules\Mensa\Http\Controllers';

    public string $name = 'Mensa';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;
}
