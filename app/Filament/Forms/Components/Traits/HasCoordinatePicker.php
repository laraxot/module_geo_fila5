<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components\Traits;

use Filament\Support\Components\Attributes\ExposedLivewireMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Renderless;

/**
 * Trait HasCoordinatePicker - Shared logic for geographic components.
 * Rule: No "Default" prefixes.
 * Rule: Unified state {latitude, longitude}.
 */
trait HasCoordinatePicker
{
    protected float $latitude = 41.9028;

    protected float $longitude = 12.4964;

    protected int $zoom = 13;

    protected string $height = '400px';

    protected bool $hasReverseGeocoding = true;

    protected bool $searchVisible = true;

    protected string $latitudeColumn = 'latitude';

    protected string $longitudeColumn = 'longitude';

    protected function setUpCoordinatePicker(): void
    {
        $this->default(['latitude' => null, 'longitude' => null]);

        $this->dehydrated(false);

        $this->afterStateHydrated(function (self $component, mixed $state): void {
            if (is_array($state) && isset($state['latitude'], $state['longitude'])) {
                return;
            }

            $record = $component->getRecord();
            if ($record instanceof Model) {
                $component->state([
                    'latitude' => self::normalizeCoordinate($record->getAttribute($this->latitudeColumn)),
                    'longitude' => self::normalizeCoordinate($record->getAttribute($this->longitudeColumn)),
                ]);

                return;
            }

            $component->state([
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ]);
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

    public function center(float $latitude, float $longitude): static
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;

        return $this;
    }

    public function defaultCenter(float $latitude, float $longitude): static
    {
        return $this->center($latitude, $longitude);
    }

    public function defaultLocation(float $latitude, float $longitude): static
    {
        return $this->center($latitude, $longitude);
    }

    public function defaultZoom(int $zoom): static
    {
        return $this->zoom($zoom);
    }

    public function mapHeight(string $height): static
    {
        return $this->height($height);
    }

    public function reverseGeocoding(bool $condition = true): static
    {
        $this->hasReverseGeocoding = $condition;

        return $this;
    }

    public function showSearch(bool $condition = true): static
    {
        $this->searchVisible = $condition;

        return $this;
    }

    public function height(string $height): static
    {
        $this->height = $height;

        return $this;
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

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function hasReverseGeocoding(): bool
    {
        return $this->hasReverseGeocoding;
    }

    public function isSearchVisible(): bool
    {
        return $this->searchVisible;
    }

    public function getHeight(): string
    {
        return $this->height;
    }

    #[ExposedLivewireMethod]
    #[Renderless]
    public function reverseGeocode(float $latitude, float $longitude): ?string
    {
        try {
            $response = Http::withHeaders(['User-Agent' => 'FixCity Geo CoordinatePicker/1.0'])
                ->timeout(3)
                ->get('https://nominatim.openstreetmap.org/reverse', [
                    'lat' => $latitude,
                    'lon' => $longitude,
                    'format' => 'json',
                ]);

            if (! $response instanceof Response || ! $response->successful()) {
                return null;
            }

            $data = $response->json() ?? [];
            if (! is_array($data)) {
                return null;
            }

            $displayName = $data['display_name'] ?? null;

            return is_string($displayName) && $displayName !== '' ? $displayName : null;
        } catch (\Throwable) {
            return null;
        }
    }

    /** Forward geocoding */
    #[ExposedLivewireMethod]
    #[Renderless]
    public function geocodeAddress(string $address): array
    {
        try {
            $response = Http::withHeaders(['User-Agent' => 'FixCity/1.0'])
                ->get('https://nominatim.openstreetmap.org/search', [
                    'q' => $address,
                    'format' => 'json',
                    'limit' => 1,
                ]);

            $data = $response->json() ?? [];

            if (empty($data) || ! isset($data[0]['lat'], $data[0]['lon'])) {
                return ['latitude' => $this->latitude, 'longitude' => $this->longitude, 'display_name' => 'Not found'];
            }

            return [
                'latitude' => (float) $data[0]['lat'],
                'longitude' => (float) $data[0]['lon'],
                'display_name' => (string) $data[0]['display_name'],
            ];
        } catch (\Throwable) {
            return ['latitude' => $this->latitude, 'longitude' => $this->longitude, 'display_name' => 'Error'];
        }
    }

    private static function normalizeCoordinate(mixed $value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        return is_numeric($value) ? (float) $value : null;
    }
}
