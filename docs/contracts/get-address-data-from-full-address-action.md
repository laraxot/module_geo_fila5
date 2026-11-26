---
title: "Contratto — GetAddressDataFromFullAddressAction"
type: contract
action: "Modules\\Geo\\Actions\\GetAddressDataFromFullAddressAction"
module: Geo
status: active
tags: [contract, action, geocoding, providers, privacy]
created: 2026-11-24
updated: 2026-11-26
related:
  - ../adr/0002-geocoding-preferred-provider-with-fallback.md
  - ../../app/Actions/GetAddressDataFromFullAddressAction.php
  - ../../tests/Unit/Actions/GetAddressDataFromFullAddressActionTest.php
---

# GetAddressDataFromFullAddressAction

Dispatcher della geocodifica lato server: prova il provider preferito (`geo.driver`), poi gli altri in ordine fisso, e
restituisce il primo risultato. Perché è fatto così: [ADR provider preferito con fallback](../adr/0002-geocoding-preferred-provider-with-fallback.md).
Sorgente: `app/Actions/GetAddressDataFromFullAddressAction.php`. Chiamanti di produzione:
[UpdateCoordinatesFromAddressAction](update-coordinates-from-address-action.md) (riga 75) e
[UpdateClientCoordinatesBulkAction](update-client-coordinates-bulk-action.md) (riga 38); nessun chiamante dal front office.

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`). Prova:
`cd laravel && vendor/bin/pest Modules/Geo/tests/Unit/Actions/GetAddressDataFromFullAddressActionTest.php`
(oppure `--group=GEO-GEOCODE-INV-<N>`).

## Input

- `string $fullAddress`: indirizzo libero. **È un dato personale** e parte così com'è verso i provider esterni.
- Configurazione: `geo.driver` (`GEO_DRIVER`, default `google_maps`; chiavi valide: `google_maps`, `photon`, `nominatim`,
  `bing_maps`, `here`, `mapbox`, `opencage`). Le credenziali dei provider stanno solo in `.env`/`config/services.php`
  (`services.google.maps_api_key`, `services.bing.maps_api_key`, `services.here.key`, `services.mapbox.access_token`,
  `services.opencage.key`); Photon e Nominatim non vogliono chiavi.

## Output

- `AddressData` del primo provider che ne restituisce uno; `null` se nessuno risponde.
- `getErrors()`: `Collection<int, string>` con i messaggi delle eccezioni dei provider falliti nell'ultima `execute()`
  (azzerata a ogni chiamata, riga 46). È stato dell'istanza: leggerla subito dopo la propria `execute()` sulla stessa istanza.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| GEO-GEOCODE-INV-1 | Il provider di `geo.driver` (se è una chiave nota) è interrogato per primo; al primo `AddressData` la catena si ferma e i provider successivi non sono interrogati. Violata = ogni geocodifica spende richieste (e quota) su provider non scelti. | `GEO-GEOCODE-INV-1` |
| GEO-GEOCODE-INV-2 | Un provider che lancia un'eccezione non interrompe la catena: il suo messaggio va in `getErrors()` e si passa al successivo. | `GEO-GEOCODE-INV-2` |
| GEO-GEOCODE-INV-3 | Se tutti i provider falliscono il risultato è `null`, mai un'eccezione verso il chiamante. | `GEO-GEOCODE-INV-3` |
| GEO-GEOCODE-INV-4 | Ordine di fallback fisso: `google_maps, photon, nominatim, bing_maps, here, mapbox, opencage`; `geo.driver` ne sposta uno in testa senza cambiare l'ordine degli altri (righe 58-73). | — (non dimostrato) |
| GEO-GEOCODE-INV-5 | Un provider che risponde `null` («nessun risultato») non è un errore: la catena prosegue e `getErrors()` non riceve nessun messaggio (righe 81-88). | — (non dimostrato) |

**Dimostrato** (`GetAddressDataFromFullAddressActionTest.php`): INV-1 con `geo.driver = photon` e due provider
sostituiti nel container (Photon risponde, Google non è chiamato); INV-2 con Photon che lancia e Google che risponde
(messaggio `photon down` in `getErrors()`); INV-2 e INV-3 insieme con tutti i provider a 503 (`null` e
`getErrors()` non vuota). **Promesso ma non coperto**: INV-4 e INV-5. I test «returns AddressData when first service
succeeds» e «initializes with empty errors collection» controllano solo che `getErrors()` parta vuota.

## Effetti collaterali

- Per ogni provider provato: risoluzione dal container (`app($service)`) e una richiesta HTTP a un servizio esterno:
  Google Maps, Photon (`photon.komoot.io`), Nominatim (`nominatim.openstreetmap.org`), Bing, HERE, Mapbox, OpenCage;
  fino a sette richieste, una per provider, con le credenziali lette da `services.*`.
- `$this->errors` riceve il messaggio di ogni `\Exception` catturata.
- Nessuna scrittura sul DB, nessuna cache, nessuna notifica inviata (vedi «Non fa»).

## Errori

- Nessuna eccezione per provider falliti: ritorno `null` e messaggi in `getErrors()` (INV-2, INV-3).
- Si cattura solo `\Exception`: un `\Error` (es. `TypeError`) di un provider esce dall'Action.
- Provider senza chiave: di norma lancia (es. `GoogleMapsApiException::missingApiKey()`), il messaggio finisce in
  `getErrors()` e la catena prosegue.
- Il docblock di `execute()` dichiarava `@throws \RuntimeException`, ma l'eccezione è commentata (riga 91): vale questo
  contratto, l'Action non lancia.

## Non fa

- Non mostra notifiche: costruisce una `Notification` Filament (righe 92-96) ma non chiama `send()`: codice morto,
  l'utente non vede nulla; chi vuole avvisare legge `getErrors()`.
- Non mette in cache i risultati né rispetta i limiti di frequenza dei provider: la chiamata a Nominatim di questa
  catena (`Nominatim\GetAddressFromNominatimAction`) **non** passa dal limitatore di `QueryNominatimAction`
  ([contratto](get-address-from-nominatim-action.md)). Per geocodifiche dal browser si usa il proxy
  `/api/geo/nominatim`, non questa Action.
- Non scrive sul DB: lo fa `UpdateCoordinatesFromAddressAction`.
- Non legge la lista dei provider da config: la mappa è letterale nel metodo per un vincolo di PHPStan (vedi ADR).
- Non chiede consenso né anonimizza l'indirizzo prima di inviarlo ai provider.

## Limiti noti

- Dati personali verso terzi: l'indirizzo completo può arrivare fino a sette fornitori diversi (uno solo se risponde il
  primo). Oggi le Action chiamanti sono azioni di back office (Filament); un uso dal front office richiede una
  decisione sulla base giuridica.
- I messaggi delle eccezioni sono copiati in `getErrors()` senza filtro, e i chiamanti li mostrano in una notifica
  (`CoordinatesSection.php`, `UpdateCoordinatesBulkAction.php`). Un errore di rete di cURL accoda l'URL richiesto, query
  string compresa (`vendor/guzzlehttp/guzzle/src/Handler/CurlFactory.php:1128-1139`), e Google, Bing e Mapbox
  mettono la chiave nella query (`GetAddressFromGoogleMapsAction.php:59-62`): **da verificare con una prova** se la
  chiave può finire a schermo.
- `app(GetAddressDataFromFullAddressAction::class)` crea un'istanza nuova a ogni chiamata (nessun `singleton` in
  `GeoServiceProvider`): `getErrors()` si legge solo sull'istanza che ha eseguito.
