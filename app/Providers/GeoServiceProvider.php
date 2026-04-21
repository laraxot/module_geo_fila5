<?php

declare(strict_types=1);

namespace Modules\Geo\Providers;

use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
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
        // REGOLA: nessun asset da CDN/unpkg — usare solo asset locali pubblicati
        // Bundle mix pubblicato in public_html/themes/Geo/js/ (geo module mix build)
        // manifest.js → vendor.js → geo.js (include map-picker-lit + geoMapPickerField)
        FilamentAsset::register([
            Js::make('geo-manifest', asset('themes/Geo/js/manifest.js')),
            Js::make('geo-vendor', asset('themes/Geo/js/vendor.js')),
            Js::make('geo-bundle', asset('themes/Geo/js/geo.js')),
        ], 'geo');

        FilamentAsset::register([
            Css::make('leaflet-css', asset('themes/Geo/css/leaflet.css')),
        ], 'geo');
    }
}
