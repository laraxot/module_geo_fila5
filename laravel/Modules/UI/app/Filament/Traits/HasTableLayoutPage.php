<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Traits;

use Modules\UI\Enums\TableLayoutEnum;
use Modules\UI\Filament\Actions\Table\TableLayoutTrait;

/**
 * Sincronizza la proprietà Livewire layoutView con la preferenza in sessione.
 *
 * @property TableLayoutEnum $layoutView
 */
trait HasTableLayoutPage
{
    use TableLayoutTrait;

    public function mountTableLayoutFromSession(string $identifier = 'default'): void
    {
        $this->layoutView = $this->getCurrentLayout($identifier);
    }
}
