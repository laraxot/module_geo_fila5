<?php

declare(strict_types=1);

namespace Modules\Sindacati\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class SindacatiServiceProvider extends XotBaseServiceProvider
{
    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    public string $name = 'Sindacati';
}
