<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Elevation;

use Modules\Geo\Actions\GoogleMaps\FetchGoogleMapsElevationAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Exceptions\ElevationException;
use Spatie\QueueableAction\QueueableAction;

/**
 * Ottiene l'elevazione di un punto geografico tramite Google Maps Elevation API.
 *
 * @see https://developers.google.com/maps/documentation/elevation
 */
class GetElevationAction
{
    use QueueableAction;

    /**
     * @throws ElevationException
     * @throws \InvalidArgumentException
     */
    public function execute(LocationData $location): float
    {
        $this->validateCoordinates($location);

        try {
            /** @var array<string, mixed> $response */
            $response = app(FetchGoogleMapsElevationAction::class)->execute(
                $location->latitude,
                $location->longitude,
            );

            if (! isset($response['results']) || ! is_array($response['results']) || [] === $response['results']) {
                throw ElevationException::invalidResponse();
            }

            $firstResult = $response['results'][0] ?? null;
            if (! is_array($firstResult) || ! isset($firstResult['elevation'])) {
                throw ElevationException::invalidResponse();
            }

            return (float) $firstResult['elevation'];
        } catch (\Throwable $e) {
            if ($e instanceof ElevationException) {
                throw $e;
            }

            throw ElevationException::serviceError('Errore nel recupero dell\'elevazione: '.$e->getMessage(), $e);
        }
    }

    public function formatElevation(float $meters): string
    {
        return sprintf('%.1f m s.l.m.', $meters);
    }

    /**
     * @throws \InvalidArgumentException
     */
    private function validateCoordinates(LocationData $location): void
    {
        if ($location->latitude < -90 || $location->latitude > 90) {
            throw new \InvalidArgumentException(sprintf('Latitudine non valida: %f', $location->latitude));
        }

        if ($location->longitude < -180 || $location->longitude > 180) {
            throw new \InvalidArgumentException(sprintf('Longitudine non valida: %f', $location->longitude));
        }
    }
}
