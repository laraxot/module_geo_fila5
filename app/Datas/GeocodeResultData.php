<?php

declare(strict_types=1);

namespace Modules\Geo\Datas;

use Spatie\LaravelData\Data;

/**
 * Value Object holding canonical results from a Geocoding service lookup.
 */
class GeocodeResultData extends Data
{
    public function __construct(
        public float $latitude,
        public float $longitude,
        public string $formattedAddress,
        public ?string $countryCode = null,
        /** @var array<string, mixed> */
<<<<<<< .merge_file_gnHy3Q
        public array $components = [], // e.g., ['city' => 'New York', 'state' => 'NY']
    ) {
    }
=======
        public array $components = [] // e.g., ['city' => 'New York', 'state' => 'NY']
    ) {}
>>>>>>> .merge_file_D6lfSw
}
