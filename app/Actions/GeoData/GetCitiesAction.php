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
     * @return Collection<string, string> keyed by city code
     */
    public function execute(string $provinceCode): Collection
    {
        $cacheKey = \sprintf(self::CACHE_KEY, $provinceCode);

        /** @var array<string, string> $result */
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

            return (new Collection($cities))
                ->mapWithKeys(static function (array $city): array {
                    $name = $city['name'] ?? null;
                    $code = $city['code'] ?? null;

                    if (! is_string($name) || ! is_string($code)) {
                        throw new \UnexpectedValueException('Geo cities must contain string name and code.');
                    }

                    return [$code => $name];
                })
                ->all();
        });

        return new Collection($result);
    }
}
