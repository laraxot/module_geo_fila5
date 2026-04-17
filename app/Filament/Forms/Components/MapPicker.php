<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Modules\Xot\Filament\Forms\Components\XotBaseField;

/**
 * MapPicker custom field for Filament v5.
 *
 * This component manages an interactive map using a Lit Web Component and Leaflet.
 * It integrates with Livewire and Alpine.js to update latitude and longitude columns.
 *
 * Features:
 * - Marker draggable with real-time updates.
 * - Auto-geolocation if coordinates are null.
 * - Fullscreen toggle and layer switch (Street/Satellite).
 * - Reverse geocoding (Nominatim/Photon).
 */
class MapPicker extends XotBaseField
{
    protected string $view = 'geo::filament.forms.components.map-picker';

    protected string $latitudeField = 'latitude';

    protected string $longitudeField = 'longitude';

    protected float $defaultLatitude = 41.9028;

    protected float $defaultLongitude = 12.4964;

    protected int $defaultZoom = 13;

    protected string $height = '400px';

    protected bool $isAutocompleteVisible = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dehydrated(false);
    }

    public function latitude(string $field): static
    {
        $this->latitudeField = $field;

        return $this;
    }

    public function longitude(string $field): static
    {
        $this->longitudeField = $field;

        return $this;
    }

    public function defaultLocation(float $latitude, float $longitude): static
    {
        $this->defaultLatitude = $latitude;
        $this->defaultLongitude = $longitude;

        return $this;
    }

    public function zoom(int $zoom): static
    {
        $this->defaultZoom = $zoom;

        return $this;
    }

    public function height(string $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function autocompleteVisible(bool $visible = true): static
    {
        $this->isAutocompleteVisible = $visible;

        return $this;
    }

    public function getLatitudeField(): string
    {
        return $this->latitudeField;
    }

    public function getLongitudeField(): string
    {
        return $this->longitudeField;
    }

    public function getDefaultLatitude(): float
    {
        return $this->defaultLatitude;
    }

    public function getDefaultLongitude(): float
    {
        return $this->defaultLongitude;
    }

    public function getDefaultZoom(): int
    {
        return $this->defaultZoom;
    }

    public function getHeight(): string
    {
        return $this->height;
    }

    public function isAutocompleteVisible(): bool
    {
        return $this->isAutocompleteVisible;
    }
}
