<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Filament;

use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Illuminate\Support\Facades\Auth;
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
            /** @var \Filament\Panel $panel */
            $navs[] = NavigationItem::make($panel->getId())
                ->url('/'.$panel->getPath())
                /** @phpstan-ignore-next-line method.notFound (mixin methods added at runtime) */
                ->icon($panel->getNavigationIcon())
                ->group('Modules')
                /** @phpstan-ignore-next-line method.notFound (mixin methods added at runtime) */
                ->label($panel->getNavigationLabel())
                /** @phpstan-ignore-next-line method.notFound (mixin methods added at runtime) */
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
