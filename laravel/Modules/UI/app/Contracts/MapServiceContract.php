<?php

declare(strict_types=1);

namespace Modules\UI\Contracts;

/**
 * Contratto mappa interattiva UI — implementazione locale o bridge verso modulo Geo opzionale.
 */
interface MapServiceContract
{
    /**
     * @param array<string, mixed> $filters
     *
     * @return list<array<string, mixed>>
     */
    public function getMarkers(array<string, mixed> $filters): array;

    /**
     * @param array<string, mixed> $filters
     *
     * @return array<string, mixed>
     */
    public function getMapStats(array<string, mixed> $filters): array;

    /**
     * @param array<string, mixed> $filters
     */
    public function exportData(array<string, mixed> $filters, string $format): string;
}
