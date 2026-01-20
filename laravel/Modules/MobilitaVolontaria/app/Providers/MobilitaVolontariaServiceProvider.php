<?php

declare(strict_types=1);

namespace Modules\MobilitaVolontaria\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class MobilitaVolontariaServiceProvider extends XotBaseServiceProvider
{
    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    public string $name = 'MobilitaVolontaria';
}
