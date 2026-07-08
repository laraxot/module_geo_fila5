<?php

declare(strict_types=1);

namespace Modules\Geo\Services;

class MapService
{
    /**
     * @param array<string, mixed> $filters
     * @return array<int, array<string, mixed>>
     */
    public function getMarkers(array $filters): array
    {
        return [];
    }

    /**
     * @param array<string, mixed> $filters
     * @return array<string, mixed>
     */
    public function getMapStats(array $filters): array
    {
        return [];
    }

    /**
     * @param array<string, mixed> $filters
     */
    public function exportData(array $filters, string $format = 'json'): string
    {
        return '';
    }
}
