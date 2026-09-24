---
title: "Geo Module Documentation"
type: documentation
tags: [module, documentation, geospatial, mapping]
created: 2026-07-14
updated: 2026-09-17
---

# Modulo Geo

## Overview

Il modulo **Geo** gestisce tutte le funzionalità geospaziali della piattaforma Laraxot. Fornisce geocoding, calcolo distanze, map components, integrazione con provider di mappe (Google Maps, OpenStreetMap, etc) e gestione coordinate geografiche.

## Scopo

- Geocoding e reverse geocoding
- Calcolo distanze e route optimization
- Integrazione provider mappe multipli
- Filament form components per input geografici
- Map visualization e Web Components
- Location-based queries e radius filtering

## Funzionalità Principali

- **Geocoding**: Conversione indirizzi ↔ coordinate via Google Maps, OpenStreetMap, Nominatim
- **Distance Calculation**: Calcolo distanze usando formula haversine
- **Map Components**: Filament AddressInput, LatitudeLongitudeInput, LeafletMarkerMapInput
- **Web Components**: Map components via Lit + Leaflet
- **Location Filtering**: Filtra coordinate entro raggio specificato
- **Route Optimization**: Clustering e ottimizzazione percorsi
- **Elevation Data**: Recupero dati elevazione geografica
- **Multiple Providers**: Bing, Google, Here, Mapbox, LocationIQ, OpenCage, OpenStreetMap, Photon

## Struttura del Modulo

```
Modules/Geo/
├── app/
│   ├── Actions/
│   │   ├── GetCoordinatesAction.php
│   │   ├── CalculateDistanceAction.php
│   │   ├── FilterCoordinatesInRadiusAction.php
│   │   ├── OptimizeRouteAction.php
│   │   └── ClusterLocationsAction.php
│   ├── DataTransferObjects/
│   │   └── LocationDTO.php
│   ├── Exceptions/
│   │   └── InvalidLocationException.php
│   └── Filament/
│       ├── Forms/Components/
│       │   ├── AddressInput.php
│       │   ├── LatitudeLongitudeInput.php
│       │   └── LeafletMarkerMapInput.php
│       └── Resources/
├── resources/
│   ├── views/
│   │   └── components/
│   └── js/
│       └── map-components/
├── tests/
├── docs/
│   └── README.md
├── module.json
└── composer.json
```

## Componenti Principali

| Classe | Scopo | Tipo |
|--------|-------|------|
| `GetCoordinatesAction` | Geocoding indirizzo → lat/lng | Action |
| `CalculateDistanceAction` | Distanza tra due punti | Action |
| `FilterCoordinatesInRadiusAction` | Query radius filtering | Action |
| `OptimizeRouteAction` | Route optimization | Action |
| `ClusterLocationsAction` | Clustering geografico | Action |
| `AddressInput` | Filament form field | Form Field |
| `LocationDTO` | Transfer object coordinate | DTO |

## Utilizzo Comune

### Scenario 1: Geocodare un Indirizzo

`GetCoordinatesAction` usa lo Spatie `QueueableAction` trait (metodo di istanza
`execute()`, non statico) e prende l'indirizzo già formattato come stringa:

```php
use Modules\Geo\Actions\GetCoordinatesAction;

$location = app(GetCoordinatesAction::class)->execute('Via Roma 1, Roma, Italia');

// Result: ?LocationData (null se non geocodificabile)
echo $location?->latitude;
echo $location?->longitude;
```

Per il dispatch multi-provider con fallback automatico (preferenza da
`config('geo.driver')`), vedi `GetAddressDataFromFullAddressAction`.

### Scenario 2: Calcolare Distanza

`CalculateDistanceAction::execute()` prende due `LocationData`, non un array
di lat/lng:

```php
use Modules\Geo\Actions\CalculateDistanceAction;
use Modules\Geo\Datas\LocationData;

$distance = app(CalculateDistanceAction::class)->execute(
    LocationData::fromArray(['latitude' => 41.9028, 'longitude' => 12.4964]),
    LocationData::fromArray(['latitude' => 45.4642, 'longitude' => 9.1900]),
);
```

### Scenario 3: Filtrare Coordinate entro Raggio

```php
use Modules\Geo\Actions\FilterCoordinatesInRadiusAction;

$nearby = app(FilterCoordinatesInRadiusAction::class)->execute(
    centerLatitude: 41.9028,
    centerLongitude: 12.4964,
    coordinates: $locations, // array
    radius: 10, // km
);
```

### Scenario 4: Form Input Geografico

```php
use Modules\Geo\Filament\Forms\Components\AddressInput;

$schema = [
    AddressInput::make('address')
        ->label('Indirizzo')
        ->required(),
];
```

## Configuration

### Map Provider Configuration

Configurazione del modulo in `Modules/Geo/config/config.php` (struttura reale,
non un file separato per provider):

```php
return [
    'name' => 'Geo',
    'api_keys' => [
        'google_maps' => Env::get('GOOGLE_MAPS_API_KEY'),
        'bing_maps' => Env::get('BING_MAPS_API_KEY'),
        'mapbox' => Env::get('MAPBOX_API_KEY'),
    ],
    // Provider preferito per GetAddressDataFromFullAddressAction, con
    // fallback automatico sulla catena hardcoded nell'Action stessa.
    'driver' => Env::get('GEO_DRIVER', 'google_maps'),
    'rate_limits' => [
        'google_maps' => ['requests_per_second' => 50, 'burst' => 100],
        // ...
    ],
];
```

## Filament Form Fields

Tutti e tre estendono `Modules\Xot\Filament\Forms\Components\XotBaseField` e vivono
in `app/Filament/Forms/Components/`. Nessuno dei tre espone metodi fluent
custom come `provider()`, `storeCoordinates()`, `showMap()` o `storeAs()` — solo
le opzioni standard ereditate da Filament (`label()`, `required()`, ecc.).

### AddressInput

Campo input con auto-completo indirizzo e geolocalizzazione browser:

```php
AddressInput::make('address')
    ->label('Location')
    ->required()
```

### LatitudeLongitudeInput

Coppia di input lat/lng (un solo nome di campo, non due):

```php
LatitudeLongitudeInput::make('coordinates')
    ->label('Coordinates')
    ->required()
```

### LeafletMarkerMapInput

Map picker con marker interattivo:

```php
LeafletMarkerMapInput::make('map')
    ->label('Seleziona posizione')
```

## Testing

```bash
# Run Geo module tests
./vendor/bin/pest Modules/Geo/tests

# Run specific test
./vendor/bin/pest Modules/Geo/tests/Feature/GeocodingTest.php

# With coverage
./vendor/bin/pest Modules/Geo/tests --coverage
```

## Quality Standards

- **PHPStan**: Level 10 (zero baseline)
- **Test Coverage**: Minimum 80%
- **Code Style**: PSR-12 via Pint

Run locally:
```bash
php -d memory_limit=-1 ./vendor/bin/phpstan analyse --level=max Modules/Geo
./vendor/bin/pest Modules/Geo/tests --coverage
./vendor/bin/pint Modules/Geo
```

## Design Principles

### Domain Ownership

Geo module possiede TUTTE le concern geospaziali:
- Geocoding, coordinate, mappe, timezone
- Form components per input geografici
- Map visualization components
- Non duplicare logica geo in altri moduli

### Component Reuse

- One `AddressInput`, many consumers
- Extend existing Geo components rather than duplicating
- Avoid reimplementing geolocation UX in other modules

### Provider Abstraction

- Interface unica per provider geocoding multipli
- Switch provider via configurazione, non codice
- Graceful fallback se provider non disponibile

## Dipendenze / Moduli Correlati

- [Xot - Framework Base](../../Xot/docs/README.md) — Always dependency
- [User - Authentication](../../User/docs/README.md) — For user locations
- [Tenant - Multi-tenancy](../../Tenant/docs/README.md) — For tenant-scoped geo data
- [Cms - Content](../../Cms/docs/README.md) — For location-based content

## Documenti Correlati

- [English overview](./readme-en.md)
- [Detailed structured index (components/actions/models/enums)](./00-INDEX.md)
- [Product Requirements Document](./prd.md)
- [Geo Models Domain Analysis](./geo-models-domain-analysis.md)
- [Map Component Architecture](./wiki/concepts/map-component-purpose-architecture.md)
- [Geocoding Driver/Provider Consolidation (ADR)](./wiki/decisions/geo-geocoding-driver-consolidation.md)
- [Leaflet/Lit Map Reconstruction](./wiki/concepts/geo-map-lit-reconstruction-guide.md)
- [PHPStan Configuration](../../../phpstan.neon)

## Regole Critiche

1. **Always extend Xot base classes** — Never extend Laravel/Filament directly
2. **Use namespace `Modules\Geo`** — Never `app\Geo`
3. **Strict typing** — `declare(strict_types=1);` in all files
4. **One geocoding entry point** — All geocoding via Actions (`app/Actions/**`, Spatie `QueueableAction`), not direct API calls and not `app/Services` (see `no-services-rule`)
5. **Type-safe LocationDTO** — Use DTO for coordinate transfer
6. **No Log statements** — Let Laravel handle exceptions
7. **Provider agnostic** — Code should work with any provider

## Standard Rules & Workflow

- [[BMAD Method](../../../../docs/wiki/concepts/bmad-method.md)]
- [[Context Engineering](../../../../docs/wiki/concepts/context-engineering.md)]
- [[LLM Wiki Governance](../../../../docs/wiki/concepts/llm-wiki-governance.md)]

---

**Status**: ✅ Production  
**Last Updated**: 2026-07-14  
**Requirements**: PHP 8.3+, Laravel 12  
**PHPStan Level**: 10 (Compliant)
