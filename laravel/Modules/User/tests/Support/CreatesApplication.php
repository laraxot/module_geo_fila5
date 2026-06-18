<?php

declare(strict_types=1);

namespace Modules\Xot\Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;

use function Safe\realpath;

/**
 * PHPStan-visible CreatesApplication trait for XotBaseTestCase.
 *
 * Mirrors Modules/Xot/tests/CreatesApplication.php with proper namespace.
 */
trait CreatesApplication
{
    public function createApplication(): Application
    {
        $basePath = realpath(__DIR__.'/../../../../..');

        $_ENV['APP_BASE_PATH'] = $basePath;

        /** @var Application $app */
        $app = require $basePath.'/bootstrap/app.php';

        $app->instance('path.base', $basePath);
        $app->bind('path.public', fn (): string => $basePath.'/public_html');
        $app->bind('path.storage', fn (): string => $basePath.'/storage');

        $app->make(Kernel::class)->bootstrap();
        $app->boot();

        return $app;
    }
}
