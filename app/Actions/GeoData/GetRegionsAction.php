<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\GeoData;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Spatie\QueueableAction\QueueableAction;

/**
 * Ottiene tutte le regioni italiane (cache 24h).
 */
class GetRegionsAction
{
    use QueueableAction;

    public const string CACHE_KEY = 'geo.regions';

    public const int CACHE_TTL = 86400;

    /** @return Collection<string, string> keyed by region code */
    public function execute(): Collection
    {
        /** @var array<string, string> $result */
        $result = Cache::remember(
            self::CACHE_KEY,
            self::CACHE_TTL,
            static fn (): array => app(LoadGeoDataAction::class)->execute()
                ->mapWithKeys(static function (array $region): array {
                    $name = $region['name'] ?? null;
                    $code = $region['code'] ?? null;

                    if (! is_string($name) || ! is_string($code)) {
                        throw new \UnexpectedValueException('Geo regions must contain string name and code.');
                    }

                    return [$code => $name];
                })
                ->all(),
        );

        return new Collection($result);
    }
}
