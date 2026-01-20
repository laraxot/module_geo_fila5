<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Bing;

use Illuminate\Support\Facades\Http;
use Modules\Geo\Datas\AddressData;
use Modules\Geo\Datas\BingMapData;
use Modules\Geo\Exceptions\InvalidLocationException;

/**
 * Classe per ottenere l'indirizzo da Bing Maps.
 */
class GetAddressFromBingMapsAction
{
    private const BASE_URL = 'http://dev.virtualearth.net/REST/v1/Locations';

    /**
     * Ottiene l'indirizzo da coordinate geografiche.
     *
     * @throws InvalidLocationException Se la richiesta fallisce o i dati non sono validi
     */
    public function execute(float $latitude, float $longitude): AddressData
    {
        $apiKey = $this->getApiKey();
        $response = $this->makeApiRequest($latitude, $longitude, $apiKey);
        $data = $this->parseResponse($response);

        return $this->mapResponseToAddressData($data);
    }

    /**
     * Get the Bing Maps API key from configuration.
     *
     * @throws InvalidLocationException
     *
     * @return non-empty-string
     */
    private function getApiKey(): string
    {
        /** @var string|null $apiKey */
        $apiKey = config('services.bing.maps_api_key');

        if (empty($apiKey)) {
            throw InvalidLocationException::invalidData('API key di Bing Maps non configurata');
        }

        // We've already checked that $apiKey is not empty
        /* @var non-empty-string $apiKey */
        return $apiKey;
    }

    /**
     * Make an API request to Bing Maps.
     *
     * @param non-empty-string $apiKey
     *
     * @throws InvalidLocationException
     *
     * @return array<string, mixed>
     */
    private function makeApiRequest(float $latitude, float $longitude, string $apiKey): array
    {
        $response = Http::get(self::BASE_URL, [
            'point' => "{$latitude},{$longitude}",
            'key' => $apiKey,
            'includeEntityTypes' => 'Address',
            'maxResults' => 1,
        ]);

        if (! $response->successful()) {
            throw InvalidLocationException::invalidData('Richiesta a Bing Maps fallita');
        }

        /** @var array<string, mixed> $jsonResponse */
        $jsonResponse = $response->json();

        return $jsonResponse;
    }

    private function parseResponse(array $response): BingMapData
    {
        $resourceSets = $response['resourceSets'] ?? [];
        if (! \is_array($resourceSets) || empty($resourceSets) || ! \is_array($resourceSets[0] ?? null)) {
            throw InvalidLocationException::invalidData('Nessun risultato trovato');
        }

        $resources = $resourceSets[0]['resources'] ?? [];
        if (! \is_array($resources) || empty($resources)) {
            throw InvalidLocationException::invalidData('Nessun risultato trovato');
        }

        $location = $resources[0] ?? null;
        if (! \is_array($location) || empty($location)) {
            throw InvalidLocationException::invalidData('Nessun risultato trovato');
        }

        // Validate structure
        if (! isset($location['point']) || ! \is_array($location['point'])) {
            throw InvalidLocationException::invalidData('Point mancante nella risposta');
        }
        if (! isset($location['point']['coordinates']) || ! \is_array($location['point']['coordinates'])) {
            throw InvalidLocationException::invalidData('Coordinate mancanti nella risposta');
        }
        if (! isset($location['address']) || ! \is_array($location['address'])) {
            throw InvalidLocationException::invalidData('Indirizzo mancante nella risposta');
        }

        $point = $location['point'];
        $coordinates = $point['coordinates'];
        if (! isset($coordinates[0], $coordinates[1])) {
            throw InvalidLocationException::invalidData('Coordinate non valide');
        }

        /** @var array{point: array{coordinates: array{0: float, 1: float}}, address: array{countryRegion: string|null, adminDistrict: string|null, adminDistrict2: string|null, locality: string|null, postalCode: string|null, addressLine: string|null, countryRegionIso2: string|null, neighborhood: string|null}} $validatedLocation */
        $validatedLocation = [
            'point' => [
                'coordinates' => [
                    0 => (float) $coordinates[0],
                    1 => (float) $coordinates[1],
                ],
            ],
            'address' => [
                'countryRegion' => isset($location['address']['countryRegion']) && \is_string($location['address']['countryRegion']) ? $location['address']['countryRegion'] : null,
                'adminDistrict' => isset($location['address']['adminDistrict']) && \is_string($location['address']['adminDistrict']) ? $location['address']['adminDistrict'] : null,
                'adminDistrict2' => isset($location['address']['adminDistrict2']) && \is_string($location['address']['adminDistrict2']) ? $location['address']['adminDistrict2'] : null,
                'locality' => isset($location['address']['locality']) && \is_string($location['address']['locality']) ? $location['address']['locality'] : null,
                'postalCode' => isset($location['address']['postalCode']) && \is_string($location['address']['postalCode']) ? $location['address']['postalCode'] : null,
                'addressLine' => isset($location['address']['addressLine']) && \is_string($location['address']['addressLine']) ? $location['address']['addressLine'] : null,
                'countryRegionIso2' => isset($location['address']['countryRegionIso2']) && \is_string($location['address']['countryRegionIso2']) ? $location['address']['countryRegionIso2'] : null,
                'neighborhood' => isset($location['address']['neighborhood']) && \is_string($location['address']['neighborhood']) ? $location['address']['neighborhood'] : null,
            ],
        ];

        return new BingMapData($validatedLocation);
    }

    private function mapResponseToAddressData(BingMapData $data): AddressData
    {
        $res = $data->toArray();

        return new AddressData(
            latitude: (float) ($res['point']['coordinates'][0] ?? 0),
            longitude: (float) ($res['point']['coordinates'][1] ?? 0),
            country: $res['address']['countryRegion'] ?? null,
            city: $res['address']['locality'] ?? null,
            country_code: strtoupper($res['address']['countryRegionIso2'] ?? 'IT'),
            postal_code: (int) ($res['address']['postalCode'] ?? 0),
            locality: $res['address']['locality'] ?? null,
            county: $res['address']['adminDistrict2'] ?? null,
            street: $res['address']['addressLine'] ?? null,
            street_number: $res['address']['houseNumber'] ?? null,
            district: $res['address']['neighborhood'] ?? null,
            state: $res['address']['adminDistrict'] ?? null,
        );
    }
}
