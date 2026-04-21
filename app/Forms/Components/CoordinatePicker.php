<?php

namespace Modules\Geo\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use Filament\Forms\Concerns\InteractsWithWire;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use InvalidArgumentException;

class CoordinatePicker extends Field
{
    use InteractsWithWire;

    public ?string $latitudeColumn = 'latitude';
    public ?string $longitudeColumn = 'longitude';
    public int $zoom = 13;
    public bool $showFullscreenButton = true;
    public bool $showLocateButton = true;
    public bool $enableReverseGeocoding = false;

    protected string $view = 'geo::filament.forms.components.coordinate-picker';

    public function latitudeColumn(?string $column = null): static
    {
        $this->latitudeColumn = $column;
        return $this;
    }

    public function longitudeColumn(?string $column = null): static
    {
        $this->longitudeColumn = $column;
        return $this;
    }

    public function zoom(int $zoom): static
    {
        $this->zoom = $zoom;
        return $this;
    }

    public function showFullscreenButton(bool $show = true): static
    {
        $this->showFullscreenButton = $show;
        return $this;
    }

    public function showLocateButton(bool $show = true): static
    {
        $this->showLocateButton = $show;
        return $this;
    }

    public function enableReverseGeocoding(bool $enable = true): static
    {
        $this->enableReverseGeocoding = $enable;
        return $this;
    }

    public function hasReverseGeocoding(): bool
    {
        return $this->enableReverseGeocoding;
    }

    public function getStatePath(): string
    {
        return $this->getName() . '.coordinates';
    }

    public function getState(): array
    {
        return [
            'latitude' => $this->getAttribute('latitude'),
            'longitude' => $this->getAttribute('longitude'),
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->makeRules([
            'latitude' => ['nullable', 'float', 'min:-90', 'max:90'],
            'longitude' => ['nullable', 'float', 'min:-180', 'max:180'],
        ]);
    }

    protected function mutateState(array $input): void
    {
        $this->setAttribute('latitude', $input['latitude'] ?? null);
        $this->setAttribute('longitude', $input['longitude'] ?? null);
    }

    /** Livewire callback, called from JavaScript */
    #[On('coords-changed')]
    public function handleCoordsChanged(array $coords): void
    {
        $this->setAttribute('latitude', $coords['latitude'] ?? null);
        $this->setAttribute('longitude', $coords['longitude'] ?? null);
    }

    /** Exposed for reverse geocoding */
    #[On('reverse-geocode')]
    public function reverseGeocode(float $latitude, float $longitude): ?string
    {
        // Simple Nominatim reverse geocode – fallback to null on error
        $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat={$latitude}&lon={$longitude}&accept-language=it";
        $response = @file_get_contents($url);
        $data = $response ? json_decode($response, true) : null;
        return $data['display_name'] ?? null;
    }

    public static function extractCoordinates(array $data, string $fieldName = 'coordinates', string $latitudeColumn = 'latitude', string $longitudeColumn = 'longitude'): array
    {
        if (!is_array($data) || !isset($data[$fieldName])) {
            return [$latitudeColumn => null, $longitudeColumn => null];
        }

        $coordinates = $data[$fieldName];
        $lat = data_get($coordinates, 'latitude');
        $lng = data_get($coordinates, 'longitude');

        // cast to float for safety
        $lat = is_numeric($lat) ? (float) $lat : null;
        $lng = is_numeric($lng) ? (float) $lng : null;

        return [$latitudeColumn => $lat, $longitudeColumn => $lng];
    }