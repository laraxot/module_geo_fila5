<?php

declare(strict_types=1);

namespace Modules\Geo\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class GeoServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Geo';
<<<<<<< HEAD
   protected string $moduleName = 'Geo';
=======
    protected string $moduleName = 'Geo';
>>>>>>> laraxot/dev
    protected string $namespace = 'geo';

    public function boot(): void
    {
        parent::boot();

<<<<<<< HEAD
       // $this->registerMapAssets();
=======
        // $this->registerMapAssets();
>>>>>>> laraxot/dev
    }
}
