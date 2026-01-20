<?php

declare(strict_types=1);

namespace Modules\PresenzeAssenze\Providers;

// --- bases ---
use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    public string $name = 'PresenzeAssenze';

    protected string $moduleNamespace = 'Modules\PresenzeAssenze\Http\Controllers';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;
}
