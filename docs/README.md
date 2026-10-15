---
qmd: "README"
issues: []
discussions: []
title: "Geo Module Documentation"
type: documentation
tags: [module, documentation, geospatial, mapping]
created: 2026-07-14
updated: 2026-10-15
status: draft
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

## Identita, superficie HTTP e quick start (verificato nel codice il 2026-10-14)

- **Identita**: modulo nwidart `Geo` (alias `geo`, namespace `Modules\Geo`, package `laraxot/module_geo_fila5`, repo git separato). Provider da `module.json`: `Providers/GeoServiceProvider` e `Providers/Filament/AdminPanelProvider`. `php artisan module:list` lo mostra `Enabled`.
- **Ownership**: tutto cio' che e' geospaziale (geocoding, distanze, gerarchia comuni/province/regioni, modelli `Address`/`Location`/`Place`, picker e mappe Lit/Leaflet). Consumatore nel codice vivo: `Fixcity` (`TicketForm` e `TicketResource` usano `Modules\Geo\Filament\Forms\Components\CoordinatePicker`); misurato con `grep` dei riferimenti `Modules\Geo` nelle `app/` degli altri moduli: 4 file in Fixcity e 1 file `.old` in UI (`InteractiveMap.php.old`, non caricato).
- **Superficie HTTP**: `routes/web.php` e `routes/api.php` contengono solo commenti e non esiste `resources/views/pages` (nessuna pagina Folio, nessuna API del modulo). Il pannello Filament risponde su `/geo/admin` (dashboard, `addresses`, `locations`, pagine `lat-lng`, `location-map`, `location-map-table`, `o-s-m-map`, `dotswan-map`, `webbingbrasil-map`, `setting-page`) da `php artisan route:list`.
- **Quick start** (da `laravel/`): `php artisan module:list`; `./vendor/bin/phpstan analyse Modules/Geo` (0 errori); `node --test Modules/Geo/tests/js/default-view.test.mjs` (3 passati); build JS con `cd Modules/Geo && npm run build` (`vite.config.js` scrive in `public_html/assets/geo`; non eseguito qui). Per i test PHP vedi Testing, con il limite noto.
- **Limiti noti**: la radice di `docs/` ha 622 file (vedi [DOCS-MIGRATION-MAP.md](./docs-migration-map.md), proposta senza spostamenti); `app/` contiene 19 file di scarto (`.wip`, `.disabled*`, `.fila3`, `.maybe_profile`, `.old`, `.backup-*`, `.bak*`) e copie duplicate di Actions (due `GetAddressFromBingMapsAction`, due `CalculateGeoDistanceAction`, due `IsPointInPolygonAction`, due `OptimizeRouteAction`); le chiavi di config `geo.driver`, `geo.api_keys`, `geo.cache` lette dal codice non esistono a runtime (vedi Configuration); i test PHP non girano per `Themes/Meetup`.

## Struttura del Modulo

```
Modules/Geo/
├── app/
│   ├── Actions/            (77 file .php; sottocartelle per provider: Bing, BingMaps, GoogleMaps, Here,
│   │                        LocationIQ, Mapbox, Nominatim, OpenCage, OpenStreetMap, Photon, IPGeolocation,
│   │                        TimeZone, Weather, Elevation, Distance, Math, Polygon, GeoData, Map, Maps)
│   ├── Models/             (13 modelli: Address, Comune, ComuneJson, County, GeoJsonModel, GeoNamesCap,
│   │                        Locality, Location, Place, PlaceType, Province, Region, State; 13 policy)
│   ├── Datas/              (46 file, spatie/laravel-data: LocationData, AddressData, ...)
│   ├── Adapters/           (GoogleMapsClient, HereClient, GeoHttpClientBase)
│   ├── Contracts/, Enums/ (AddressItemEnum, AddressTypeEnum), Exceptions/, Support/ (GeoApiEndpoints, GeoDataConfig)
│   ├── View/Components/    (PointMap = <x-geo::point-map>)
│   ├── Console/Commands/   (SushiCommand: sushi:manage refresh|clear|status)
│   └── Filament/
│       ├── Forms/Components/ (AddressInput, AddressSection, CoordinatePicker, LatitudeLongitudeInput,
│       │                      LeafletMarkerMapInput, MapPicker, PlacePicker, ...)
│       ├── Resources/        (AddressResource, LocationResource)
│       ├── Pages/, Widgets/, Blocks/MapBlock.php
├── resources/
│   ├── js/components/      (Lit: coordinate-picker-lit.js, geo-map-lit.js, map-lit.js, map-picker-lit.js, ...)
│   ├── js/components/map/  (default-view.js, labels.js, marker-config.js, ...)
│   ├── svg/, views/, css/
├── routes/                 (web.php e api.php: solo commenti, nessuna rotta)
├── config/                 (config.php, sushi.php)
├── database/               (migrations, factories, seeders)
├── lang/                   (de, en, es, fr, it, pl)
├── tests/                  (105 file PHP, 16 spec Playwright in tests/Playwright, tests/js/default-view.test.mjs)
├── docs/
├── module.json
└── composer.json
```

_(Albero corretto il 2026-10-14 con `ls` e `find` del codice. Prima elencava `app/Services/GeocodingService.php` e `MapProviderService.php` (`app/Services/` e' vuota), `app/DataTransferObjects/` come sede del DTO (il DTO usato e' `app/Datas/LocationData.php`; esiste anche un `app/DataTransferObjects/LocationDTO.php`) e `app/Filament/Fields/{AddressInput,...}.php` (i componenti stanno in `app/Filament/Forms/Components/`).)_

## Componenti Principali

| Classe | Scopo | Tipo |
|--------|-------|------|
| `GetCoordinatesAction` | `execute(string $formattedAddress): ?LocationData`, solo Google Maps (chiave `services.google.maps.key`) | Action |
| `GetAddressDataFromFullAddressAction` | `execute(string $fullAddress): ?AddressData`, catena di provider (google_maps, photon, nominatim, bing_maps, here, mapbox, opencage) | Action |
| `CalculateDistanceAction` | `execute(LocationData $origin, LocationData $destination): array`, via Google Distance Matrix (`distance.value` in metri) | Action |
| `Math/CalculateGeoDistanceAction`, `Distance/CalculateGeoDistanceAction` | distanza geodetica senza API esterne (due copie) | Action |
| `FilterCoordinatesInRadiusAction` | `execute(float $lat, float $lng, array $coordinates, int $radius): array`, raggio in **metri**; chiama `CalculateDistanceAction` per ogni punto | Action |
| `OptimizeRouteAction` (e `GoogleMaps/OptimizeRouteAction`) | `execute(Collection $locations): Collection` | Action |
| `ClusterLocationsAction` | `execute(array $locations, float $maxDistance = 1.0): array` | Action |
| `Datas/LocationData` | `latitude`, `longitude`, `name?`, `address?` (spatie/laravel-data) | Data |
| `AddressInput` | campo Filament con stato di caricamento della geolocalizzazione, solo `spritePath()` come API propria | Form Field |
| `CoordinatePicker` | picker Lit/Leaflet: `latitudeColumn()`, `longitudeColumn()`, `zoom()`, `center()`, `reverseGeocoding()`, `height()`, `geolocateWhenEmpty()`, `showSearch()`, `isMapReadonly()` | Form Field |
| `<x-geo::point-map>` | mappa di sola lettura di un punto (`View/Components/PointMap.php`) | Blade component |

_(Tabella corretta il 2026-10-14 leggendo le firme in `app/`. Prima citava `LocationDTO` come DTO principale e `AddressInput` come campo con provider configurabile.)_

## Utilizzo Comune

### Scenario 1: Geocodare un Indirizzo

```php
use Modules\Geo\Actions\GetCoordinatesAction;

// Solo Google Maps: serve config('services.google.maps.key'), altrimenti RuntimeException.
$location = app(GetCoordinatesAction::class)->execute('Via Roma 1, Roma, Italia'); // ?LocationData

echo $location?->latitude;
echo $location?->longitude;
```

_(Corretto il 2026-10-14: l'esempio precedente chiamava `GetCoordinatesAction::execute([...])` in modo statico con un array e un `provider`; l'Action e' una QueueableAction con `execute(string $formattedAddress)` e non ha il parametro provider. Per piu' provider usare `GetAddressDataFromFullAddressAction`.)_

### Scenario 2: Calcolare Distanza

```php
use Modules\Geo\Actions\Math\CalculateGeoDistanceAction;

// Distanza geodetica senza API esterne (unita' 'K' km, 'M' miglia, 'N' miglia nautiche).
$km = app(CalculateGeoDistanceAction::class)->execute(41.9028, 12.4964, 45.4642, 9.1900, 'K'); // ?float
```

_(Corretto il 2026-10-14: `CalculateDistanceAction` non accetta un array con `lat1`/`unit`: vuole due `LocationData`, chiama Google Distance Matrix e restituisce distanza (metri) e durata. Il "470.2 km" dell'esempio precedente non e' stato riprodotto.)_

### Scenario 3: Filtrare Coordinate entro Raggio

```php
use Modules\Geo\Actions\FilterCoordinatesInRadiusAction;

$nearby = app(FilterCoordinatesInRadiusAction::class)->execute(
    41.9028,   // latitudine del centro
    12.4964,   // longitudine del centro
    [['latitude' => '41.90', 'longitude' => '12.50']], // array di coordinate (stringhe)
    10000,     // raggio in metri
);
```

_(Corretto il 2026-10-14: la firma e' `execute(float, float, array, int $radius)`, il raggio e' in metri e i punti sono array `latitude`/`longitude`, non `LocationDTO`. Ogni punto richiede una chiamata a `CalculateDistanceAction` (Google Distance Matrix).)_

### Scenario 4: Form Input Geografico

```php
use Modules\Geo\Filament\Forms\Components\AddressInput;
use Modules\Geo\Filament\Forms\Components\CoordinatePicker;

$schema = [
    AddressInput::make('address')
        ->label('Indirizzo')
        ->required(),
    CoordinatePicker::make('location')   // come in Fixcity TicketForm::getLocationSection()
        ->geolocateWhenEmpty()
        ->reverseGeocoding(),
];
```

_(Corretto il 2026-10-14: il namespace `Modules\Geo\Filament\Fields\AddressInput` non esiste e i metodi `provider()` e `storeCoordinates()` non sono definiti in nessun file di `app/`.)_

## Configuration

### Map Provider Configuration

La configurazione sta in `laravel/Modules/Geo/config/config.php` (non in `laravel/config/local/geo/config.php`, che non esiste, verificato 2026-10-14). Chiavi reali: `api_keys.{google_maps,bing_maps,mapbox}` (env `GOOGLE_MAPS_API_KEY`, `BING_MAPS_API_KEY`, `MAPBOX_API_KEY`), `driver` (env `GEO_DRIVER`, default `google_maps`), `rate_limits`, `cache.{enabled,ttl,prefix}`, `map.default_view.{lat,lng,zoom}` (env `GEO_MAP_DEFAULT_LAT`, `GEO_MAP_DEFAULT_LNG`, `GEO_MAP_DEFAULT_ZOOM`; default Italia, 42.5, 12.5, zoom 6) e `http_client.{timeout,retry}`. Non esistono `default_provider`, `providers`, `distance_unit` ne' `default_radius`.

**Difetto noto (misurato con `php artisan tinker`, senza config cache)**: il file si carica sotto la chiave `geo.config`, quindi le chiavi vere sono `geo.config.driver`, `geo.config.api_keys.*`, `geo.config.cache.*`, ... Il codice legge invece `config('geo.driver')`, `config('geo.api_keys.google_maps')`, `config('geo.cache.*')`, `config('geo.rate_limits.*')` e `config('geo.http_client.*')` in `Actions/GetAddressDataFromFullAddressAction.php`, `Actions/GoogleMapsAction.php` e `Actions/GoogleMaps/GoogleMapsHttpAction.php`: a runtime sono `null` (`config('geo')` ha solo le chiavi `config` e `sushi`), quindi `GEO_DRIVER` non ha effetto e le chiavi API di quelle Actions non vengono lette da qui. Solo `HasCoordinatePicker` legge la chiave giusta (`geo.config.map.default_view`). Non corretto in questa passata (e' codice).

## Filament Form Fields

### AddressInput

Campo input con auto-completo indirizzo e geolocalizzazione browser:

```php
AddressInput::make('address')
    ->label('Location')
```

_(Corretto il 2026-10-14: `provider()`, `storeCoordinates()` e `showMap()` non esistono. `AddressInput` estende `Field`, ha il metodo `spritePath()` e mostra lo stato di caricamento della geolocalizzazione; per la mappa con punto usare `CoordinatePicker`.)_

### LatitudeLongitudeInput

Input lat/lng con validazione formato:

```php
LatitudeLongitudeInput::make('location')   // XotBaseField con un solo nome; non accetta due nomi
    ->label('Coordinates')
    ->required()
```

_(Corretto il 2026-10-14: la classe e' `Modules\Geo\Filament\Forms\Components\LatitudeLongitudeInput`, un `XotBaseField`; `make()` prende un solo nome di campo. La forma a due argomenti dell'esempio precedente non e' provata nel codice.)_

### LeafletMarkerMapInput

Map picker con marker interattivo:

```php
LeafletMarkerMapInput::make('map')
    ->label('Seleziona posizione')
```

_(Corretto il 2026-10-14: `storeAs()` non esiste; `LeafletMarkerMapInput` non definisce metodi pubblici propri. Per il picker corrente vedi `CoordinatePicker` e [wiki/concepts/coordinate-picker-field.md](./wiki/concepts/coordinate-picker-field.md).)_

## Testing

```bash
# Test JS senza browser (verificato 2026-10-14: 3 passati, 0 falliti)
cd laravel && node --test Modules/Geo/tests/js/default-view.test.mjs

# Test PHP su database usa-e-getta (mai sul DB di sviluppo), dalla radice del repo
export DB_DATABASE_LIMESURVEY= APP_CONFIG_CACHE=/nonexistent/config.php
bash bashscripts/tools/heavy-slot.sh bash bashscripts/tools/pest-scratch-db.sh Modules/Geo/tests/Unit/Actions/FormatCoordinatesActionTest.php
```

**Limite noto, verificato il 2026-10-14**: i test PHP di Geo non girano in questo ambiente. `tests/TestCase.php` imposta `config(['xra.pub_theme' => 'Meetup'])` (righe 73 e 77) e `Themes/Meetup` non ha `resources/views/pages`, quindi `FormatCoordinatesActionTest` (un test senza dipendenze) dà 6 falliti e 1 passato con `realpath not find dir[.../Themes/Meetup/resources/views/pages]`. Conteggi del DB di sviluppo prima e dopo identici (18 ticket, 11 utenti). I 105 file PHP e i 16 spec Playwright di `tests/Playwright` non sono stati eseguiti. Il comando precedente `pest Modules/Geo/tests/Feature/GeocodingTest.php` puntava a un file che non esiste.

## Quality Standards

- **PHPStan**: config unica `laravel/phpstan.neon` (livello `max`, senza baseline). Misura del 2026-10-14: `./vendor/bin/phpstan analyse Modules/Geo` (dalla cartella `laravel/`, senza `--level`) = **0 errori**, test compresi.
- **Test Coverage**: l'obiettivo "minimo 80%" non e' misurato (i test PHP non girano, vedi sopra).
- **Code Style**: PSR-12 via Pint (non eseguito in questa verifica).

Run locally (da `laravel/`):
```bash
php -d memory_limit=-1 ./vendor/bin/phpstan analyse Modules/Geo
./vendor/bin/pint Modules/Geo
```

_(Corretto il 2026-10-14: `--level=max` va omesso, la config unica fissa gia' il livello; in questo checkout i moduli non hanno un proprio `vendor/` ne' `phpstan.neon`.)_

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

_(Nota 2026-10-14, stato reale: i provider sono Actions separate per cartella, non c'e' un'interfaccia unica per tutti (esistono `Contracts/GeocodingServiceContract.php` e `GeocodingServiceInterface.php`). Il fallback esiste in `GetAddressDataFromFullAddressAction` (catena di 7 provider); lo switch via `GEO_DRIVER` oggi non funziona perche' la chiave letta e' `geo.driver` invece di `geo.config.driver`, vedi Configuration.)_

## Dipendenze / Moduli Correlati

- [Xot - Framework Base](../../Xot/docs/README.md) — Always dependency
- [User - Authentication](../../User/docs/README.md) — For user locations
- [Tenant - Multi-tenancy](../../Tenant/docs/README.md) — For tenant-scoped geo data
- [Cms - Content](../../Cms/docs/README.md) — For location-based content

## Documenti Correlati

- [Geo Models Domain Analysis](./geo-models-domain-analysis.md)
- Map Component Architecture _(target mancante, verificato 2026-10-14: `map-component-architecture.md` non esiste; vedi [story-map-component-analysis.md](./story-map-component-analysis.md) e [coordinate-picker-purpose.md](./coordinate-picker-purpose.md))_
- Geocoding Provider Integration _(target mancante, verificato 2026-10-14: `geocoding-providers.md` non esiste; vedi l'[ADR del driver di geocoding](./wiki/decisions/geo-geocoding-driver-consolidation.md), con la riserva sulla chiave di config descritta in Configuration)_
- [Leaflet/Lit Map Reconstruction](./wiki/concepts/geo-map-lit-reconstruction-guide.md)
- [PHPStan Configuration](../../../phpstan.neon)

## Regole Critiche

1. **Always extend Xot base classes** — Never extend Laravel/Filament directly
2. **Use namespace `Modules\Geo`** — Never `app\Geo`
3. **Strict typing** — `declare(strict_types=1);` in all files
4. **One geocoding service** — All geocoding via service, not direct API calls _(superata: `app/Services/` e' vuota per la regola no-services; il geocoding passa da QueueableAction, vedi `wiki/concepts/geo-no-services-migration.md`)_
5. **Type-safe LocationDTO** — Use DTO for coordinate transfer _(il DTO in uso e' `Datas/LocationData`; `Datas/LocationDTO.php` e `DataTransferObjects/LocationDTO.php` coesistono, vedi `tests/Unit/DataTransferObjects/LocationDTOTest.php`)_
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

> Verifica 2026-10-14 di questo blocco: PHPStan 0 errori su `Modules/Geo` (config unica, livello `max`): confermato. "Production" non e' provato (i test PHP del modulo non girano in questo ambiente, vedi Testing). Lo stato dei requisiti PHP/Laravel e' in `composer.json` e nell'app di `laravel/`, non in questo README.

## Standing order (qualita' + docs)

- **PHPStan a zero** sul codice del modulo: non ignorare errori, non abbassare il livello, non modificare `phpstan.neon` del progetto. Qualita' + docs + BMAD sono standing order, non opzionali.
- **Cartella test**: solo `tests/` (minuscolo). `Tests/` e' vietato (case-collision su macOS/Windows e confusione PSR-4).
- **Nomi `.md`**: kebab-case minuscolo, niente date/timestamp nel nome, unica eccezione `README.md`. Se esistono `readme.md` e `README.md`, resta solo `README.md`.
- **Docs**: solo dentro `docs/` gia' esistente; consolida invece di moltiplicare file; link relativi; focus su scopo/perche'/business logic (DRY + KISS).
- **Git**: forward-only (patch in avanti); no reset/revert/checkout come scorciatoia.
- **BMAD + second brain**: indici e decisioni vivono in `docs/` del modulo; aggiornali quando cambia il perche', non solo il come.

Vedi anche: [00-index.md](./00-index.md) · [index.md](./index.md)
