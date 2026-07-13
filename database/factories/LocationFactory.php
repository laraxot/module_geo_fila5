<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Geo\Models\Location;
<<<<<<< HEAD
use Modules\Xot\Actions\Cast\SafeStringCastAction;
=======
>>>>>>> laraxot/dev

/**
 * Location Factory.
 *
 * Factory for creating Location model instances for testing and seeding.
 *
 * @extends Factory<Location>
 */
class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Location>
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $italianCities = [
            'Roma',
            'Milano',
            'Napoli',
            'Torino',
            'Palermo',
            'Genova',
            'Bologna',
            'Firenze',
            'Bari',
            'Catania',
            'Venezia',
            'Verona',
        ];

        $italianStreets = [
            'Via Roma',
            'Via Milano',
            'Via Garibaldi',
            'Via Mazzini',
            'Via Dante',
            'Via Verdi',
            'Corso Italia',
            'Piazza Duomo',
        ];

        $italianRegions = [
            'Lazio',
            'Lombardia',
            'Campania',
            'Piemonte',
            'Sicilia',
            'Liguria',
            'Emilia-Romagna',
            'Toscana',
        ];

<<<<<<< HEAD
        $city = SafeStringCastAction::cast($this->faker->randomElement($italianCities));
        $street = SafeStringCastAction::cast($this->faker->randomElement($italianStreets));
        $state = SafeStringCastAction::cast($this->faker->randomElement($italianRegions));
=======
        /** @var string $city */
        $city = (string) $this->faker->randomElement($italianCities);
        /** @var string $street */
        $street = (string) $this->faker->randomElement($italianStreets);
        /** @var string $state */
        $state = (string) $this->faker->randomElement($italianRegions);
>>>>>>> laraxot/dev

        return [
            'name' => $this->faker->optional()->words(2, true) ?? null,
            'lat' => $this->faker->latitude(35.0, 47.0), // Italy bounds
            'lng' => $this->faker->longitude(6.0, 19.0),
<<<<<<< HEAD
            'street' => $street.' '.SafeStringCastAction::cast($this->faker->numberBetween(1, 999)),
            'city' => $city,
            'state' => $state,
            'zip' => SafeStringCastAction::cast($this->faker->regexify('[0-9]{5}')), // Italian ZIP code
=======
            'street' => $street.' '.((string) $this->faker->numberBetween(1, 999)),
            'city' => $city,
            'state' => $state,
            'zip' => (string) $this->faker->regexify('[0-9]{5}'), // Italian ZIP code
>>>>>>> laraxot/dev
            'formatted_address' => sprintf('%s, %s, %s, Italia', $street, $city, $state),
            'description' => $this->faker->optional()->sentence() ?? null,
            'processed' => $this->faker->boolean(80), // 80% processed
        ];
    }

    /**
     * Create an unprocessed location.
     */
    public function unprocessed(): static
    {
        return $this->state(fn (array $_attributes): array => [
            'processed' => false,
        ]);
    }

    /**
     * Create a processed location.
     */
    public function processed(): static
    {
        return $this->state(fn (array $_attributes): array => [
            'processed' => true,
        ]);
    }

    /**
     * Create location in specific city.
     */
    public function inCity(string $city, ?string $state = null): static
    {
        return $this->state(fn (array $attributes): array => [
            'city' => $city,
<<<<<<< HEAD
            'state' => $state ?? SafeStringCastAction::cast($attributes['state'] ?? 'Lazio'),
            'formatted_address' => sprintf(
                '%s, %s, %s, Italia',
                SafeStringCastAction::cast($attributes['street'] ?? 'Via Roma 1'),
                $city,
                $state ?? SafeStringCastAction::cast($attributes['state'] ?? 'Lazio'),
=======
            'state' => $state ?? ((string) ($attributes['state'] ?? 'Lazio')),
            'formatted_address' => sprintf(
                '%s, %s, %s, Italia',
                (string) ($attributes['street'] ?? 'Via Roma 1'),
                $city,
                $state ?? ((string) ($attributes['state'] ?? 'Lazio')),
>>>>>>> laraxot/dev
            ),
        ]);
    }

    /**
     * Create location with specific coordinates.
     */
    public function withCoordinates(float $latitude, float $longitude): static
    {
        return $this->state(fn (array $_attributes): array => [
            'lat' => $latitude,
            'lng' => $longitude,
        ]);
    }

    /**
     * Create location in Rome.
     */
    public function inRome(): static
    {
        return $this->inCity('Roma', 'Lazio')->withCoordinates(41.9028, 12.4964);
    }

    /**
     * Create location in Milan.
     */
    public function inMilan(): static
    {
        return $this->inCity('Milano', 'Lombardia')->withCoordinates(45.4642, 9.1900);
    }
}
