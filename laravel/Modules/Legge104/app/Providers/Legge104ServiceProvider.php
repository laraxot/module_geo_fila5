<?php

declare(strict_types=1);

namespace Modules\Legge104\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class Legge104ServiceProvider extends XotBaseServiceProvider
{
    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    public string $name = 'Legge104';
}
