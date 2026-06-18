<?php

declare(strict_types=1);

namespace Modules\UI\Contracts;

use Modules\UI\Enums\TableLayoutEnum;

/**
 * Pagina Livewire con proprietà layout tabella (lista/griglia).
 */
interface HasTableLayoutView
{
    public TableLayoutEnum $layoutView { get; set; }
}
