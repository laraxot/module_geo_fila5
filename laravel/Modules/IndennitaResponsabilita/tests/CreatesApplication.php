<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;

trait CreatesApplication
{
    public function createApplication(): Application
    {
        $basePath = realpath(__DIR__.'/../../../');

        $_ENV['APP_BASE_PATH'] = $basePath;

        $app = require $basePath.'/bootstrap/app.php';

        $app->instance('path.base', $basePath);
        $app->bind('path.public', fn () => $basePath.'/public_html');
        $app->bind('path.storage', fn () => $basePath.'/storage');

        $app->make(Kernel::class)->bootstrap();
        $app->boot();

        return $app;
    }
}