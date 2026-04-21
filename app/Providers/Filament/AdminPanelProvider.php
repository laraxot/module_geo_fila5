<?php

declare(strict_types=1);

namespace Modules\Geo\Providers\Filament;

use Filament\Panel;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;

/**
 * Undocumented class.
 */
class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'Geo';

    #[\Override]
    public function panel(Panel $panel): Panel
    {
        $panel = parent::panel($panel);

        FilamentAsset::register([
            Js::make('geo-map-widget', asset('modules/geo/geo-map-widget.js'))->module(),
            Css::make('geo-map-picker', asset('modules/geo/map-picker.css')),
            Js::make('geo-map-picker', asset('modules/geo/map-picker.js'))->module(),
        ], 'geo');

        return $panel;
    }
}
