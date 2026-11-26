---
title: "Contratti del modulo Geo"
type: index
tags: [contracts, actions, interfaces, geo]
created: 2026-11-18
updated: 2026-11-26
---

# Contratti del modulo Geo

Cosa promettono le Action di Geo che parlano con servizi esterni (OpenStreetMap, Nominatim, provider di geocodifica) o
scrivono coordinate nel DB, e soprattutto cosa **non** fanno. Le due Action del proxy OSM sono nell'elenco `REQUIRED` di
`Modules/Xot/tests/Unit/Docs/ActionContractsAreCompleteTest.php`: il loro contratto e' obbligatorio. Vale lo stesso per le
interfacce (`app/Contracts`): promettono la superficie pubblica del pacchetto.

Leggili prima di chiamare, modificare o imitare una di queste Action; le invarianti con un group Pest si verificano con
`cd laravel && vendor/bin/pest Modules/Geo/tests --group=<ID>`, quelle con «- (non dimostrato)» sono debito dichiarato.
Un contratto descrive il comportamento **di oggi**, con i suoi limiti: un comportamento legacy non e' un modello per codice nuovo.

Formato (sei sezioni, tabella invarianti con ID, `@contract` nel docblock):
[action-behavioral-contract](../../../Xot/docs/rules/action-behavioral-contract.md).

## Contratto di comportamento di un'Action

Un file per Action, nome in kebab-case della classe (`create-ticket-action.md`), frontmatter `type: contract` e
`action: <FQCN>`, e queste sei sezioni nell'ordine:

```markdown
## Input
## Output
## Invarianti
## Effetti collaterali
## Errori
## Non fa
```

Il docblock dell'Action rimanda al file con `@see docs/contracts/<file>.md` e `@contract docs/contracts/<file>.md`.
Chi cambia il comportamento aggiorna il contratto nello stesso commit. Template: [_template.md](_template.md).

## Indice

- [FetchOsmTileAction](fetch-osm-tile-action.md) - tile OSM dal nostro dominio, cache su disco di almeno 7 giorni, richieste condizionali, copia scaduta se OSM e' giu'.
- [QueryNominatimAction](query-nominatim-action.md) - ricerca e geocodifica inversa via proxy: 1 richiesta/s per il sito, parametri filtrati, cache, spegnibile da config.
- [GetAddressDataFromFullAddressAction](get-address-data-from-full-address-action.md) - dispatcher della geocodifica: provider di `geo.driver` per primo, poi fallback; mai eccezioni, errori in `getErrors()`.
- [UpdateCoordinatesFromAddressAction](update-coordinates-from-address-action.md) - geocodifica l'indirizzo di un modello e scrive solo `latitude`/`longitude`.
- [UpdateClientCoordinatesBulkAction](update-client-coordinates-bulk-action.md) - geocodifica in lotto una collezione di indirizzi in un'unica transazione.
- [UpdateCoordinatesAction](update-coordinates-action.md) - aggiorna le coordinate di un `Place` geocodificando il suo indirizzo (Google).
- [GetCoordinatesAction](get-coordinates-action.md) - coordinate di un indirizzo dalla Google Maps Geocoding API.
- [GetCoordinatesByAddressAction](get-coordinates-by-address-action.md) - da un indirizzo libero a `CoordinatesData`, con cascata di fino a cinque servizi.
- [GetAddressFromGoogleMapsAction](get-address-from-google-maps-action.md) - geocodifica un indirizzo su Google Maps e restituisce `AddressData` completo.
- [GetAddressFromNominatimAction](get-address-from-nominatim-action.md) - geocodifica un indirizzo su Nominatim (OSM) come `AddressData`, senza passare dal proxy.
- [GoogleMapsHttpAction](google-maps-http-action.md) - gateway HTTP verso Google Maps: reverse geocode, distance matrix, elevazione, con cache e limitatore.

Inventari machine-readable: [INDEX.md](INDEX.md) e [index.md](index.md).

## Stato di copertura

Invarianti dimostrate (con un test Pest `->group('<ID>')`) su totali: **30 su 51** in 11 contratti (misurato il 2026-11-26
leggendo le tabelle `Invarianti` e i `->group()` nei test; Pest non e' stato eseguito in questa passata).

| Contratto | Dimostrate / totali | Test |
|---|---|---|
| FetchOsmTileAction | 5 / 7 | `tests/Feature/OsmProxyTest.php` |
| QueryNominatimAction | 7 / 8 | `tests/Feature/OsmProxyTest.php` |
| GetAddressDataFromFullAddressAction | 3 / 5 | `tests/Unit/Actions/GetAddressDataFromFullAddressActionTest.php` |
| UpdateCoordinatesFromAddressAction | 3 / 4 | `tests/Unit/Actions/UpdateCoordinatesFromAddressActionTest.php` |
| GetAddressFromGoogleMapsAction | 5 / 5 | `tests/Unit/Actions/GoogleMaps/GetAddressFromGoogleMapsActionTest.php` |
| GetCoordinatesAction | 5 / 5 | `tests/Unit/Actions/GetCoordinatesActionTest.php` |
| GetCoordinatesByAddressAction | 2 / 4 | `tests/Unit/Actions/GetCoordinatesByAddressActionTest.php` |
| GetAddressFromNominatimAction | 0 / 2 | nessuno |
| GoogleMapsHttpAction | 0 / 4 | solo reflection (`GoogleMapsHttpActionTest.php`) |
| UpdateClientCoordinatesBulkAction | 0 / 4 | nessuno |
| UpdateCoordinatesAction | 0 / 3 | `UpdateCoordinatesActionTest.php` contiene solo `uses(TestCase::class)` |

## Backlog contract

Action che chiamano servizi esterni e non hanno ancora un contratto (nessuna scrive sul DB). Ordine per rischio: dati personali
verso terzi nella catena di geocodifica, poi servizi senza chiamanti.

| Action | Motivo | Test oggi |
|---|---|---|
| `Photon/GetAddressFromPhotonAction` | ramo `photon` del dispatcher (`GetAddressDataFromFullAddressAction.php:60`): l'indirizzo va a un terzo; usa Guzzle, quindi l'audit non la segnala | nel test del dispatcher |
| `Mapbox/GetAddressFromMapboxAction` | ramo `mapbox` del dispatcher (riga 64): indirizzo a un terzo; chiave `services.mapbox.access_token` | `tests/Unit/Actions/Mapbox/GetAddressFromMapboxActionTest.php` |
| `Bing/GetAddressFromBingMapsAction` | ramo `bing_maps` del dispatcher (riga 62): indirizzo a un terzo, chiave `services.bing.maps_api_key` | 1 file |
| `Here/GetAddressFromHereMapsAction` | ramo `here` del dispatcher (riga 63): indirizzo a un terzo, chiave `services.here.key` | 2 file |
| `OpenCage/GetAddressFromOpenCageAction` | ramo `opencage` del dispatcher (riga 65); legge `services.opencage.key` mentre `GetCoordinatesByAddressAction` legge `services.opencage.api_key` | nessuno |
| `GoogleMaps/CalculateDistanceMatrixAction` | chiamata da `CalculateDistanceAction`: origini e destinazioni a Google | 5 file |
| `GoogleMapsAction` | variante con cache e retry gemella di `GoogleMapsHttpAction`, chiamata da `Elevation/GetElevationAction` | 6 file |
| `GoogleMaps/OptimizeRouteAction` | nessun chiamante di produzione; legge `services.google.maps.key`, non definita (riga 50) | 3 file |
| `Here/GetHereRouteSummaryAction` | nessun chiamante di produzione: coordinate di un percorso a HERE | 1 file |
| `LocationIQ/GetAddressFromLocationIQAction` | nessun chiamante di produzione (non e' nella mappa del dispatcher) | 1 file |
| `Mapbox/GetAddressFromMapboxLatLngAction` | nessun chiamante di produzione; chiave `services.mapbox.api_key`, diversa da `GetAddressFromMapboxAction` | 1 file |
| `Weather/GetOpenWeatherDataAction` | nessun chiamante di produzione; chiave `services.openweather.api_key` | nessuno |

## Backlog test

Invarianti senza test (21 su 51). Non e' stato scritto nessun test in questa passata; la proposta indica cosa dimostrerebbe la regola.

| Invarianti | Cosa manca |
|---|---|
| GEO-TILE-INV-6, GEO-TILE-INV-7 | in `OsmProxyTest`: una sola `Http::get` per esecuzione; una risposta HTML non sovrascrive un tile in cache (`Http::fake` con `text/html`) |
| GEO-NOMINATIM-INV-8 | in `OsmProxyTest`: un 502 e un 429 non finiscono in cache (seconda richiesta richiama l'upstream) |
| GEO-GEOCODE-INV-4, GEO-GEOCODE-INV-5 | nel test del dispatcher: ordine di fallback con tutti i provider sostituiti nel container; provider che risponde `null` senza errori in `getErrors()` |
| GEO-COORDS-INV-4 | un `update()` che lancia: `false`, messaggio in `getErrors()` e `Log::error` |
| GEO-BYADDRESS-INV-2, GEO-BYADDRESS-INV-3 | `Http::assertNotSent` per Google senza chiave; ordine della cascata |
| GEO-NOMCHAIN-INV-1, GEO-NOMCHAIN-INV-2 | nessun test per `GetAddressFromNominatimAction`: una richiesta con i tre parametri; status non 2xx e lista vuota danno `null` |
| GEO-GMHTTP-INV-1..4 | `GoogleMapsHttpActionTest` controlla solo la reflection: chiave mancante, cache, `GoogleMapsApiException`, errori non in cache |
| GEO-BULKCOORDS-INV-1..4 | nessun test: scrittura delle sole coordinate, transazione unica, conteggi |
| GEO-PLACECOORDS-INV-1..3 | `UpdateCoordinatesActionTest.php` e' vuoto: indirizzo mancante, geocodifica senza risultato, un solo `update()` |

## Difetti di codice emersi (non corretti, fuori dallo scopo della passata)

- `GoogleMapsHttpAction.php:123`: `RateLimiter::attempt(...)` restituisce `false` oltre il limite ma il risultato e' scartato, la richiesta parte comunque.
- `GoogleMapsHttpAction.php:163-171`: il retry confronta l'eccezione con `\GuzzleHttp\Exception\ConnectionException`, classe che non esiste in Guzzle (`ConnectException`).
- `GetCoordinatesAction.php:35` e `GoogleMaps/OptimizeRouteAction.php:50`: leggono `services.google.maps.key`, non definita; con la configurazione del repository lanciano sempre «API key not found».
- `UpdateClientCoordinatesBulkAction.php:53`: `getErrors()` su una nuova istanza (`app()` non e' singleton): il messaggio di errore e' sempre «Errore sconosciuto».
- `Nominatim/GetAddressFromNominatimAction.php:65-75`: valori inventati se il risultato e' incompleto (`0`, `Italia`, `IT`).
- `GetAddressDataFromFullAddressAction.php:91-96`: `Notification::make()` senza `send()`, codice morto.
- `UpdateCoordinatesFromAddressAction.php:68`: `empty($fullAddress)` tratta `"0"` come vuoto.
- Chiavi di configurazione incoerenti per la stessa credenziale: Google (`services.google.maps_api_key`, `services.google.maps.key`, `geo.api_keys.google_maps`), OpenCage (`key` e `api_key`), Mapbox (`access_token` e `api_key`).
