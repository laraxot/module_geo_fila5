<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components\Traits;

use Filament\Support\Components\Attributes\Exposed;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Renderless;
use Modules\Geo\Filament\Forms\Components\CoordinatePickerHelpers;

/**
 * Trait HasCoordinatePicker - Shared logic for geographic components.
 * Rule: No "Default" prefixes for configuration methods.
 * Rule: Unified state {latitude, longitude}.
 */
trait HasCoordinatePicker
{
    protected ?string $latitude = null;

    protected ?string $longitude = null;

    protected ?float $centerLatitude = null;

    protected ?float $centerLongitude = null;

    protected int $zoom = 13;

    protected string $height = '400px';

    protected bool $hasReverseGeocoding = true;

    protected string $latitudeColumn = 'latitude';

    protected string $longitudeColumn = 'longitude';

    protected bool $geolocateWhenEmpty = false;

    /** Mostra il pannello ricerca indirizzi sul componente Lit (MapPicker / GeopointPicker / …). */
    protected bool $searchVisible = true;

    protected function setUpCoordinatePicker(): void
    {
        $this->default(['latitude' => null, 'longitude' => null]);
        // Note: Removed $this->dehydrated(false) to allow location data to be saved.
        // The component now properly persists coordinates to the form state.

        $this->afterStateHydrated(static function (self $component, mixed $state): void {
            if (\is_array($state) && isset($state['latitude'], $state['longitude'])) {
                return;
            }

            $record = $component->getRecord();
            if ($record instanceof Model) {
                $component->state([
                    'latitude' => CoordinatePickerHelpers::normalizeCoordinate($record->getAttribute($component->getLatitudeColumn())),
                    'longitude' => CoordinatePickerHelpers::normalizeCoordinate($record->getAttribute($component->getLongitudeColumn())),
                ]);

                return;
            }

            // No coordinates available yet: keep nulls and let the UI decide how to center
            // (e.g. geolocation when enabled, otherwise a JS-level fallback).
            $component->state(['latitude' => null, 'longitude' => null]);
        });
    }

    public function latitudeColumn(string $column): static
    {
        $this->latitudeColumn = $column;

        return $this;
    }

    public function longitudeColumn(string $column): static
    {
        $this->longitudeColumn = $column;

        return $this;
    }

    public function zoom(int $zoom): static
    {
        $this->zoom = $zoom;

        return $this;
    }

    /**
     * Set the initial map center.
     * Supports both center(lat, lng) and center(['lat' => ..., 'lng' => ...]).
     *
     * @param  float|array<string, float>  $latitude
     */
    public function center(float|array $latitude, ?float $longitude = null): static
    {
        if (\is_array($latitude)) {
            $this->centerLatitude = $latitude['latitude'] ?? $latitude['lat'] ?? $this->centerLatitude;
            $this->centerLongitude = $latitude['longitude'] ?? $latitude['lng'] ?? $this->centerLongitude;

            return $this;
        }

        $this->centerLatitude = $latitude;
        $this->centerLongitude = $longitude ?? $this->centerLongitude;

        return $this;
    }

    public function reverseGeocoding(bool $condition = true): static
    {
        $this->hasReverseGeocoding = $condition;

        return $this;
    }

    public function height(string $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function geolocateWhenEmpty(bool $condition = true): static
    {
        $this->geolocateWhenEmpty = $condition;

        return $this;
    }

    public function showSearch(bool $visible = true): static
    {
        $this->searchVisible = $visible;

        return $this;
    }

    public function isSearchVisible(): bool
    {
        return $this->searchVisible;
    }

    public function getLatitudeColumn(): string
    {
        return $this->latitudeColumn;
    }

    public function getLongitudeColumn(): string
    {
        return $this->longitudeColumn;
    }

    public function getZoom(): int
    {
        return $this->zoom;
    }

    /** Centro esplicito del campo (`center()`): se manca la mappa si centra sull'utente o sulla vista di partenza (`getMapDefaultView()`). */
    public function getCenterLatitude(): ?float
    {
        return $this->centerLatitude;
    }

    public function getCenterLongitude(): ?float
    {
        return $this->centerLongitude;
    }

    /**
     * Vista di partenza della mappa quando non c'e' un punto: territorio dell'ente (`geo.config.map.default_view`), mai il mondo.
     * Un valore non valido (env sbagliata, config in cache vecchia) ricade sulla panoramica d'Italia: la pagina non si rompe.
     * Il nome evita `getDefaultView()`, che in Filament e' la vista Blade del componente.
     *
     * @return array{lat: float, lng: float, zoom: int}
     */
    public function getMapDefaultView(): array
    {
        $view = config('geo.config.map.default_view');
        $lat = \is_array($view) ? CoordinatePickerHelpers::normalizeCoordinate($view['lat'] ?? null) : null;
        $lng = \is_array($view) ? CoordinatePickerHelpers::normalizeCoordinate($view['lng'] ?? null) : null;
        $rawZoom = \is_array($view) ? ($view['zoom'] ?? null) : null;
        $zoom = is_numeric($rawZoom) ? (float) $rawZoom : null;

        if ($lat === null || $lng === null || $zoom === null
            || abs($lat) > 90 || abs($lng) > 180 || $zoom !== floor($zoom) || $zoom < 1 || $zoom > 19) {
            return ['lat' => 42.5, 'lng' => 12.5, 'zoom' => 6];
        }

        return ['lat' => $lat, 'lng' => $lng, 'zoom' => (int) $zoom];
    }

    public function hasReverseGeocoding(): bool
    {
        return $this->hasReverseGeocoding;
    }

    public function getHeight(): string
    {
        return $this->height;
    }

    public function getGeolocateWhenEmpty(): bool
    {
        return $this->geolocateWhenEmpty;
    }

    public function getLatitude(): ?float
    {
        $state = $this->getState();
        if (! \is_array($state)) {
            return null;
        }

        return CoordinatePickerHelpers::normalizeCoordinate($state['latitude'] ?? null);
    }

    public function getLongitude(): ?float
    {
        $state = $this->getState();
        if (! \is_array($state)) {
            return null;
        }

        return CoordinatePickerHelpers::normalizeCoordinate($state['longitude'] ?? null);
    }

    /**
     * Cerca indirizzi tramite Nominatim lato server (rate limit e User-Agent rispettati).
     * Logica unica in {@see CoordinatePickerHelpers::searchAddress()}, condivisa con XotBaseCoordinateField.
     *
     * @return list<array<string, mixed>>
     */
    #[Exposed]
    #[Renderless]
    public function searchAddress(string $query): array
    {
        return CoordinatePickerHelpers::searchAddress($query);
    }

    /**
     * Geocodifica inversa delle coordinate in un indirizzo strutturato.
     *
     * @return array<string, mixed>|null
     */
    #[Exposed]
    #[Renderless]
    public function reverseGeocode(float $latitude, float $longitude): ?array
    {
        return CoordinatePickerHelpers::reverseGeocode($latitude, $longitude);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function extractCoordinates(array $data, string $field = 'coordinates', string $latColumn = 'latitude', string $lngColumn = 'longitude'): array
    {
        return CoordinatePickerHelpers::extractCoordinates($data, $field, $latColumn, $lngColumn);
    }
}
