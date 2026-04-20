<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Filament\Support\Components\Attributes\ExposedLivewireMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Renderless;
use Modules\Xot\Filament\Forms\Components\XotBaseField;

/**
 * GeopointPicker — Filament v5 custom field per selezione di un punto geografico.
 *
 * Architettura:
 * - State form: { latitude: float|null, longitude: float|null } (oggetto unificato)
 * - DB: due colonne DECIMAL separate, configurabili via latitudeColumn()/longitudeColumn()
 * - UI: Lit Web Component <geopoint-picker-lit> (Shadow DOM, Leaflet, drag/click/fullscreen)
 * - Bridge: Alpine thin layer — $wire.set/$wire.watch, nessun @entangle
 * - Geocoding: server-side Nominatim via ExposedLivewireMethod #[Renderless]
 *
 * @see https://filamentphp.com/docs/5.x/forms/custom-fields
 */
class GeopointPicker extends XotBaseField
{
    protected string $view = 'geo::filament.forms.components.geopoint-picker';

    protected float $defaultLatitude = 41.9028;

    protected float $defaultLongitude = 12.4964;

    protected int $zoom = 13;

    protected string $height = '400px';

    protected bool $showSearch = true;

    protected string $latitudeColumn = 'latitude';

    protected string $longitudeColumn = 'longitude';

    protected function setUp(): void
    {
        parent::setUp();

        $this->default(['latitude' => null, 'longitude' => null]);
        $this->dehydrated(true);

        $this->afterStateHydrated(function (mixed $state): void {
            if (is_array($state) && array_key_exists('latitude', $state)) {
                return;
            }

            $record = $this->getRecord();
            if ($record instanceof Model) {
                $this->state([
                    'latitude'  => $record->getAttribute($this->latitudeColumn),
                    'longitude' => $record->getAttribute($this->longitudeColumn),
                ]);
            }
        });

        $this->dehydrateStateUsing(function (mixed $state): array {
            $loc = is_array($state) ? $state : [];

            return [
                $this->latitudeColumn  => isset($loc['latitude'])  ? (float) $loc['latitude']  : null,
                $this->longitudeColumn => isset($loc['longitude']) ? (float) $loc['longitude'] : null,
            ];
        });
    }

    // -------------------------------------------------------------------------
    // Fluent setters — colonne DB
    // -------------------------------------------------------------------------

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

    // -------------------------------------------------------------------------
    // Fluent setters — presentazione
    // -------------------------------------------------------------------------

    public function defaultLocation(float $latitude, float $longitude): static
    {
        $this->defaultLatitude  = $latitude;
        $this->defaultLongitude = $longitude;

        return $this;
    }

    public function zoom(int $zoom): static
    {
        $this->zoom = $zoom;

        return $this;
    }

    public function height(string $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function showSearch(bool $condition = true): static
    {
        $this->showSearch = $condition;

        return $this;
    }

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------

    public function getDefaultLatitude(): float
    {
        return $this->defaultLatitude;
    }

    public function getDefaultLongitude(): float
    {
        return $this->defaultLongitude;
    }

    public function getZoom(): int
    {
        return $this->zoom;
    }

    public function getHeight(): string
    {
        return $this->height;
    }

    public function isSearchVisible(): bool
    {
        return $this->showSearch;
    }

    public function getLatitudeColumn(): string
    {
        return $this->latitudeColumn;
    }

    public function getLongitudeColumn(): string
    {
        return $this->longitudeColumn;
    }

    // -------------------------------------------------------------------------
    // ExposedLivewireMethods — geocoding server-side
    // -------------------------------------------------------------------------

    /**
     * Geocoding forward: indirizzo → coordinate (Nominatim).
     *
     * @return array{latitude: float, longitude: float, display_name: string}
     */
    #[ExposedLivewireMethod]
    #[Renderless]
    public function geocodeAddress(string $address): array
    {
        try {
            $response = Http::withHeaders(['User-Agent' => 'Laraxot/1.0'])
                ->get('https://nominatim.openstreetmap.org/search', [
                    'q'      => $address,
                    'format' => 'json',
                    'limit'  => 1,
                ]);

            /** @var array<int,array{lat?:string,lon?:string,display_name?:string}> $data */
            $data = $response->json() ?? [];

            if (empty($data) || ! isset($data[0]['lat'], $data[0]['lon'])) {
                return $this->defaultLocationResult('Location not found');
            }

            return [
                'latitude'     => (float) $data[0]['lat'],
                'longitude'    => (float) $data[0]['lon'],
                'display_name' => (string) ($data[0]['display_name'] ?? 'Found location'),
            ];
        } catch (\Exception $e) {
            return $this->defaultLocationResult('Error: '.$e->getMessage());
        }
    }

    /**
     * Geocoding inverso: coordinate → indirizzo leggibile (Nominatim).
     *
     * @return array{display_name: string}
     */
    #[ExposedLivewireMethod]
    #[Renderless]
    public function reverseGeocode(float $lat, float $lng): array
    {
        try {
            $response = Http::withHeaders(['User-Agent' => 'Laraxot/1.0'])
                ->get('https://nominatim.openstreetmap.org/reverse', [
                    'lat'    => $lat,
                    'lon'    => $lng,
                    'format' => 'json',
                ]);

            /** @var array{display_name?:string} $data */
            $data = $response->json() ?? [];

            return ['display_name' => (string) ($data['display_name'] ?? '')];
        } catch (\Exception) {
            return ['display_name' => ''];
        }
    }

    // -------------------------------------------------------------------------
    // Helpers privati
    // -------------------------------------------------------------------------

    /** @return array{latitude: float, longitude: float, display_name: string} */
    private function defaultLocationResult(string $message): array
    {
        return [
            'latitude'     => $this->defaultLatitude,
            'longitude'    => $this->defaultLongitude,
            'display_name' => $message,
        ];
    }
}
