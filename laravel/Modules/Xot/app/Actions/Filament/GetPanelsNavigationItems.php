<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Filament;

use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Illuminate\Support\Facades\Auth;
use Modules\Xot\Contracts\PanelContract;
use Spatie\QueueableAction\QueueableAction;

/**
 * Elementi di navigazione cross-panel per i moduli Filament.
 * Utilizza PanelMixin per risolvere le proprietà del panel.
 */
class GetPanelsNavigationItems
{
    use QueueableAction;

    /**
     * @return array<int, NavigationItem>
     */
    public function execute(): array
    {
        $navs = [];
        foreach (Filament::getPanels() as $panel) {
            /** @var Panel&PanelContract $panel */
            $navs[] = NavigationItem::make($panel->getId())
                ->url('/'.$panel->getPath())
                ->icon($panel->getNavigationIcon())
                ->group('Modules')
                ->label($panel->getNavigationLabel())
                ->sort($panel->getNavigationSort())
                ->visible(static function () use ($panel): bool {
                    /** @var FilamentUser|null $user */
                    $user = Auth::user();
                    if (null === $user) {
                        return false;
                    }

                    return (bool) $user->canAccessPanel($panel);
                });
        }

        return $navs;
    }
}
