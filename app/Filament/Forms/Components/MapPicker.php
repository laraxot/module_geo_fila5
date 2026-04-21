<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Modules\Geo\Filament\Forms\Components\Traits\HasCoordinatePicker;
use Modules\Xot\Filament\Forms\Components\XotBaseField;

/**
 * MapPicker - Geographic coordinate picker with Leaflet map integration.
 *
 * Uses unified state {latitude, longitude} internally.
 * Compatible with legacy code using latitudeColumn/longitudeColumn.
 */
class MapPicker extends XotBaseField
{
    use HasCoordinatePicker;

    protected string $view = 'geo::filament.forms.components.map-picker';

    protected string|\Closure|null $latitudeField = null;

    protected string|\Closure|null $longitudeField = null;

    protected bool|\Closure $reverseGeocoding = true;

    /**
     * Stato per geolocalizzazione automatica quando coordinate assenti (valutabile via {@see evaluate()}).
     * Nome distinto dal metodo fluent {@see self::geolocateWhenEmpty()} per evitare conflitto simbolo PHP.
     */
    protected bool|\Closure $geolocateWhenEmptyState = true;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpCoordinatePicker();
        $this->dehydrated(false);
    }

    public function geolocateWhenEmpty(bool|\Closure $condition = true): static
    {
        $this->geolocateWhenEmptyState = $condition;

        return $this;
    }

    public function getGeolocateWhenEmpty(): bool
    {
        return (bool) $this->evaluate($this->geolocateWhenEmptyState);
    }
}
