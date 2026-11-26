---
title: "Contratto — GetCoordinatesAction"
type: contract
action: "Modules\\Geo\\Actions\\GetCoordinatesAction"
module: Geo
status: active
tags: [contract, action, geocoding, google-maps, external-services, privacy]
created: 2026-11-26
updated: 2026-11-26
related:
  - update-coordinates-action.md
  - ../../app/Actions/GetCoordinatesAction.php
  - ../../tests/Unit/Actions/GetCoordinatesActionTest.php
---

# GetCoordinatesAction

Coordinate di un indirizzo dalla Google Maps Geocoding API. Sorgente: `app/Actions/GetCoordinatesAction.php`. Chiamante
di produzione al 2026-11-26: solo `UpdateCoordinatesAction` (riga 32, [contratto](update-coordinates-action.md)).

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`). Prova:
`cd laravel && vendor/bin/pest Modules/Geo/tests/Unit/Actions/GetCoordinatesActionTest.php`
(oppure `--group=GEO-GETCOORDS-INV-<N>`).

## Input

- `string $formattedAddress`: indirizzo libero. **È un dato personale**: parte verso Google.
- Configurazione: chiave `services.google.maps.key` (vedi «Limiti noti»: non è definita da nessun file di configurazione).
  Il valore, quando c'è, sta solo in `.env`.

## Output

- `Modules\Geo\Datas\LocationData` con `latitude`, `longitude` (float) del **primo** risultato e `address` uguale
  all'indirizzo ricevuto; `null` se Google non trova nulla.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| GEO-GETCOORDS-INV-1 | Senza chiave configurata lancia `\RuntimeException('Google Maps API key not found')` prima di ogni richiesta (righe 35-38). | `GEO-GETCOORDS-INV-1` |
| GEO-GETCOORDS-INV-2 | Una risposta HTTP non 2xx lancia `\RuntimeException('Failed to get coordinates from Google Maps API')`. | `GEO-GETCOORDS-INV-2` |
| GEO-GETCOORDS-INV-3 | Un corpo non JSON lancia `\RuntimeException('Invalid JSON response from Google Maps API')`. | `GEO-GETCOORDS-INV-3` |
| GEO-GETCOORDS-INV-4 | Se `status` non è `OK` o `results` è vuoto restituisce `null`, mai un'eccezione: `ZERO_RESULTS`, `OVER_QUERY_LIMIT` e `REQUEST_DENIED` sono indistinguibili. | `GEO-GETCOORDS-INV-4` |
| GEO-GETCOORDS-INV-5 | Con più risultati si usa il primo; le coordinate sono `float` e `address` è l'indirizzo in ingresso, non quello normalizzato da Google. | `GEO-GETCOORDS-INV-5` |

**Dimostrato** (`GetCoordinatesActionTest.php`, `Http::fake` su `maps.googleapis.com`, chiave impostata a mano nel test):
INV-1 con chiave `null`; INV-2 con 500 e 408; INV-3 con corpo `Invalid JSON`; INV-4 con `ZERO_RESULTS`,
`OVER_QUERY_LIMIT`, `REQUEST_DENIED` e `results` vuoto; INV-5 con due risultati. **Non coperto**: che la richiesta
non parta senza chiave (il test controlla solo l'eccezione) e il comportamento con un errore di rete vero (il test
«network timeout» simula un 408, non una `ConnectionException`).

## Effetti collaterali

In ordine:

1. Lettura della configurazione; senza chiave si ferma (INV-1).
2. Una richiesta HTTP GET a `https://maps.googleapis.com/maps/api/geocode/json` con `address` e `key` nella query
   string, senza timeout impostato (vale il predefinito del client HTTP), senza cache, senza limite di frequenza.
3. Nessuna scrittura (DB, file, notifiche).

## Errori

- `\RuntimeException` con messaggio fisso per chiave mancante, HTTP non 2xx, JSON non valido (INV-1, INV-2, INV-3): i
  messaggi non contengono URL né chiave.
- Un errore di rete (rete assente, timeout) **non** è catturato: esce come `Illuminate\Http\Client\ConnectionException`,
  il cui messaggio può riportare l'URL con la chiave (stesso meccanismo descritto in
  [GetAddressDataFromFullAddressAction](get-address-data-from-full-address-action.md), «Limiti noti»).

## Non fa

- Non distingue quota esaurita e credenziali rifiutate da «indirizzo non trovato» (INV-4).
- Non restituisce componenti dell'indirizzo (città, CAP, via): per quelli c'è `GoogleMaps\GetAddressFromGoogleMapsAction`.
- Non usa il provider configurato in `geo.driver` né i fallback.
- Non scrive sul DB: lo fa `UpdateCoordinatesAction`.

## Limiti noti

- **Difetto di codice (configurazione)**: la chiave è letta da `services.google.maps.key` (riga 35) ma
  `config/services.php:49` definisce solo `services.google.maps_api_key` (da `GOOGLE_MAPS_API_KEY`). Con la
  configurazione del repository l'Action lancia sempre INV-1. Lo stesso nome errato è in
  `GoogleMaps\OptimizeRouteAction.php:50`; le altre Action Google leggono `services.google.maps_api_key` e
  `GoogleMapsHttpAction` legge `geo.api_keys.google_maps`: tre nomi per la stessa credenziale.
- La tipizzazione dichiara `status` e `results` sempre presenti: un JSON valido senza quei campi dà un errore PHP
  (`Undefined array key`), non `null`.
