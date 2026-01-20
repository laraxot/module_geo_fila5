<?php

declare(strict_types=1);

namespace Modules\Questionari\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class QuestionariServiceProvider extends XotBaseServiceProvider
{
    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    public string $name = 'Questionari';
}
