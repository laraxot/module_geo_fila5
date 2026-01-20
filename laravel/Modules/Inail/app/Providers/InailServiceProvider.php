<?php

declare(strict_types=1);

namespace Modules\Inail\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class InailServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Inail';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    public string $module_name = 'inail';
}
