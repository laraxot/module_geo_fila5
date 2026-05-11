<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components\Traits;

use Filament\Support\Components\Attributes\ExposedLivewireMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Renderless;

/**
 * Trait HasCoordinatePicker - Shared logic for geographic components.
<<<<<<< HEAD
 * Standardized on 'lat' and 'lng' for keys and properties.
 * JSON-first: Saves to a single field as array/JSON by default.
 */
trait HasCoordinatePicker
{
    protected float $centerLat = 41.9028;

    protected float $centerLng = 12.4964;
=======
 * Rule: No "Default" prefixes for configuration methods.
 * Rule: Unified state {latitude, longitude}.
 */
trait HasCoordinatePicker
{
    protected ?string $latitude = null;

    protected ?string $longitude = null;

    protected float $centerLatitude = 41.9028;

    protected float $centerLongitude = 12.4964;
>>>>>>> c3b9b5924 (.)

    protected int $zoom = 13;

    protected string $height = '400px';

    protected bool $hasReverseGeocoding = true;

<<<<<<< HEAD
    protected ?string $latColumn = null;

    protected ?string $lngColumn = null;
=======
    protected string $latitudeColumn = 'latitude';

    protected string $longitudeColumn = 'longitude';
>>>>>>> c3b9b5924 (.)

    protected bool $geolocateWhenEmpty = false;

    protected function setUpCoordinatePicker(): void
    {
<<<<<<< HEAD
        $this->default(['lat' => null, 'lng' => null, 'address' => null]);

        $this->afterStateHydrated(static function (self $component, mixed $state): void {
            if (is_array($state) && isset($state['lat'], $state['lng'])) {
=======
        $this->default(['latitude' => null, 'longitude' => null]);
        // Note: Removed $this->dehydrated(false) to allow location data to be saved.
        // The component now properly persists coordinates to the form state.

        $this->afterStateHydrated(static function (self $component, mixed $state): void {
            if (\is_array($state) && isset($state['latitude'], $state['longitude'])) {
>>>>>>> c3b9b5924 (.)
                return;
            }

            $record = $component->getRecord();
<<<<<<< HEAD
            $fieldName = $component->getName();

            // Case 1: State is already a JSON/Array in the main field
            if ($record instanceof Model && is_array($val = $record->getAttribute($fieldName))) {
                $component->state([
                    'lat' => self::normalizeCoordinate($val['lat'] ?? null),
                    'lng' => self::normalizeCoordinate($val['lng'] ?? null),
                    'address' => $val['address'] ?? null,
=======
            if ($record instanceof Model) {
                $component->state([
                    'latitude' => self::normalizeCoordinate($record->getAttribute($component->getLatitudeColumn())),
                    'longitude' => self::normalizeCoordinate($record->getAttribute($component->getLongitudeColumn())),
>>>>>>> c3b9b5924 (.)
                ]);

                return;
            }

<<<<<<< HEAD
            // Case 2: Mapping from separate columns
            if ($record instanceof Model && $component->getLatColumn() && $component->getLngColumn()) {
                $component->state([
                    'lat' => self::normalizeCoordinate($record->getAttribute($component->getLatColumn())),
                    'lng' => self::normalizeCoordinate($record->getAttribute($component->getLngColumn())),
                    'address' => $record->getAttribute('address'), // Fallback for address if it exists
                ]);

                return;
            }

            $component->state(['lat' => null, 'lng' => null, 'address' => null]);
        });

        $this->dehydrateStateUsing(static function (self $component, $state) {
            return $state;
        });

        $this->saveRelationshipsUsing(static function (self $component, Model $record, $state) {
            if (! is_array($state)) {
                return;
            }

            $latCol = $component->getLatColumn();
            $lngCol = $component->getLngColumn();

            // If separate columns are defined, update them
            if ($latCol && $lngCol) {
                $record->update([
                    $latCol => self::normalizeCoordinate($state['lat'] ?? null),
                    $lngCol => self::normalizeCoordinate($state['lng'] ?? null),
                ]);
            }
        });
    }

    public function latColumn(string $column): static
    {
        $this->latColumn = $column;
=======
            // No coordinates available yet: keep nulls and let the UI decide how to center
            // (e.g. geolocation when enabled, otherwise a JS-level fallback).
            $component->state(['latitude' => null, 'longitude' => null]);
        });
    }

    public function latitudeColumn(string $column): static
    {
        $this->latitudeColumn = $column;
>>>>>>> c3b9b5924 (.)

        return $this;
    }

<<<<<<< HEAD
    public function lngColumn(string $column): static
    {
        $this->lngColumn = $column;
=======
    public function longitudeColumn(string $column): static
    {
        $this->longitudeColumn = $column;
>>>>>>> c3b9b5924 (.)

        return $this;
    }

    public function zoom(int $zoom): static
    {
        $this->zoom = $zoom;

        return $this;
    }

    /**
     * Set the initial map center.
<<<<<<< HEAD
     *
     * @param float|array<string, float> $lat
     */
    public function center(float|array $lat, ?float $lng = null): static
    {
        if (is_array($lat)) {
            $this->centerLat = $lat['lat'] ?? $this->centerLat;
            $this->centerLng = $lat['lng'] ?? $this->centerLng;
=======
     * Supports both center(lat, lng) and center(['lat' => ..., 'lng' => ...]).
     *
     * @param float|array<string, float> $latitude
     */
    public function center(float|array $latitude, ?float $longitude = null): static
    {
        if (\is_array($latitude)) {
            $this->centerLatitude = $latitude['latitude'] ?? $latitude['lat'] ?? $this->centerLatitude;
            $this->centerLongitude = $latitude['longitude'] ?? $latitude['lng'] ?? $this->centerLongitude;
>>>>>>> c3b9b5924 (.)

            return $this;
        }

<<<<<<< HEAD
        $this->centerLat = $lat;
        $this->centerLng = $lng ?? $this->centerLng;
=======
        $this->centerLatitude = $latitude;
        $this->centerLongitude = $longitude ?? $this->centerLongitude;
>>>>>>> c3b9b5924 (.)

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

<<<<<<< HEAD
    public function getLatColumn(): ?string
    {
        return $this->latColumn;
    }

    public function getLngColumn(): ?string
    {
        return $this->lngColumn;
=======
    public function getLatitudeColumn(): string
    {
        return $this->latitudeColumn;
    }

    public function getLongitudeColumn(): string
    {
        return $this->longitudeColumn;
>>>>>>> c3b9b5924 (.)
    }

    public function getZoom(): int
    {
        return $this->zoom;
    }

<<<<<<< HEAD
    public function getCenterLat(): float
    {
        return $this->centerLat;
    }

    public function getCenterLng(): float
    {
        return $this->centerLng;
=======
    public function getCenterLatitude(): float
    {
        return $this->centerLatitude;
    }

    public function getCenterLongitude(): float
    {
        return $this->centerLongitude;
>>>>>>> c3b9b5924 (.)
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

<<<<<<< HEAD
    public function getLat(): ?float
    {
        $state = $this->getState();
        if (! is_array($state)) {
            return null;
        }

        return self::normalizeCoordinate($state['lat'] ?? null);
    }

    public function getLng(): ?float
    {
        $state = $this->getState();
        if (! is_array($state)) {
            return null;
        }

        return self::normalizeCoordinate($state['lng'] ?? null);
=======
    public function getLatitude(): ?float
    {
        $state = $this->getState();
        if (! \is_array($state)) {
            return null;
        }

        return self::normalizeCoordinate($state['latitude'] ?? null);
    }

    public function getLongitude(): ?float
    {
        $state = $this->getState();
        if (! \is_array($state)) {
            return null;
        }

        return self::normalizeCoordinate($state['longitude'] ?? null);
>>>>>>> c3b9b5924 (.)
    }

    /**
     * Searches for addresses matching the query string via Nominatim.
<<<<<<< HEAD
=======
     * Server-side to respect rate-limiting and User-Agent policies.
>>>>>>> c3b9b5924 (.)
     *
     * @return array<int, array<string, mixed>>
     */
    #[ExposedLivewireMethod]
    #[Renderless]
    public function searchAddress(string $query): array
    {
<<<<<<< HEAD
        if (strlen(trim($query)) < 3) {
=======
        if (\strlen(trim($query)) < 3) {
>>>>>>> c3b9b5924 (.)
            return [];
        }

        try {
<<<<<<< HEAD
            $appNameConfig = config('app.name');
            $appUrlConfig = config('app.url');
            $appName = is_string($appNameConfig) && '' !== $appNameConfig ? $appNameConfig : 'Laraxot';
            $appUrl = is_string($appUrlConfig) && '' !== $appUrlConfig ? $appUrlConfig : 'localhost';

            $response = Http::withHeaders([
                'User-Agent' => sprintf('%s/1.0 (%s)', $appName, $appUrl),
=======
            $appName = (string) config('app.name', 'Laraxot');
            $appUrl = (string) config('app.url', 'localhost');
            $response = Http::withHeaders([
                'User-Agent' => \sprintf('%s/1.0 (%s)', $appName, $appUrl),
>>>>>>> c3b9b5924 (.)
            ])
                ->timeout(10)
                ->get('https://nominatim.openstreetmap.org/search', [
                    'q' => $query,
                    'format' => 'json',
                    'addressdetails' => 1,
                    'limit' => 5,
                ]);

            if (! $response->successful()) {
                return [];
            }

            $data = $response->json();
<<<<<<< HEAD
            if (! is_array($data)) {
                return [];
            }

            /** @var array<int, array<string, mixed>> $normalized */
            $normalized = array_values(array_filter(
                $data,
                static fn (mixed $item): bool => is_array($item),
            ));

            return $normalized;
=======

            if (! \is_array($data)) {
                return [];
            }

            /* @var array<int, array<string, mixed>> $data */
            return $data;
>>>>>>> c3b9b5924 (.)
        } catch (\Throwable) {
            return [];
        }
    }

    /**
     * Reverse geocodes coordinates to a structured address.
<<<<<<< HEAD
     *
     * @return array<string, mixed>|null
     */
    #[ExposedLivewireMethod]
    #[Renderless]
    public function reverseGeocode(mixed $lat = null, mixed $lng = null): ?array
    {
        if (is_array($lat)) {
            $lng = $lat['lng'] ?? $lat['lon'] ?? $lat['longitude'] ?? null;
            $lat = $lat['lat'] ?? $lat['latitude'] ?? null;
        }

        if (! is_numeric($lat) || ! is_numeric($lng)) {
            return null;
        }

        $lat = (float) $lat;
        $lng = (float) $lng;

=======
     * Returns a rich array for better form integration.
     */
    #[ExposedLivewireMethod]
    #[Renderless]
    public function reverseGeocode(float $latitude, float $longitude): ?array
    {
>>>>>>> c3b9b5924 (.)
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Laraxot/1.0',
            ])
                ->get('https://nominatim.openstreetmap.org/reverse', [
<<<<<<< HEAD
                    'lat' => $lat,
                    'lon' => $lng,
=======
                    'lat' => $latitude,
                    'lon' => $longitude,
>>>>>>> c3b9b5924 (.)
                    'format' => 'jsonv2',
                    'addressdetails' => 1,
                    'zoom' => 18,
                ]);

            if (! $response->successful()) {
                return null;
            }

            $data = $response->json();
<<<<<<< HEAD
            if (! is_array($data)) {
                return null;
            }

            $addressRaw = $data['address'] ?? [];
            /** @var array<string, mixed> $address */
            $address = [];
            if (is_array($addressRaw)) {
                foreach ($addressRaw as $key => $value) {
                    if (is_string($key)) {
                        $address[$key] = $value;
                    }
                }
            }

            return [
                'address' => is_string($data['display_name'] ?? null) ? $data['display_name'] : '',
=======
            if (! \is_array($data)) {
                return null;
            }

            /** @var array<string, mixed> $address */
            $address = $data['address'] ?? [];
            if (! \is_array($address)) {
                $address = [];
            }

            return [
                'display_name' => \is_string($data['display_name'] ?? null) ? $data['display_name'] : '',
>>>>>>> c3b9b5924 (.)
                'street' => self::firstString($address, ['road', 'pedestrian', 'footway', 'path', 'residential', 'highway']),
                'street_number' => self::firstString($address, ['house_number', 'street_number']),
                'city' => self::firstString($address, ['city', 'town', 'village', 'municipality', 'county']),
                'postcode' => self::firstString($address, ['postcode']),
                'state' => self::firstString($address, ['state', 'region']),
                'province' => self::firstString($address, ['province', 'county']),
                'country' => self::firstString($address, ['country']),
                'country_code' => self::firstString($address, ['country_code']),
                'suburb' => self::firstString($address, ['suburb', 'neighbourhood', 'quarter', 'city_district']),
<<<<<<< HEAD
=======
                'structured' => [
                    'road' => self::firstString($address, ['road', 'pedestrian', 'footway', 'path', 'residential', 'highway']),
                    'house_number' => self::firstString($address, ['house_number', 'street_number']),
                    'city' => self::firstString($address, ['city', 'town', 'village', 'municipality', 'county']),
                    'postcode' => self::firstString($address, ['postcode']),
                    'state' => self::firstString($address, ['state', 'region']),
                    'country' => self::firstString($address, ['country']),
                    'city_district' => self::firstString($address, ['city_district', 'suburb', 'neighbourhood', 'quarter']),
                ],
>>>>>>> c3b9b5924 (.)
                'raw' => $data,
            ];
        } catch (\Throwable) {
            return null;
        }
    }

    /**
     * @param array<string, mixed> $data
     * @param array<int, string>   $keys
     */
    private static function firstString(array $data, array $keys): string
    {
        foreach ($keys as $key) {
            $value = $data[$key] ?? null;
<<<<<<< HEAD
            if (is_string($value) && '' !== trim($value)) {
=======
            if (\is_string($value) && '' !== trim($value)) {
>>>>>>> c3b9b5924 (.)
                return $value;
            }
        }

        return '';
    }

<<<<<<< HEAD
=======
    public static function extractCoordinates(array $data, string $field = 'coordinates', string $latColumn = 'latitude', string $lngColumn = 'longitude'): array
    {
        $coordinates = $data[$field] ?? null;
        if (\is_array($coordinates)) {
            $data[$latColumn] = self::normalizeCoordinate($coordinates['latitude'] ?? null);
            $data[$lngColumn] = self::normalizeCoordinate($coordinates['longitude'] ?? null);
        }

        return $data;
    }

>>>>>>> c3b9b5924 (.)
    private static function normalizeCoordinate(mixed $value): ?float
    {
        if (null === $value || '' === $value) {
            return null;
        }

        return is_numeric($value) ? (float) $value : null;
    }
}
