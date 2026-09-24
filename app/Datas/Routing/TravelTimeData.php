<?php

declare(strict_types=1);

namespace Modules\Geo\Datas\Routing;

use Spatie\LaravelData\Data;

/**
 * Data Transfer Object per i risultati del calcolo del tempo di percorrenza.
 *
 * Questo DTO contiene i dati relativi al tempo di percorrenza tra due punti,
 * inclusi durata, distanza e informazioni sul traffico.
 */
class TravelTimeData extends Data
{
    public function __construct(
        public readonly int $duration_seconds,
        public readonly int $duration_in_traffic_seconds,
        public readonly int $distance_meters,
        public readonly string $formatted_duration,
        public readonly string $formatted_distance,
        public readonly string $status = 'OK',
    ) {
    }

    /**
     * Crea un'istanza di errore.
     */
    public static function error(string $status = 'ERROR'): self
    {
        return new self(
            duration_seconds: 0,
            duration_in_traffic_seconds: 0,
            distance_meters: 0,
            formatted_duration: 'N/D',
            formatted_distance: 'N/D',
            status: $status,
        );
    }

    /**
     * @param array<string, mixed> $response
     */
    public static function fromGoogleResponse(array $response): self
    {
        $element = self::resolveGoogleElement($response);
        if (null === $element) {
            $status = $response['status'] ?? 'INVALID_RESPONSE';
            if ('OK' !== $status) {
                return self::error((string) $status);
            }

            $failed = self::firstResponseElement($response);
            $elementStatus = is_array($failed) ? ($failed['status'] ?? 'INVALID_RESPONSE') : 'INVALID_RESPONSE';

            return self::error((string) $elementStatus);
        }

        /** @var array<string, mixed> $durationSegment */
        $durationSegment = is_array($element['duration'] ?? null) ? $element['duration'] : [];
        /** @var array<string, mixed> $distanceSegment */
        $distanceSegment = is_array($element['distance'] ?? null) ? $element['distance'] : [];
        /** @var array<string, mixed> $durationInTrafficSegment */
        $durationInTrafficSegment = is_array($element['duration_in_traffic'] ?? null)
            ? $element['duration_in_traffic']
            : $durationSegment;

        return new self(
            duration_seconds: self::intValueFromSegment($durationSegment, 'value'),
            duration_in_traffic_seconds: self::intValueFromSegment($durationInTrafficSegment, 'value'),
            distance_meters: self::intValueFromSegment($distanceSegment, 'value'),
            formatted_duration: self::stringValueFromSegment($durationSegment, 'text'),
            formatted_distance: self::stringValueFromSegment($distanceSegment, 'text'),
            status: is_scalar($response['status'] ?? null) ? (string) $response['status'] : 'OK',
        );
    }

    /**
     * @param array<string, mixed> $response
     *
     * @return array<string, mixed>|null
     */
    private static function resolveGoogleElement(array $response): ?array
    {
        if (($response['status'] ?? null) !== 'OK') {
            return null;
        }

        $rows = $response['rows'] ?? [];
        if (! is_array($rows) || ! isset($rows[0]) || ! is_array($rows[0])) {
            return null;
        }

        $elements = $rows[0]['elements'] ?? [];
        if (! is_array($elements) || ! isset($elements[0]) || ! is_array($elements[0])) {
            return null;
        }

        $element = $elements[0];
        if (($element['status'] ?? null) !== 'OK') {
            return null;
        }

        /** @var array<string, mixed> $normalizedElement */
        $normalizedElement = $element;

        return $normalizedElement;
    }

    /**
     * @param array<string, mixed> $response
     *
     * @return array<string, mixed>|null
     */
    private static function firstResponseElement(array $response): ?array
    {
        $rows = $response['rows'] ?? null;
        if (! is_array($rows) || ! isset($rows[0]) || ! is_array($rows[0])) {
            return null;
        }

        $elements = $rows[0]['elements'] ?? null;
        if (! is_array($elements) || ! isset($elements[0]) || ! is_array($elements[0])) {
            return null;
        }

        /** @var array<string, mixed> $first */
        $first = $elements[0];

        return $first;
    }

    /**
     * @param array<string, mixed> $segment
     */
    private static function intValueFromSegment(array $segment, string $key): int
    {
        $value = $segment[$key] ?? 0;

        return is_numeric($value) ? (int) $value : 0;
    }

    /**
     * @param array<string, mixed> $segment
     */
    private static function stringValueFromSegment(array $segment, string $key): string
    {
        $value = $segment[$key] ?? '';

        return is_scalar($value) ? (string) $value : '';
    }
}
