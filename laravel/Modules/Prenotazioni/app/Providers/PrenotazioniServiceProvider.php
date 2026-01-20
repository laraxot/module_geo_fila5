<?php

declare(strict_types=1);

namespace Modules\Prenotazioni\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class PrenotazioniServiceProvider extends XotBaseServiceProvider
{
    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    public string $name = 'Prenotazioni';
}
