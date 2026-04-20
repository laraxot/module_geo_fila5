<?php

declare(strict_types=1);

namespace Modules\Geo\Providers\Filament;

use Filament\Panel;
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
        /*
         * Geo map assets are loaded through theme Vite bundles.
         * Keep panel provider lean to avoid frontoffice 404 requests
         * for legacy Filament asset IDs (geo-leaflet-*.css, geo-module-scripts.js).
         */
        return parent::panel($panel);
    }
}
