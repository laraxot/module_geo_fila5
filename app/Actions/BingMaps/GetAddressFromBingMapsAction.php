<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\BingMaps;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Modules\Geo\Datas\Geocoding\AddressData;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

use function Safe\json_decode;

use Webmozart\Assert\Assert;

/**
 * Action per ottenere l'indirizzo da coordinate tramite Bing Maps.
 *
 * Questa classe utilizza l'API Bing Maps Geocoding per convertire
 * un indirizzo in coordinate geografiche e dettagli dell'indirizzo.
 */
readonly class GetAddressFromBingMapsAction
{
    private const API_URL = 'http://dev.virtualearth.net/REST/v1/Locations';

    public function __construct(
        private Client $client,
    ) {
    }

    /**
     * Ottiene i dettagli dell'indirizzo utilizzando Bing Maps.
     *
     * @throws \RuntimeException Se la chiave API non è configurata o la richiesta fallisce
     */
    public function execute(string $address): ?AddressData
    {
        $this->validateInput($address);

        try {
            $response = $this->makeApiRequest($address);

            return $this->parseResponse($response);
        } catch (GuzzleException $e) {
            Log::error('Bing Maps Geocoding API request failed', [
                'error' => $e->getMessage(),
                'address' => $address,
            ]);

            return null;
        }
    }

    /**
     * Valida i dati di input.
     *
     * @throws \RuntimeException Se la chiave API non è configurata
     */
    private function validateInput(string $address): void
    {
        $apiKey = config('services.bing.maps_api_key');
        if (empty($apiKey)) {
            throw new \RuntimeException('Bing Maps API key not configured');
        }
        if (empty($address)) {
            throw new \RuntimeException('Address cannot be empty');
        }
        if (strlen($address) > 1000) {
            throw new \RuntimeException('Address is too long');
        }
    }

    /**
     * Effettua la richiesta all'API di Bing Maps.
     *
     * @throws GuzzleException Se la richiesta fallisce
     */
    private function makeApiRequest(string $address): string
    {
        $response = $this->client->get(self::API_URL, [
            'query' => [
                'query' => $address,
                'key' => config('services.bing.maps_api_key'),
                'maxResults' => 1,
            ],
        ]);

        return $response->getBody()->getContents();
    }

    /**
     * Elabora la risposta dell'API.
     *
     * @throws \RuntimeException Se la risposta non è valida
     */
    private function parseResponse(string $response): ?AddressData
    {
        $decoded = json_decode($response, true);
        if (! \is_array($decoded)) {
            return null;
        }

        /** @var array<string, mixed> $data */
        $data = $decoded;

        if (200 !== ($data['statusCode'] ?? null)) {
            return null;
        }

        $resourceSets = $data['resourceSets'] ?? null;
        if (! \is_array($resourceSets) || ! isset($resourceSets[0]) || ! \is_array($resourceSets[0])) {
            return null;
        }

        $resources = $resourceSets[0]['resources'] ?? null;
        if (! \is_array($resources) || ! isset($resources[0]) || ! \is_array($resources[0])) {
            return null;
        }

        /** @var array<string, mixed> $resource */
        $resource = $resources[0];

        $point = $resource['point'] ?? null;
        if (! \is_array($point)) {
            return null;
        }

        $coordinates = $point['coordinates'] ?? null;
        if (! \is_array($coordinates)) {
            return null;
        }

        $address = $resource['address'] ?? null;
        if (! \is_array($address)) {
            return null;
        }

        Assert::isArray($address);

        return AddressData::from([
            'latitude' => (float) ($coordinates[0] ?? 0),
            'longitude' => (float) ($coordinates[1] ?? 0),
            'country' => SafeStringCastAction::cast($address['countryRegion'] ?? 'Italia'),
            'city' => SafeStringCastAction::cast($address['locality'] ?? ''),
            'postal_code' => (int) SafeStringCastAction::cast($address['postalCode'] ?? 0),
            'street' => SafeStringCastAction::cast($address['addressLine'] ?? ''),
            'street_number' => '',
            'province' => SafeStringCastAction::cast($address['adminDistrict'] ?? ''),
        ]);
    }
}
