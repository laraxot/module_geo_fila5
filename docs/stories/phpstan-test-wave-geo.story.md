---
title: "[STORY] PHPStan Geo, lane geo della regressione da pull (483 errori a 0)"
type: story
status: review
priority: high
created: 2026-10-20
updated: 2026-10-20
module: Geo
tags: [phpstan, tests, pull, regressione]
related:
  - ../../../Xot/docs/stories/phpstan-test-wave-regression.story.md
  - ./phpstan-cleanup-geo.story.md
  - ./conflict-markers-business-logic-tests.story.md
---

# PHPStan Geo: lane geo

Bucket `geo` del run PHPStan del 2026-10-20: 30 file, 483 errori nella baseline delle 09:00. Dopo la lane: 0 errori sui file presenti alla misura finale (`tests/Unit/Traits/TestModel.php` e' stato rimosso da questa lane; `app/Traits/HasAddresses.php`, `app/Models/Traits/SushiToJsons.php` e `GeographicalScopes.php` sono stati rimossi dopo da un'altra sessione; misura finale su 26 file). Coordinamento del run: vedi la story di Xot in `related`.

## Cosa e' successo

Il pull dei sottomoduli delle 08:57 ha riscritto la working copy di Geo con una versione diversa da `HEAD` (`6fde33ea`): 165 file di `app/` e 42 di `tests/` differiscono da `HEAD`. Le differenze sono di tre tipi, e ciascuna e' una causa sola.

## Cause e correzioni

Quadratura della baseline (483): 50 + 19 (punto 1), 2 (punto 2), 12 (punto 3), 371 (punto 4), 23 (punto 5), 3 (punto 6) e 3 su tre trait poi rimossi da un'altra sessione.

### 1. Alias `@phpstan-type` usati come tipo nativo (50 errori in produzione, 19 nei test collegati)

Una riscrittura automatica ha sostituito `: array` con il nome dell'alias dichiarato nel docblock (`GeoDataset`, `GeoDatasetStats`, `GeoFeature`, `GeoProperties`, `GeoMapConfig`). Quei nomi non sono classi (`rg -P` su `app` e `tests`: nessuna dichiarazione `class|interface|trait|enum`). A runtime ogni chiamata sarebbe stata un `TypeError` in uscita.

Scopo del codice: normalizzare il GeoJSON del widget mappa (`resources/data/geo-map-widget.geojson`) in un dataset tipizzato e calcolarne categorie e statistiche. Il tipo preciso vive nel docblock, quello nativo deve restare `array`.

Corretto in quattro file, solo le firme: `app/Support/GeoMapDataset.php`, `app/Actions/Maps/LoadGeoMapDatasetAction.php`, `app/Actions/Geo/Support/GeoMapDatasetAction.php`, `app/Filament/Widgets/GeoMapWidget.php`. Le firme native sono di nuovo identiche a `HEAD`. Spariscono anche gli errori nei cinque test che leggono quei valori (`GeoMapDatasetTest`, `GeoMapDatasetActionsTest`, `Unit/Filament/GeoMapWidgetTest`, `Unit/Filament/Widgets/GeoMapWidgetTest`, `GetAddressDataFromFullAddressActionTest`).

### 2. Docblock `/** @var */` degradati e tipo di ritorno stretto (2 errori)

- `database/seeders/GeoJsonDownloader.php`: due `/** @var array<string, mixed> */` erano diventati `/* @var */` (commento semplice, nessun effetto per PHPStan). Ripristinati.
- `app/Actions/GetAddressDataFromFullAddressAction.php`: `execute()` era diventato `: AddressData` ma l'ultimo ramo ritorna `null` (nessun provider risponde, e `UpdateClientCoordinatesBulkAction` gestisce il caso). Ripristinato `?AddressData` come in `HEAD`, docblock `@return AddressData|null`.

### 3. Servizi rimasti nella working copy ma eliminati in `HEAD` (12 errori)

`app/Services/GeoDataService.php`, `GeoDataValidator.php`, `GeoService.php`, `HereService.php` sono stati eliminati dal commit `60524329` (2026-10-08) e sostituiti da Action (`LoadGeoHierarchyAction`, `ValidateGeoDataIntegrityAction`, `IsPointInPolygonAction`, `GetHereRouteDurationAndLengthAction`, come dice il decision log di Geo). Il pull li ha riportati. Nessun file del repo li chiama (`rg` su moduli, app, config, routes, tests).

Corretti sul posto (regola 4 del run), senza creare Service nuovi:

- `GeoDataService`, `GeoDataValidator`, `HereService`: contenuto del blob `60524329^` (scritto con `git show` su file). Il blob ha ancora un errore in `getCities()` (`pluck('name','code')` ritorna `Collection<string,string>`, il docblock dichiara righe `array{name, code}`): ora `getCities()` ritorna le righe come `getProvinces()`, e il ramo vuoto e' tipizzato come li'. Nessun chiamante, nessun cambio osservabile.
- `GeoService`: `@param array<mixed> $polygon` e `$c = false` al posto della catena `$i = $j = $c = 0` (le assegnazioni a `$i` e `$j` erano riscritte subito dal `for`).

Copia dei file come erano prima della lane: `scratchpad/geo-backup/` della sessione.

### 4. Test riespansi dal pull (371 errori) ripristinati da `HEAD`

I test della working copy erano scaffold: colonne inventate (`model_type`, `is_primary`, `extra_data`), `Country`/`City` mai esistiti, `shouldReceive()` su una Action concreta, `Tests\TestCase` al posto di `Modules\Geo\Tests\TestCase`, ignore `@phpstan-ignore` non corrispondenti. I blob di `HEAD` (cioe' lo stato dell'8 ottobre, a 0 errori) sono stati scritti sui file con `git show HEAD:<path> > <path>`, mai `checkout` o `restore`:

| File | Errori prima | Note |
|---|---|---|
| `tests/Unit/Models/ComuneTest.php` | 90 | `Comune::factory()` e `mixed` |
| `tests/Unit/Models/comunetest.php` | 90 | stessa causa (due file che differiscono per maiuscole) |
| `tests/Unit/AddressModelTest.php` | 52 | |
| `tests/Unit/Models/AddressTest.php` | 47 | |
| `tests/Feature/AddressIntegrationTest.php` | 28 | colonne inventate |
| `tests/Unit/Actions/CalculateDistanceActionTest.php` | 28 | `shouldReceive` su Action concreta |
| `tests/Pest.php` | 18 | helper su `Country` e `City`, classi inesistenti |
| `tests/Unit/Actions/GetCoordinatesActionTest.php` | 11 | |
| `tests/Unit/Models/BaseModelTest.php` | 4 | |
| `tests/Unit/Traits/HasAddressTest.php` | 3 | duplicava la fixture `HasAddressTestModel` |

Tutti identici a `HEAD` (`git diff --quiet HEAD -- <file>`).

### 5. `LookupPlaceActionTest` (23 errori): test riscritto, non solo ripristinato

`HEAD` ha un file di 9 righe con solo `uses(TestCase::class)` (nessun test). `LookupPlaceAction` esiste e il test della working copy era valido nell'intento ma pieno di `@phpstan-ignore`, `json_encode` non Safe e user agent sbagliato (`<main module>/1.0`, mentre l'Action manda `Xot/1.0`). Riscritto sul modello di `ReverseGeocodeActionTest`: client Guzzle con `MockHandler` iniettato per riflessione, nessuna rete. Cinque test: location dall'OSM id, endpoint e query e user agent, risultato vuoto (`RuntimeException`), errore HTTP 503, errore di rete. PHPStan sulla cartella `tests/Unit/Actions/Nominatim`: 0.

### 6. `tests/Unit/Traits/TestModel.php` (3 errori): rimosso

Classe `TestModelTest extends PHPUnit\Framework\TestCase` in un file chiamato `TestModel.php`, con tabella `test_models` (e' dell'Activity, non di Geo) e un modello duplicato della fixture canonica `tests/Fixtures/Traits/HasAddressTestModel.php`. `HEAD` non ha il file: il commit `60524329` lo aveva eliminato. Rimosso dalla working copy. Recupero: `git -C laravel/Modules/Geo show b1bc1fb3:tests/Unit/Traits/TestModel.php`. La copia pre-lane e' anche in `scratchpad/geo-backup/`.

## Verifica

- PHPStan con `--error-format=json` su tutti i file presenti del bucket (29 alla prima misura, 26 all'ultima), a batch di 8: 0 errori file, 0 generali. Lo script scrive il totale dal JSON, non da un filtro su testo (un primo conteggio con filtro `grep` aveva dato uno zero falso: i path erano passati a PHPStan come un unico argomento).
- `php -l` pulito su tutti i file toccati.
- Pest (`--no-coverage`, solo test senza DB):
  - `LookupPlaceActionTest` (nuovo) e `ReverseGeocodeActionTest`: 9 passati, 2 `todo`.
  - `Unit/Support/GeoMapDatasetTest` e `Unit/Actions/Maps/GeoMapDatasetActionsTest`, che esercitano le quattro firme ripristinate al punto 1: 6 passati.
  - Non lanciati i test ripristinati da `HEAD` che usano il DB (`quaeris_data_test` non esiste).

## Aperto, per decisione dell'utente

1. **Servizi risorti.** Il decision log di Geo (2026-10-08) dice che i servizi di `app/Services`, `SushiToJsons.php` e `GeographicalScopes.php` restano eliminati. Il pull aveva riportato 6 servizi (`BaseGeoService`, `GeoDataService`, `GeoDataValidator`, `GeoService`, `GoogleMapsService`, `HereService`) e i due trait. `SushiToJsons` e `GeographicalScopes` (e `app/Traits/HasAddresses.php`, tutti nel bucket con 1 errore) sono stati rimossi dopo le 09:50 da un'altra sessione, non da questa lane. I 4 servizi del bucket sono tipizzati sul posto e non cancellati; `BaseGeoService` e `GoogleMapsService` non sono nel bucket. Proposta: eliminarli come i due trait, in coerenza con la regola no-services.
2. **Riscrittura automatica del pull.** `app/` differisce da `HEAD` per +2432 / -840 righe, soprattutto stile (Yoda, `new X()`, docblock `@param` compattati). Oltre ai casi corretti qui, 8 file hanno ancora `/* @var` al posto di `/** @var`: oggi a 0 errori, ma il tipo e' perso. Non toccati.
3. **Quattro test del widget rossi, non per i tipi.** `Unit/Filament/GeoMapWidgetTest` (3 su 4) e `Unit/Filament/Widgets/GeoMapWidgetTest` ("exposes expected view") falliscono con `Target [Illuminate\Contracts\View\Factory] is not instantiable` (il widget e' istanziato con `new` senza applicazione avviata, nel costruttore di `XotBaseWidget`) e con la vista `xot::filament.widgets.base` al posto di `geo::filament.widgets.geo-map-widget`. Erano gia' rossi a monte dei tipi (con gli alias come tipo nativo il TypeError sarebbe arrivato dopo). Non toccati: serve decidere se il widget ha un `$view` proprio o se il test va allineato.
