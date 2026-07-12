<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\GeoData;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Modules\Geo\Actions\GeoData\LoadGeoDataAction;
use Spatie\QueueableAction\QueueableAction;

/**
 * Ottiene tutte le regioni italiane (cache 24h).
 */
class GetRegionsAction
{
    use QueueableAction;

    public const CACHE_KEY = 'geo.regions';

    public const CACHE_TTL = 86400;

    public function __construct(
        private readonly LoadGeoDataAction $loader = new LoadGeoDataAction(),
    ) {
    }

    /**
     * @return Collection<int, array{name: string, code: string}>
     */
    public function execute(): Collection
    {
        /** @var Collection<int, array{name: string, code: string}> $result */
        $result = Cache::remember(
            self::CACHE_KEY,
            self::CACHE_TTL,
            fn (): Collection => $this->loader->execute()->pluck('name', 'code'),
        );

        return $result;
    }
}
