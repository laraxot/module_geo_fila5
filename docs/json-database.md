---
title: "json database"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-10-06
qmd: "json database"
issues: []
discussions: []
---

# JSON come Database per Dati Geografici

## Contesto
Il file `resources/json/comuni.json` contiene i dati geografici italiani in formato JSON. Data la sua dimensione ridotta e la natura statica dei dati, è più efficiente utilizzarlo direttamente come fonte dati invece di creare tabelle nel database.

## Vantaggi dell'approccio JSON
1. **Semplicità**
   - Nessuna migrazione del database
   - Nessuna query SQL
   - Dati sempre disponibili

2. **Performance**
   - Caricamento veloce
   - Caching efficiente
   - Nessun overhead di database

3. **Manutenibilità**
   - Aggiornamento semplice del file JSON
   - Versioning dei dati
   - Backup facile

## Implementazione

### 1. Struttura del JSON
```json
{
    "regions": [
        {
            "name": "Lombardia",
            "code": "LO",
            "provinces": [
                {
                    "name": "Milano",
                    "code": "MI",
                    "cities": [
                        {
                            "name": "Milano",
                            "code": "F205",
                            "cap": "20100"
                        }
                    ]
                }
            ]
        }
    ]
}
```

### 2. Servizio di Accesso ai Dati
```php
<?php

declare(strict_types=1);

namespace Modules\Geo\App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class GeoDataService
{
    private const CACHE_KEY = 'geo_data';
    private const CACHE_TTL = 86400; // 24 ore

    private array $data;

    public function __construct()
    {
        $this->data = $this->loadData();
    }

    private function loadData(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            $json = File::get(module_path('Geo', 'resources/json/comuni.json'));
            return json_decode($json, true);
        });
    }

    public function getRegions(): array
    {
        return collect($this->data['regions'])
            ->map(fn ($region) => [
                'id' => $region['code'],
                'name' => $region['name']
            ])
            ->toArray();
    }

    public function getProvinces(string $regionCode): array
    {
        $region = collect($this->data['regions'])
            ->firstWhere('code', $regionCode);

        if (!$region) {
            return [];
        }

        return collect($region['provinces'])
            ->map(fn ($province) => [
                'id' => $province['code'],
                'name' => $province['name']
            ])
            ->toArray();
    }

    public function getCities(string $provinceCode): array
    {
        foreach ($this->data['regions'] as $region) {
            foreach ($region['provinces'] as $province) {
                if ($province['code'] === $provinceCode) {
                    return collect($province['cities'])
                        ->map(fn ($city) => [
                            'id' => $city['code'],
                            'name' => $city['name'],
                            'cap' => $city['cap']
                        ])
                        ->toArray();
                }
            }
        }

        return [];
    }

    public function getCap(string $provinceCode, string $cityCode): ?string
    {
        $cities = $this->getCities($provinceCode);
        
        $city = collect($cities)
            ->firstWhere('id', $cityCode);

        return $city['cap'] ?? null;
    }

    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
```

### 3. Utilizzo in Filament
```php
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Modules\Geo\App\Services\GeoDataService;

class LocationForm
{
    public static function getSchema(): array
    {
        $geoService = app(GeoDataService::class);

        return [
            'location' => Fieldset::make('location')
                ->schema([
                    'region' => Select::make('region')
                        ->options(fn () => $geoService->getRegions())
                        ->searchable()
                        ->required()
                        ->live()
                        ->afterStateUpdated(fn (Set $set) => $set('province', null))
                        ->selectablePlaceholder(false),

                    'province' => Select::make('province')
                        ->options(fn (Get $get) => 
                            $geoService->getProvinces($get('region'))
                        )
                        ->searchable()
                        ->required()
                        ->live()
                        ->afterStateUpdated(fn (Set $set) => $set('city', null))
                        ->visible(fn (Get $get) => filled($get('region')))
                        ->selectablePlaceholder(false),

                    'city' => Select::make('city')
                        ->options(fn (Get $get) => 
                            $geoService->getCities($get('province'))
                        )
                        ->searchable()
                        ->required()
                        ->live()
                        ->afterStateUpdated(fn (Set $set) => $set('cap', null))
                        ->visible(fn (Get $get) => filled($get('province')))
                        ->selectablePlaceholder(false),

                    'cap' => Select::make('cap')
                        ->options(fn (Get $get) => 
                            collect($geoService->getCities($get('province')))
                                ->firstWhere('id', $get('city'))['cap']
                        )
                        ->required()
                        ->visible(fn (Get $get) => filled($get('city')))
                        ->selectablePlaceholder(false),
                ]),
        ];
    }
}
```

## Best Practices

1. **Performance**
   - Cache del file JSON in memoria
   - Caricamento lazy dei dati
   - Ottimizzazione delle query

2. **Manutenzione**
   - Versioning del file JSON
   - Validazione della struttura
   - Backup automatico

3. **Validazione**
   - Schema JSON
   - Integrità dei dati
   - Gestione errori

## Esempio di Validazione
```php
use Illuminate\Support\Facades\Validator;

class GeoDataValidator
{
    public function validate(array $data): bool
    {
        $rules = [
            'regions' => 'required|array',
            'regions.*.name' => 'required|string',
            'regions.*.code' => 'required|string|size:2',
            'regions.*.provinces' => 'required|array',
            'regions.*.provinces.*.name' => 'required|string',
            'regions.*.provinces.*.code' => 'required|string|size:2',
            'regions.*.provinces.*.cities' => 'required|array',
            'regions.*.provinces.*.cities.*.name' => 'required|string',
            'regions.*.provinces.*.cities.*.code' => 'required|string',
            'regions.*.provinces.*.cities.*.cap' => 'required|string|size:5',
        ];

        $validator = Validator::make($data, $rules);

        return !$validator->fails();
    }
}
```

## Note Aggiuntive

1. **Vantaggi rispetto al Database**
   - Nessuna migrazione
   - Nessuna query SQL
   - Dati sempre disponibili
   - Backup semplice
   - Versioning facile

2. **Svantaggi**
   - Dati in memoria
   - Aggiornamento manuale
   - Possibili problemi con file molto grandi

3. **Alternative**
   - Database SQLite
   - File YAML
   - API esterna

## Collegamenti
- [Documentazione Squire](../../geo/project_docs/squire-integration.md)
- [Best Practices Filament](../../../../docs/project/filament-best-practices.md)
- [Clean Code](../../../../docs/project/clean-code.md) 

## Aggiornamento 2026-10-06: configurazione e validazione condivise

Le classi che leggono il JSON (`LoadGeoDataAction`, `Get{Regions,Provinces,Cities,Cap}Action`, `LoadGeoHierarchyAction`,
`GeoDataService`) non duplicano piu' percorso/TTL/chiavi di cache: usano `Modules\Geo\Support\GeoDataConfig`
(`JSON_PATH`, `CACHE_TTL`, `CACHE_KEY_REGIONS|PROVINCES|CITIES|CAP`, i pattern con `%s` si espandono con `sprintf`).
`ClearGeoDataCacheAction` usa la stessa chiave regioni.

Le regole di validazione stanno in un solo posto, `GeoDataValidationRules::RULES` e `::MESSAGES`
(`public const array`), riusate da `GeoDataValidator` e `ValidateGeoDataIntegrityAction`
(lo snippet `GeoDataValidator` qui sopra e' una versione didattica semplificata).

Tipi di ritorno reali (prima documentati in modo errato come lista di `{name, code}`):

| Metodo | Ritorno |
|--------|---------|
| regioni (`getRegions`, `executeRegions`, `GetRegionsAction`) | `Collection<string, string>` mappa codice => nome |
| province | `Collection<int, array{name: string, code: string}>` |
| citta' (`getCities`, `executeCities`, `GetCitiesAction`) | `Collection<string, string>` mappa codice => nome |

Le closure passate a `Cache::remember()` delegano a metodi privati con `@return` preciso: la closure con tipo nativo
`Collection` viene letta da PHPStan come `Collection<int|string, mixed>` e, per l'invarianza della chiave, rifiuta i
ritorni piu' specifici.

> Attenzione (decisione aperta): `resources/json/comuni.json` oggi e' una lista piatta di comuni (usata dai modelli
> Sushi), non l'oggetto `{ "regions": [...] }` che le Actions `GeoData/*` e `GeoDataService` validano. Con il file
> attuale `LoadGeoDataAction` lancia "Il file JSON dei comuni non e' valido". Nessun chiamante fuori dal modulo le usa
> (verificato con grep su `Modules` e `Themes`): decidere se allineare il file/le Actions o dismetterle.

