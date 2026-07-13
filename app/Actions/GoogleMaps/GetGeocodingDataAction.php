<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\GoogleMaps;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Modules\Geo\Datas\Geocoding\GeocodingData;
<<<<<<< HEAD
=======
use Modules\Xot\Actions\Cast\SafeStringCastAction;
>>>>>>> laraxot/dev

use function Safe\json_decode;

/**
 * Action per ottenere i dati di geocodifica da Google Maps.
 */
readonly class GetGeocodingDataAction
{
    private const API_URL = 'https://maps.googleapis.com/maps/api/geocode/json';

    public function __construct(
        private Client $client,
    ) {
    }

    /**
     * Ottiene i dati di geocodifica per un indirizzo.
     *
     * @throws \RuntimeException Se la richiesta fallisce o la risposta non è valida
     */
    public function execute(string $address): GeocodingData
    {
        $this->validateInput($address);

        try {
            $response = $this->makeApiRequest($address);

            return $this->parseResponse($response);
        } catch (GuzzleException $e) {
            Log::error('Errore nella geocodifica', [
                'error' => $e->getMessage(),
                'address' => $address,
            ]);

            return GeocodingData::error('REQUEST_FAILED');
        }
    }

    /**
     * Valida i dati di input.
     *
     * @throws \RuntimeException Se i dati non sono validi
     */
    private function validateInput(string $address): void
    {
        // $apiKey = config('services.google_maps.api_key');
        $apiKey = config('services.google.maps_api_key');
        if (empty($apiKey)) {
            throw new \RuntimeException('Chiave API Google Maps non configurata!');
        }
        if (empty($address)) {
            throw new \RuntimeException('Indirizzo non può essere vuoto');
        }
        if (strlen($address) > 1000) {
            throw new \RuntimeException('Indirizzo troppo lungo');
        }
    }

    /**
     * @throws GuzzleException
     */
    private function makeApiRequest(string $address): string
    {
        $response = $this->client->get(self::API_URL, [
            'query' => [
                'address' => $address,
                'key' => config('geo.google_maps.api_key'),
                'language' => config('geo.google_maps.language', 'it'),
                'region' => config('geo.google_maps.region', 'IT'),
            ],
        ]);

        return $response->getBody()->getContents();
    }

    /**
     * @throws \RuntimeException Se la risposta non è nel formato atteso
     */
    private function parseResponse(string $response): GeocodingData
    {
<<<<<<< HEAD
        /** @var array{
         *     status: string,
         *     results?: array<array{
         *         geometry: array{
         *             location: array{
         *                 lat: float,
         *                 lng: float
         *             }
         *         },
         *         formatted_address: string,
         *         address_components: array<array{
         *             long_name: string,
         *             short_name: string,
         *             types: array<string>
         *         }>
         *     }>,
         *     error_message?: string
         * } $data */
        $data = json_decode($response, true);

        if ('OK' !== $data['status'] || empty($data['results'])) {
            Log::warning('Geocodifica fallita', [
                'status' => $data['status'],
                'error' => $data['error_message'] ?? 'Nessun risultato trovato',
            ]);

            return GeocodingData::error($data['status']);
        }

        return GeocodingData::fromGoogleResponse([
            'status' => $data['status'],
            'results' => $data['results'],
        ]);
=======
        $decoded = json_decode($response, true);
        if (! \is_array($decoded)) {
            return GeocodingData::error('INVALID_RESPONSE');
        }

        /** @var array<string, mixed> $data */
        $data = $decoded;

        if ('OK' !== ($data['status'] ?? null) || empty($data['results'])) {
            Log::warning('Geocodifica fallita', [
                'status' => $data['status'] ?? null,
                'error' => $data['error_message'] ?? 'Nessun risultato trovato',
            ]);

            return GeocodingData::error(SafeStringCastAction::cast($data['status'] ?? 'UNKNOWN'));
        }

        $typedResponse = $this->normalizeGoogleGeocodingResponse($data);
        if (null === $typedResponse) {
            return GeocodingData::error('INVALID_RESPONSE');
        }

        return GeocodingData::fromGoogleResponse($typedResponse);
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return array{
     *     status: string,
     *     results: list<array{
     *         geometry: array{location: array{lat: float, lng: float}},
     *         formatted_address: string,
     *         address_components: list<array{long_name: string, short_name: string, types: list<string>}>
     *     }>,
     *     error_message?: string
     * }|null
     */
    private function normalizeGoogleGeocodingResponse(array $data): ?array
    {
        $status = $data['status'] ?? null;
        if (! \is_string($status)) {
            return null;
        }

        $results = $data['results'] ?? null;
        if (! \is_array($results) || [] === $results) {
            return null;
        }

        $normalizedResults = [];
        foreach ($results as $result) {
            if (! \is_array($result)) {
                return null;
            }

            $normalizedResult = $this->normalizeGeocodingResult($result);
            if (null === $normalizedResult) {
                return null;
            }

            $normalizedResults[] = $normalizedResult;
        }

        $normalized = [
            'status' => $status,
            'results' => $normalizedResults,
        ];

        if (isset($data['error_message']) && \is_string($data['error_message'])) {
            $normalized['error_message'] = $data['error_message'];
        }

        return $normalized;
    }

    /**
     * @param array<mixed, mixed> $result
     *
     * @return array{
     *     geometry: array{location: array{lat: float, lng: float}},
     *     formatted_address: string,
     *     address_components: list<array{long_name: string, short_name: string, types: list<string>}>
     * }|null
     */
    private function normalizeGeocodingResult(array $result): ?array
    {
        $geometry = $result['geometry'] ?? null;
        if (! \is_array($geometry)) {
            return null;
        }

        $location = $geometry['location'] ?? null;
        if (! \is_array($location) || ! isset($location['lat'], $location['lng'])) {
            return null;
        }

        $formattedAddress = $result['formatted_address'] ?? null;
        if (! \is_string($formattedAddress)) {
            return null;
        }

        $components = $result['address_components'] ?? null;
        if (! \is_array($components)) {
            return null;
        }

        $normalizedComponents = $this->normalizeAddressComponents($components);
        if (null === $normalizedComponents) {
            return null;
        }

        return [
            'geometry' => [
                'location' => [
                    'lat' => (float) $location['lat'],
                    'lng' => (float) $location['lng'],
                ],
            ],
            'formatted_address' => $formattedAddress,
            'address_components' => $normalizedComponents,
        ];
    }

    /**
     * @param array<mixed, mixed> $components
     *
     * @return list<array{long_name: string, short_name: string, types: list<string>}>|null
     */
    private function normalizeAddressComponents(array $components): ?array
    {
        $normalizedComponents = [];
        foreach ($components as $component) {
            if (! \is_array($component)) {
                return null;
            }

            $longName = $component['long_name'] ?? null;
            $shortName = $component['short_name'] ?? null;
            $types = $component['types'] ?? null;

            if (! \is_string($longName) || ! \is_string($shortName) || ! \is_array($types)) {
                return null;
            }

            $normalizedTypes = $this->normalizeAddressComponentTypes($types);
            if (null === $normalizedTypes) {
                return null;
            }

            $normalizedComponents[] = [
                'long_name' => $longName,
                'short_name' => $shortName,
                'types' => $normalizedTypes,
            ];
        }

        return $normalizedComponents;
    }

    /**
     * @param array<mixed, mixed> $types
     *
     * @return list<string>|null
     */
    private function normalizeAddressComponentTypes(array $types): ?array
    {
        $normalizedTypes = [];
        foreach ($types as $type) {
            if (! \is_string($type)) {
                return null;
            }
            $normalizedTypes[] = $type;
        }

        return $normalizedTypes;
>>>>>>> laraxot/dev
    }
}
