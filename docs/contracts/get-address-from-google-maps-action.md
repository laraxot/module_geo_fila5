---
title: "Contratto — GetAddressFromGoogleMapsAction"
type: contract
action: "Modules\\Geo\\Actions\\GoogleMaps\\GetAddressFromGoogleMapsAction"
module: Geo
status: active
tags: [contract, action, geocoding, google-maps, external-services, privacy]
created: 2026-11-26
updated: 2026-11-26
related:
  - get-address-data-from-full-address-action.md
  - ../adr/0002-geocoding-preferred-provider-with-fallback.md
  - ../../app/Actions/GoogleMaps/GetAddressFromGoogleMapsAction.php
  - ../../tests/Unit/Actions/GoogleMaps/GetAddressFromGoogleMapsActionTest.php
---

# GetAddressFromGoogleMapsAction

Geocodifica un indirizzo su Google Maps e lo restituisce come `AddressData` completo (coordinate e componenti). È il
primo provider della catena di [GetAddressDataFromFullAddressAction](get-address-data-from-full-address-action.md)
(`geo.driver` vale `google_maps` di default, riga 59 del dispatcher) ed è il suo unico chiamante di produzione.
Sorgente: `app/Actions/GoogleMaps/GetAddressFromGoogleMapsAction.php`.

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`). Prova:
`cd laravel && vendor/bin/pest Modules/Geo/tests/Unit/Actions/GoogleMaps/GetAddressFromGoogleMapsActionTest.php`
(oppure `--group=GEO-GOOGLEADDR-INV-<N>`).

## Input

- `string $address`: indirizzo libero. **È un dato personale**: parte verso Google.
- Configurazione: `services.google.maps_api_key` (`config/services.php:49`, da `GOOGLE_MAPS_API_KEY`); il valore sta solo
  in `.env`.

## Output

- `AddressData` costruito dal **primo** risultato (mai `null`: se non c'è un risultato lancia).

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| GEO-GOOGLEADDR-INV-1 | Senza chiave (assente o stringa vuota) lancia `GoogleMapsApiException::missingApiKey()` prima di ogni richiesta (righe 46-52). | `GEO-GOOGLEADDR-INV-1` |
| GEO-GOOGLEADDR-INV-2 | Una risposta HTTP non 2xx lancia `GoogleMapsApiException` con messaggio `Richiesta a Google Maps fallita: HTTP <status>`. | `GEO-GOOGLEADDR-INV-2` |
| GEO-GOOGLEADDR-INV-3 | Una risposta senza risultati lancia `GoogleMapsApiException::noResultsFound()`. | `GEO-GOOGLEADDR-INV-3` |
| GEO-GOOGLEADDR-INV-4 | Con un risultato, coordinate e componenti vengono dal primo risultato: `country`/`country_code` da `country` (nome lungo / corto), `city` da `administrative_area_level_3`, `locality` da `locality`, `county` da `administrative_area_level_2`, `state` da `administrative_area_level_1`, `street` da `route`, `street_number`, `district` da `sublocality_level_1`, `postal_code` come intero. | `GEO-GOOGLEADDR-INV-4` |
| GEO-GOOGLEADDR-INV-5 | Un componente assente non rompe la mappatura: `street`, `street_number`, `district`, `locality` diventano stringa vuota; `country`, `city`, `county`, `state` restano `null`, `postal_code` vale `0` (righe 103-118). | `GEO-GOOGLEADDR-INV-5` |

**Dimostrato** (`GetAddressFromGoogleMapsActionTest.php`, `Http::fake`): INV-1 con chiave `null` e con chiave vuota;
INV-2 con HTTP 500; INV-3 con `ZERO_RESULTS`; INV-4 con una risposta completa (tutti i campi tranne `city`);
INV-5 con la sola componente `country` (`street` vuota). **Non coperto**: `city`, e il fatto che senza chiave la
richiesta non parta (il test controlla solo l'eccezione).

## Effetti collaterali

In ordine:

1. Lettura della chiave; senza chiave si ferma (INV-1).
2. Una richiesta HTTP GET a `https://maps.googleapis.com/maps/api/geocode/json` con `address` e `key` nella query
   string, senza timeout impostato (predefinito del client HTTP), senza cache, senza limite di frequenza.
3. Nessuna scrittura (DB, file, notifiche).

## Errori

- `GoogleMapsApiException` (estende `\RuntimeException`) per INV-1, INV-2, INV-3, con messaggi italiani fissi.
- Un errore di rete non è catturato: esce come `Illuminate\Http\Client\ConnectionException`, il cui messaggio può
  riportare l'URL con la chiave (vedi «Limiti noti» di
  [GetAddressDataFromFullAddressAction](get-address-data-from-full-address-action.md)); il dispatcher lo cattura e lo
  copia in `getErrors()`.

## Non fa

- Non legge il campo `status` di Google: `REQUEST_DENIED` o `OVER_QUERY_LIMIT` con HTTP 200 e `results` vuoto
  diventano «Nessun risultato trovato», indistinguibili da un indirizzo inesistente.
- Non fa geocodifica inversa (`GetAddressByLatLngFromGoogleMapsAction`), distanze né elevazione.
- Non mette in cache né limita la frequenza: il gateway con cache è `GoogleMapsHttpAction`, che questa Action non usa.
- Non sceglie lei di essere il primo provider: lo decide `geo.driver` nel dispatcher.

## Limiti noti

- Il nome della chiave di configurazione per Google Maps non è uniforme nel modulo (`services.google.maps_api_key`,
  `services.google.maps.key`, `geo.api_keys.google_maps`): vedi [GetCoordinatesAction](get-coordinates-action.md).
- `city` è `administrative_area_level_3` e non `locality`: giusto per i Comuni italiani, può restare `null` altrove.
