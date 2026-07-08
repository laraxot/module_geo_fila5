<?php

declare(strict_types=1);

namespace Modules\Geo\Services;

class GeocodingService
{
    /**
     * @return array{address: string, latitude: float, longitude: float}
     */
    public function geocodeAddress(string $address): array
    {
        return [
            'address' => $address,
            'latitude' => 0.0,
            'longitude' => 0.0,
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getSuggestions(string $query): array
    {
        return [];
    }
}
