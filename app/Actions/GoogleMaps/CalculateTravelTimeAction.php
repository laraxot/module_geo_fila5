<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\GoogleMaps;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Datas\Routing\TravelTimeData;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

use function Safe\json_decode;

use Webmozart\Assert\Assert;

/**
 * Action per calcolare il tempo di percorrenza tra due punti tramite Google Maps.
 *
 * Questa classe utilizza l'API Google Maps Distance Matrix per calcolare
 * il tempo di percorrenza tra due località, considerando il traffico attuale.
 */
readonly class CalculateTravelTimeAction
{
    private const API_URL = 'https://maps.googleapis.com/maps/api/distancematrix/json';

    public function __construct(
        private Client $client,
    ) {
    }

    /**
     * Calcola il tempo di percorrenza tra due punti.
     *
     * @throws \RuntimeException Se la chiave API non è configurata o la richiesta fallisce
     */
    public function execute(LocationData $origin, LocationData $destination): TravelTimeData
    {
        $this->validateInput($origin, $destination);

        try {
            $response = $this->makeApiRequest($origin, $destination);

            return $this->parseResponse($response);
        } catch (GuzzleException $e) {
            Log::error('Google Maps Distance Matrix API request failed', [
                'error' => $e->getMessage(),
                'origin' => $origin,
                'destination' => $destination,
            ]);

            return TravelTimeData::error('REQUEST_FAILED');
        }
    }

    /**
     * Valida i dati di input.
     *
     * @throws \RuntimeException Se la chiave API non è configurata o i dati non sono validi
     */
    private function validateInput(LocationData $origin, LocationData $destination): void
    {
        $apiKey = config('services.google.maps_api_key');
        Assert::notEmpty($apiKey, 'Google Maps API key not configured');
        Assert::notSame(
            [$origin->latitude, $origin->longitude],
            [$destination->latitude, $destination->longitude],
            'Origin and destination cannot be the same location',
        );
    }

    /**
     * Effettua la richiesta all'API di Google Maps.
     *
     * @throws GuzzleException Se la richiesta fallisce
     */
    private function makeApiRequest(LocationData $origin, LocationData $destination): string
    {
        $response = $this->client->get(self::API_URL, [
            'query' => [
                'origins' => sprintf('%F,%F', $origin->latitude, $origin->longitude),
                'destinations' => sprintf('%F,%F', $destination->latitude, $destination->longitude),
                'mode' => 'driving',
                'departure_time' => 'now',
                'traffic_model' => 'best_guess',
                'key' => config('services.google.maps_api_key'),
            ],
        ]);

        return $response->getBody()->getContents();
    }

    /**
     * Elabora la risposta dell'API.
     *
     * @throws \RuntimeException Se la risposta non è valida
     */
    private function parseResponse(string $response): TravelTimeData
    {
        $decoded = json_decode($response, true);
        if (! \is_array($decoded)) {
            return TravelTimeData::error('INVALID_RESPONSE');
        }

        /** @var array<string, mixed> $data */
        $data = $decoded;

        $status = SafeStringCastAction::cast($data['status'] ?? 'INVALID_RESPONSE');
        if ('OK' !== $status) {
            return TravelTimeData::error($status);
        }

        $rows = $data['rows'] ?? null;
        if (! \is_array($rows) || ! isset($rows[0]) || ! \is_array($rows[0])) {
            return TravelTimeData::error('NO_ROUTE');
        }

        $elements = $rows[0]['elements'] ?? null;
        if (! \is_array($elements) || ! isset($elements[0]) || ! \is_array($elements[0])) {
            return TravelTimeData::error('NO_ROUTE');
        }

        /** @var array<string, mixed> $element */
        $element = $elements[0];

        $elementStatus = SafeStringCastAction::cast($element['status'] ?? 'NO_ROUTE');
        if ('OK' !== $elementStatus) {
            return TravelTimeData::error($elementStatus);
        }

        $duration = $element['duration'] ?? null;
        $durationInTraffic = $element['duration_in_traffic'] ?? null;
        $distance = $element['distance'] ?? null;

        $durationValue = \is_array($duration) ? (int) ($duration['value'] ?? 0) : 0;
        $durationInTrafficValue = \is_array($durationInTraffic)
            ? (int) ($durationInTraffic['value'] ?? $durationValue)
            : $durationValue;
        $distanceValue = \is_array($distance) ? (int) ($distance['value'] ?? 0) : 0;
        $durationText = \is_array($duration) ? SafeStringCastAction::cast($duration['text'] ?? '') : '';
        $distanceText = \is_array($distance) ? SafeStringCastAction::cast($distance['text'] ?? '') : '';

        return new TravelTimeData(
            duration_seconds: $durationValue,
            duration_in_traffic_seconds: $durationInTrafficValue,
            distance_meters: $distanceValue,
            formatted_duration: $durationText,
            formatted_distance: $distanceText,
            status: $status,
        );
    }
}
