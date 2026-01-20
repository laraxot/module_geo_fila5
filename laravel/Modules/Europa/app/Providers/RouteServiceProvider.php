<?php

declare(strict_types=1);

namespace Modules\Europa\Providers;

// --- bases ---
use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     */
    protected string $moduleNamespace = 'Modules\Europa\Http\Controllers';

    public string $name = 'Europa';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;
}
