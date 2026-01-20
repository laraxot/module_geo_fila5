<?php

declare(strict_types=1);

namespace Modules\Sindacati\Providers;

// --- bases ---
use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    public string $name = 'Sindacati';

    protected string $moduleNamespace = 'Modules\Sindacati\Http\Controllers';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;
}
