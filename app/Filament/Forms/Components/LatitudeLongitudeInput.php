<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;

/**
 * Latitude/Longitude coordinate input with validation and map display.
 *
 * Provides two text fields for coordinates with optional map widget:
 * - Range validation (-90 to 90 for lat, -180 to 180 for lng)
 * - Interactive map with draggable marker
 * - Current location button
 * - Real-time coordinate updates
 *
 * Owned by Geo module because coordinates are a cross-cutting geo-spatial concern.
 */
class LatitudeLongitudeInput extends Field
{
    protected string $view = 'geo::filament.forms.components.latitude-longitude-input';

    protected float $defaultLatitude = 41.9028;

    protected float $defaultLongitude = 12.4964;

    protected int $defaultZoom = 13;

    protected string $height = '340px';

    protected bool $showMap = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('geo::coordinates.fields.latitude.label'));
        $this->schema([
            Grid::make(2)
                ->schema([
                    TextInput::make('latitude')
                        ->label(__('geo::coordinates.fields.latitude.label'))
                        ->numeric()
                        ->minValue(-90)
                        ->maxValue(90)
                        ->step(0.00001)
                        ->placeholder(__('geo::coordinates.fields.latitude.placeholder'))
                        ->required(),
                    TextInput::make('longitude')
                        ->label(__('geo::coordinates.fields.longitude.label'))
                        ->numeric()
                        ->minValue(-180)
                        ->maxValue(180)
                        ->step(0.00001)
                        ->placeholder(__('geo::coordinates.fields.longitude.placeholder'))
                        ->required(),
                ]),
        ]);
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

    public function showMap(bool $show = true): static
    {
        $this->showMap = $show;

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

    public function isMapShown(): bool
    {
        return $this->showMap;
    }
}
