<?php

declare(strict_types=1);

namespace Modules\Geo\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Modules\Geo\Support\GeoDataConfig;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

use function Safe\json_decode;

/**
 * Servizio per la gestione dei dati geografici.
 *
 * Questo servizio fornisce metodi per accedere e manipolare i dati geografici
 * memorizzati nel file JSON.
 *
 * @see \Modules\Geo\docs\json-database.md
 */
class GeoDataService
{
    /**
     * Validatore dei dati.
     */
    private GeoDataValidator $validator;

    /**
     * Costruttore.
     */
    public function __construct()
    {
        $this->validator = new GeoDataValidator();
    }

    /**
     * Ottiene tutte le regioni come mappa codice => nome.
     *
     * @return Collection<string, string>
     */
    public function getRegions(): Collection
    {
        return Cache::remember(
            GeoDataConfig::CACHE_KEY_REGIONS,
            GeoDataConfig::CACHE_TTL,
            fn (): Collection => $this->loadData()->mapWithKeys(
                static fn (array $region): array => [
                    SafeStringCastAction::cast($region['code'] ?? '') => SafeStringCastAction::cast($region['name'] ?? ''),
                ],
            ),
        );
    }

    /**
     * Ottiene le province di una regione.
     *
     * @param string $regionCode Codice della regione
     *
     * @return Collection<int, array{name: string, code: string}>
     */
    public function getProvinces(string $regionCode): Collection
    {
        $cacheKey = \sprintf(GeoDataConfig::CACHE_KEY_PROVINCES, $regionCode);

        /** @var Collection<int, array{name: string, code: string}> $result */
        $result = Cache::remember($cacheKey, GeoDataConfig::CACHE_TTL, function () use ($regionCode): Collection {
            /** @var array<string, mixed>|null $region */
            $region = $this->loadData()->firstWhere('code', $regionCode);

            if (! $region || ! \is_array($region) || ! isset($region['provinces']) || ! \is_array($region['provinces'])) {
                /** @var Collection<int, array{name: string, code: string}> $empty */
                $empty = new Collection();

                return $empty;
            }

            /** @var array<int, array<string, mixed>> $provinces */
            $provinces = $region['provinces'];

            /** @var Collection<int, array<string, mixed>> $provincesCollection */
            $provincesCollection = new Collection($provinces);

            /** @var Collection<int, array{name: string, code: string}> $provinceResult */
            $provinceResult = $provincesCollection
                ->map(static function (array $province): array {
                    $name = $province['name'] ?? '';
                    $code = $province['code'] ?? '';

                    return [
                        'name' => \is_scalar($name) ? (string) $name : '',
                        'code' => \is_scalar($code) ? (string) $code : '',
                    ];
                })
                ->values();

            return $provinceResult;
        });

        return $result;
    }

    /**
     * Ottiene le città di una provincia come mappa codice => nome.
     *
     * @param string $provinceCode Codice della provincia
     *
     * @return Collection<string, string>
     */
    public function getCities(string $provinceCode): Collection
    {
        return Cache::remember(
            \sprintf(GeoDataConfig::CACHE_KEY_CITIES, $provinceCode),
            GeoDataConfig::CACHE_TTL,
            fn (): Collection => $this->loadCities($provinceCode),
        );
    }

    /**
     * Ottiene il CAP di una città.
     *
     * @param string $provinceCode Codice della provincia
     * @param string $cityCode     Codice della città
     */
    public function getCap(string $provinceCode, string $cityCode): ?string
    {
        $cacheKey = \sprintf(GeoDataConfig::CACHE_KEY_CAP, $provinceCode, $cityCode);

        /** @var string|null $result */
        $result = Cache::remember($cacheKey, GeoDataConfig::CACHE_TTL, function () use ($provinceCode, $cityCode): ?string {
            /** @var array<string, mixed>|null $province */
            $province = $this->loadData()->flatMap(static fn (array $region): array => \is_array($region['provinces'] ?? null)
                ? $region['provinces']
                : [])->firstWhere('code', $provinceCode);

            if (! $province || ! \is_array($province) || ! isset($province['cities']) || ! \is_array($province['cities'])) {
                return null;
            }

            /** @var array<int, array<string, mixed>> $cities */
            $cities = $province['cities'];

            /** @var Collection<int, array<string, mixed>> $cityCollection */
            $cityCollection = new Collection($cities);

            /** @var array<string, mixed>|null $city */
            $city = $cityCollection->firstWhere('code', $cityCode);

            return \is_array($city) && isset($city['cap']) && \is_string($city['cap']) ? $city['cap'] : null;
        });

        return $result;
    }

    /**
     * Pulisce la cache.
     */
    public function clearCache(): void
    {
        Cache::forget(GeoDataConfig::CACHE_KEY_REGIONS);

        // Nota: forgetPattern non esiste in Laravel Cache, usiamo forget per le chiavi specifiche
        // In un'implementazione reale, dovremmo mantenere traccia delle chiavi create
    }

    /**
     * @return Collection<string, string>
     */
    private function loadCities(string $provinceCode): Collection
    {
        /** @var array<string, mixed>|null $province */
        $province = $this->loadData()->flatMap(static fn (array $region): array => \is_array($region['provinces'] ?? null)
            ? $region['provinces']
            : [])->firstWhere('code', $provinceCode);

        if (! $province || ! \is_array($province) || ! isset($province['cities']) || ! \is_array($province['cities'])) {
            return new Collection();
        }

        /** @var array<int, array<string, mixed>> $cities */
        $cities = $province['cities'];

        /** @var Collection<string, string> $cityResult */
        $cityResult = (new Collection($cities))->pluck('name', 'code');

        return $cityResult;
    }

    /**
     * Carica i dati dal file JSON.
     *
     * @throws \RuntimeException Se il file non esiste o non è valido
     *
     * @return Collection<int, array<string, mixed>>
     */
    private function loadData(): Collection
    {
        if (! File::exists(base_path(GeoDataConfig::JSON_PATH))) {
            throw new \RuntimeException('Il file JSON dei comuni non esiste');
        }

        /** @var array<string, mixed> $data */
        $data = json_decode(File::get(base_path(GeoDataConfig::JSON_PATH)), true);

        if (! \is_array($data)) {
            throw new \RuntimeException('Il file JSON dei comuni non è valido');
        }

        if (! $this->validator->checkIntegrity($data)) {
            throw new \RuntimeException('Il file JSON dei comuni non è valido');
        }

        if (! isset($data['regions']) || ! \is_array($data['regions'])) {
            throw new \RuntimeException('Regioni mancanti nel file JSON');
        }

        /** @var array<int, array<string, mixed>> $regions */
        $regions = $data['regions'];

        /** @var Collection<int, array<string, mixed>> $result */
        $result = (new Collection($regions))->values();

        return $result;
    }
}
