<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Actions\Table;

use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Modules\UI\Contracts\HasTableLayoutView;
use Modules\UI\Enums\TableLayoutEnum;

final class TableLayoutToggleTableAction extends Action implements HasTableLayout
{
    use TableLayoutTrait;

    protected function setUp(): void
    {
        parent::setUp();

        $this->iconButton()
            ->label('')
            ->tooltip(fn (): string => $this->resolveTargetLayout()->getLabel())
            ->icon(fn (): string => $this->resolveTargetLayout()->getIcon())
            ->action($this->toggleLayout(...));
    }

    public static function getDefaultName(): string
    {
        return 'table_layout_toggle';
    }

    protected function toggleLayout(): void
    {
        $livewire = $this->getLivewire();

        if (! $livewire instanceof HasTableLayoutView) {
            return;
        }

        $newLayout = $this->resolveLayout($livewire)->toggle();

        $this->setTableLayout($newLayout);
        $livewire->layoutView = $newLayout;

        if ($livewire instanceof ListRecords) {
            $livewire->resetTable();
        }
    }

    private function resolveTargetLayout(?HasTableLayoutView $livewire = null): TableLayoutEnum
    {
        return $this->resolveLayout($livewire)->toggle();
    }

    private function resolveLayout(?HasTableLayoutView $livewire = null): TableLayoutEnum
    {
        if ($livewire instanceof HasTableLayoutView) {
            return $livewire->layoutView;
        }

        $component = $this->getLivewire();

        if ($component instanceof HasTableLayoutView) {
            return $component->layoutView;
        }

        return $this->getCurrentLayout();
    }
}
