<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\GeoData;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Spatie\QueueableAction\QueueableAction;

/**
 * Ottiene le città di una provincia (cache 24h).
 */
class GetCitiesAction
{
    use QueueableAction;

    public const string CACHE_KEY = 'geo.cities.%s';

    public const int CACHE_TTL = 86400;

    /**
     * @param string $provinceCode Codice della provincia
     *
     * @return Collection<int|string, mixed>
     */
    public function execute(string $provinceCode): Collection
    {
        $cacheKey = \sprintf(self::CACHE_KEY, $provinceCode);

        $result = Cache::remember($cacheKey, self::CACHE_TTL, function () use ($provinceCode): array {
            /** @var array<string, mixed>|null $province */
            $province = app(LoadGeoDataAction::class)->execute()->flatMap(static fn (array $region): array => \is_array($region['provinces'] ?? null)
                ? $region['provinces']
                : [])->firstWhere('code', $provinceCode);

            if (! $province || ! \is_array($province) || ! isset($province['cities']) || ! \is_array($province['cities'])) {
                return [];
            }

            /** @var array<int, array<string, mixed>> $cities */
            $cities = $province['cities'];

            return (new Collection($cities))->pluck('name', 'code')->all();
        });

        return new Collection($result);
    }
}
