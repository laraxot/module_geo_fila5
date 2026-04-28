<?php

declare(strict_types=1);

namespace Modules\Geo\Providers;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Modules\Xot\Providers\XotBaseServiceProvider;

class GeoServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Geo';

    protected string $moduleName = 'Geo';

    protected string $namespace = 'geo';

    public function boot(): void
    {
        parent::boot();

        $this->registerMapAssets();
    }

    protected function registerMapAssets(): void
    {
        // REGOLA: nessun asset da CDN/unpkg.
        // Non registrare il vecchio bundle JS Geo globale: il tema Sixteen importa
        // i Web Component Geo nel proprio bundle Vite e il bundle legacy puo'
        // inizializzare dipendenze storiche non presenti (es. opening_hours).

        if (is_file(public_path('themes/Geo/css/leaflet.css'))) {
            FilamentAsset::register([
                Css::make('leaflet-css', asset('themes/Geo/css/leaflet.css')),
            ], 'geo');
        }
    }

    // REMOVED: public function register(): void
    // XotBaseServiceProvider gia' gestisce register() con registerBladeIcons().
    // Non sovrascrivere: causa doppia registrazione del prefix "geo" nei BladeIcons.
}
