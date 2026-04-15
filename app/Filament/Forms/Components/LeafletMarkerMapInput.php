<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Filament\Forms\Components\Field;

/**
 * Mappa Leaflet con marker trascinabile: aggiorna due campi sibling (latitudine / longitudine).
 *
 * **Perché in Geo (filosofia / confini di dominio)**:
 * tile OSM, WGS84 e UX mappa sono responsabilità del modulo geografico; i moduli dominio (Fixcity, ecc.)
 * importano il componente senza duplicare Leaflet.
 *
 * **Stato Filament**: il campo della mappa è `dehydrated(false)`; la persistenza avviene sui campi
 * `latitude` / `longitude` (o nomi configurati) nello stesso scope dello schema.
 *
 * @see resources/views/filament/forms/components/leaflet-marker-map-input.blade.php
 */
class LeafletMarkerMapInput extends Field
{
    protected string $view = 'geo::filament.forms.components.leaflet-marker-map-input';

    protected float $defaultLatitude = 41.9028;

    protected float $defaultLongitude = 12.4964;

    protected int $defaultZoom = 13;

    protected string $height = '340px';

    protected string $latitudeField = 'latitude';

    protected string $longitudeField = 'longitude';

    protected function setUp(): void
    {
        parent::setUp();

        $this->dehydrated(false);
    }

    public function defaultCenter(float $latitude, float $longitude): static
    {
        $this->defaultLatitude = $latitude;
        $this->defaultLongitude = $longitude;

        return $this;
    }

    public function defaultZoom(int $zoom): static
    {
        $this->defaultZoom = $zoom;

        return $this;
    }

    public function mapHeight(string $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function bindLatitudeField(string $name): static
    {
        $this->latitudeField = $name;

        return $this;
    }

    public function bindLongitudeField(string $name): static
    {
        $this->longitudeField = $name;

        return $this;
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

    public function getMapHeight(): string
    {
        return $this->height;
    }

    public function getLatitudeField(): string
    {
        return $this->latitudeField;
    }

    public function getLongitudeField(): string
    {
        return $this->longitudeField;
    }
}
