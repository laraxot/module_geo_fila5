<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components\Contracts;

use Modules\Geo\Filament\Forms\Components\Traits\HasCoordinatePicker;

/**
 * PHPDoc degli array shape del picker: PHPStan L10 perde i tipi iterable
 * sui metodi del trait {@see HasCoordinatePicker}
 * quando li analizza «in context of class». L'interfaccia li ridichiara sul consumatore.
 *
 * @see ../../../../docs/coordinate-picker-purpose.md
 * @see ../../../../docs/geo-sync-marker-repair.md
 */
interface CoordinatePickerArrayShapes
{
    /**
     * @param  float|array{latitude?: float|int|string, lat?: float|int|string, longitude?: float|int|string, lng?: float|int|string}  $latitude
     */
    public function center(float|array $latitude, ?float $longitude = null): static;

    /**
     * @return array{lat: float, lng: float, zoom: int}
     */
    public function getMapDefaultView(): array;

    /**
     * @return list<array<string, mixed>>
     */
    public function searchAddress(string $query): array;

    /**
     * @return array<string, mixed>|null
     */
    public function reverseGeocode(float $latitude, float $longitude): ?array;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function extractCoordinates(array $data, string $field = 'coordinates', string $latColumn = 'latitude', string $lngColumn = 'longitude'): array;
}
