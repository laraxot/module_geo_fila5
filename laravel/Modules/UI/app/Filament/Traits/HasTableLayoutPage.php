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

    public function setLayoutView(TableLayoutEnum $layout): void
    {
        $this->layoutView = $layout;
    }

    public static function isLayoutCapable(object $livewire): bool
    {
        return in_array(self::class, class_uses_recursive($livewire::class), true);
    }

    public static function readLayoutFrom(object $livewire): ?TableLayoutEnum
    {
        if (! self::isLayoutCapable($livewire)) {
            return null;
        }

        return (function (): TableLayoutEnum {
            return $this->layoutView;
        })->call($livewire);
    }

    public static function applyLayoutTo(object $livewire, TableLayoutEnum $layout): void
    {
        if (! self::isLayoutCapable($livewire)) {
            return;
        }

        (function (TableLayoutEnum $layout): void {
            $this->layoutView = $layout;
        })->call($livewire, $layout);
    }
}
