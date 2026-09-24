<?php

declare(strict_types=1);

namespace Modules\Geo\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class GeoServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Geo';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;
    protected string $moduleName = 'Geo';
    protected string $namespace = 'geo';

    public function boot(): void
    {
        parent::boot();

        // $this->registerMapAssets();
    }
}
