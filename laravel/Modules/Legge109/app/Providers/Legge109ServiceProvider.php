<?php

declare(strict_types=1);

namespace Modules\Legge109\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class Legge109ServiceProvider extends XotBaseServiceProvider
{
    public string $module_dir = __DIR__;

    public string $module_ns = __NAMESPACE__;

    public string $name = 'Legge109';
}
