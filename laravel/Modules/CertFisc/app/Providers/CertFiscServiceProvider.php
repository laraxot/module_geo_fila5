<?php

declare(strict_types=1);

namespace Modules\CertFisc\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class CertFiscServiceProvider extends XotBaseServiceProvider
{
    // public static string $model = 'Modules\Blog\Models\Article';

    public string $module_dir = __DIR__;

    public string $module_ns = __NAMESPACE__;

    public string $name = 'CertFisc';
}
