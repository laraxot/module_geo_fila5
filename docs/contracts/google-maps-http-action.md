---
title: "Contratto — GoogleMapsHttpAction"
type: contract
action: "Modules\\Geo\\Actions\\GoogleMaps\\GoogleMapsHttpAction"
module: Geo
status: active
tags: [contract, action, google-maps, external-services, cache, rate-limit]
created: 2026-11-26
updated: 2026-11-26
related:
  - get-address-from-google-maps-action.md
  - ../../app/Actions/GoogleMaps/GoogleMapsHttpAction.php
  - ../../tests/Unit/Actions/GoogleMaps/GoogleMapsHttpActionTest.php
---

# GoogleMapsHttpAction

Gateway HTTP verso Google Maps con tre punti d'ingresso: `executeReverseGeocode()`, `executeDistanceMatrix()`,
`executeElevation()`. Un solo `makeRequest()` privato applica cache, limitatore, timeout e retry. Sorgente:
`app/Actions/GoogleMaps/GoogleMapsHttpAction.php` (il docblock dice che sostituisce `GoogleMapsService`). Chiamanti di
produzione al 2026-11-26: nessuno (`rg "GoogleMapsHttpAction" Modules Themes app`, esclusi test e docs). Esiste una copia
quasi identica in `app/Actions/GoogleMapsAction.php` (anch'essa senza chiamanti e senza contratto).

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`). I test esistenti
(`GoogleMapsHttpActionTest.php`) controllano solo che la classe si risolva dal container e che i tre metodi esistano
(reflection): nessuna invariante è dimostrata.

## Input

| Metodo | Parametri | Endpoint (`GeoApiEndpoints`) |
|---|---|---|
| `executeReverseGeocode` | `float $latitude`, `float $longitude` | `GOOGLE_GEOCODING` (`latlng`, `language=it`) |
| `executeDistanceMatrix` | `array<string> $origins`, `array<string> $destinations` | `GOOGLE_DISTANCE_MATRIX` (unite con `\|`, `language=it`, `units=metric`) |
| `executeElevation` | `float $latitude`, `float $longitude` | `GOOGLE_ELEVATION` |

Configurazione: chiave `geo.api_keys.google_maps` (da `GOOGLE_MAPS_API_KEY`, valore solo in `.env`); `geo.cache.enabled`
(default `true`), `geo.cache.ttl` (86400 s), `geo.cache.prefix`; `geo.rate_limits.google_maps.requests_per_second` (50);
`geo.http_client.timeout` (5 s) e `geo.http_client.retry.*`. Le posizioni e gli indirizzi di origine e destinazione sono
dati personali quando riguardano persone.

## Output

- `array<string, mixed>`: il JSON decodificato di Google, tale e quale (compreso il suo campo `status`).

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| GEO-GMHTTP-INV-1 | Senza chiave `geo.api_keys.google_maps` nessuna richiesta parte: si lancia `GoogleMapsApiException` (messaggio `API key non configurata per google_maps`, righe 93-100). | — (non dimostrato) |
| GEO-GMHTTP-INV-2 | Con `geo.cache.enabled` vera, una richiesta già vista (stesso metodo, URL e parametri) si serve dalla cache per `geo.cache.ttl` secondi, senza chiamare Google (righe 113-119). Violata = costi e quota raddoppiati. | — (non dimostrato) |
| GEO-GMHTTP-INV-3 | Ogni errore (chiave mancante, rete, HTTP non 2xx, corpo non array) esce dai tre metodi pubblici come `GoogleMapsApiException`, perché ognuno avvolge `makeRequest()` in `catch (\Throwable)` (righe 43-50, 63-72, 83-89). | — (non dimostrato) |
| GEO-GMHTTP-INV-4 | In cache finisce solo una risposta 2xx con corpo array (la `Cache::put` sta dopo i controlli, righe 130-147); un errore non si memorizza. | — (non dimostrato) |

## Effetti collaterali

In ordine:

1. Lettura della chiave (INV-1) e composizione della chiave di cache `<prefix>google_maps_<md5 di metodo+URL+parametri>`.
2. Lettura della cache; con un valore presente si risponde qui (INV-2).
3. `RateLimiter::attempt('google_maps', …)` (vedi «Limiti noti»: l'esito è ignorato).
4. Una richiesta HTTP GET a Google con `key` nella query string, timeout e retry da `geo.http_client`.
5. `Cache::put` della risposta per `geo.cache.ttl` secondi.

## Errori

- Sempre `GoogleMapsApiException` verso il chiamante (INV-3), con il messaggio dell'errore originale.
- Il messaggio originale di un errore di rete cURL può contenere l'URL richiesto con la chiave nella query
  (`vendor/guzzlehttp/guzzle/src/Handler/CurlFactory.php:1128-1139`) e viene copiato nell'eccezione
  (`GoogleMapsApiException::requestFailed($e->getMessage())`): **da verificare con una prova**.

## Non fa

- Non geocodifica un indirizzo in avanti (c'è `GetAddressFromGoogleMapsAction`) né ottimizza percorsi
  (`OptimizeRouteAction`).
- Non controlla il campo `status` di Google: `REQUEST_DENIED` o `OVER_QUERY_LIMIT` con HTTP 200 tornano come risposta valida
  e finiscono anche in cache per 24 ore.
- Non scrive sul DB né invia notifiche.

## Limiti noti

- **Difetto di codice**: il limitatore non limita. `RateLimiter::attempt('google_maps', $maxAttempts, fn (): bool => true)`
  (riga 123) restituisce `false` quando il limite è superato, ma il valore è scartato e la richiesta parte comunque.
  In più `attempt()` ha finestra predefinita di 60 secondi, mentre la chiave di configurazione si chiama
  `requests_per_second`.
- **Da verificare**: la condizione di retry (righe 163-171) confronta l'eccezione con `\GuzzleHttp\Exception\ConnectionException`,
  classe che in Guzzle non esiste (esistono `ConnectException` e `RequestException`; `vendor/guzzlehttp/guzzle/src/Exception/`):
  per gli errori di connessione il retry probabilmente non scatta mai.
- La chiave API entra nella chiave di cache (come parte dei parametri serializzati, poi con `md5`): una rotazione della
  chiave invalida tutta la cache; `md5` non è usato per sicurezza ma è nel debito `security` di `tests/Arch/debt.php`.
- Una risposta Google con `status` di errore e HTTP 200 viene messa in cache per `geo.cache.ttl` secondi.
