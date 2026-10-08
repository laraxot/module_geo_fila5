<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\GeoData;

use Illuminate\Support\Collection;
use Spatie\QueueableAction\QueueableAction;

/**
 * Carica e espone gerarchia regioni/province/città da JSON comuni.
 *
 * Sostituisce GeoDataService.
 */
final class LoadGeoHierarchyAction
{
    use QueueableAction;

    /** @return Collection<string, string> keyed by region code */
    public function executeRegions(): Collection
    {
        return app(GetRegionsAction::class)->execute();
    }

    /**
     * @return Collection<int, array{name: string, code: string}>
     */
    public function executeProvinces(string $regionCode): Collection
    {
        return app(GetProvincesAction::class)->execute($regionCode);
    }

    /** @return Collection<string, string> keyed by city code */
    public function executeCities(string $provinceCode): Collection
    {
        return app(GetCitiesAction::class)->execute($provinceCode);
    }

    public function executeCap(string $provinceCode, string $cityCode): ?string
    {
        return app(GetCapAction::class)->execute($provinceCode, $cityCode);
    }

    public function executeClearCache(): void
    {
        app(ClearGeoDataCacheAction::class)->execute();
    }

}
