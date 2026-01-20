<?php

declare(strict_types=1);

namespace Modules\Europa\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class EuropaServiceProvider extends XotBaseServiceProvider
{
    public string $module_dir = __DIR__;

    public string $module_ns = __NAMESPACE__;

    public string $name = 'Europa';
}
