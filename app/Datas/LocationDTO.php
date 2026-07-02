<?php

declare(strict_types=1);

namespace Modules\Geo\Datas;

/**
 * @deprecated Use \Modules\Geo\Datas\LocationData instead (Spatie Data pattern).
 *             This plain DTO duplicates LocationData which has the same coordinates
 *             plus Spatie's from()/toArray() for free.
 */
readonly class LocationDTO
{
    public function __construct(
        public float $latitude,
        public float $longitude,
        public ?string $address = null,
        public ?string $city = null,
        public ?string $country = null,
    ) {
    }

    /**
     * @return array<string, float|string|null>
     */
    public function toArray(): array
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
        ];
    }
}
