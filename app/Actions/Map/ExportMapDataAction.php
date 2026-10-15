<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Map;

use Spatie\QueueableAction\QueueableAction;

/**
 * Export dati mappa (stub).
 *
 * Sostituisce MapService::exportData().
 *
 * @phpstan-type MapFilters array{category?: string, categories?: list<string>, search?: string|null, bounds?: array{minLat: float, minLng: float, maxLat: float, maxLng: float}, limit?: int, offset?: int}
 */
final class ExportMapDataAction
{
    use QueueableAction;

    public const string FORMAT_JSON = 'json';
    public const string FORMAT_CSV = 'csv';
    public const string FORMAT_GEOJSON = 'geojson';
    public const string FORMAT_KML = 'kml';

    /**
     * @param MapFilters $filters
     */
    public function execute(array $filters = [], string $format = self::FORMAT_JSON): string
    {
        return match ($format) {
            self::FORMAT_CSV => '',
            self::FORMAT_GEOJSON => '{"type":"FeatureCollection","features":[]}',
            self::FORMAT_KML => '<?xml version="1.0" encoding="UTF-8"?><kml xmlns="http://www.opengis.net/kml/2.2"></kml>',
            default => '[]',
        };
    }
}
