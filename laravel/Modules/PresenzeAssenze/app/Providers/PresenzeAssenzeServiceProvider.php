<?php

declare(strict_types=1);

namespace Modules\PresenzeAssenze\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class PresenzeAssenzeServiceProvider extends XotBaseServiceProvider
{
    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    public string $name = 'PresenzeAssenze';
}
