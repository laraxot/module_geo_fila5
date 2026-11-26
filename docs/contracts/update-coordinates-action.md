---
title: "Contratto — UpdateCoordinatesAction"
type: contract
action: "Modules\\Geo\\Actions\\UpdateCoordinatesAction"
module: Geo
status: active
tags: [contract, action, geocoding, coordinates, db-write, place]
created: 2026-11-26
updated: 2026-11-26
related:
  - get-coordinates-action.md
  - update-coordinates-from-address-action.md
  - ../../app/Actions/UpdateCoordinatesAction.php
  - ../../tests/Unit/Actions/UpdateCoordinatesActionTest.php
---

# UpdateCoordinatesAction

Aggiorna latitudine e longitudine di un `Place` geocodificando l'indirizzo collegato (`$place->address->formatted_address`).
Sorgente: `app/Actions/UpdateCoordinatesAction.php`. Chiamanti di produzione al 2026-11-26: nessuno
(`rg "UpdateCoordinatesAction" Modules Themes app`, esclusi test e docs). **Non va confusa** con
[UpdateCoordinatesFromAddressAction](update-coordinates-from-address-action.md), che lavora su qualunque modello,
non lancia eccezioni e usa il dispatcher con provider configurabile.

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`). Il file di test
`tests/Unit/Actions/UpdateCoordinatesActionTest.php` contiene solo `uses(TestCase::class)`: nessun test.

## Input

- `Modules\Geo\Models\Place` con la relazione `address` (`BelongsTo`) valorizzata e `address->formatted_address`
  stringa; le colonne `latitude` e `longitude` di `Place` sono fillable (`Place.php:175-176`).

## Output

- `void`. L'esito è nel `Place` aggiornato o in un'eccezione.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| GEO-PLACECOORDS-INV-1 | Senza indirizzo (relazione assente o `formatted_address` non stringa) lancia `\RuntimeException('Place address is required')` prima di ogni chiamata esterna (righe 28-30). | — (non dimostrato) |
| GEO-PLACECOORDS-INV-2 | Se la geocodifica non dà un risultato lancia `\RuntimeException('Could not get coordinates for address: …')` e il `Place` non è modificato (righe 32-36). | — (non dimostrato) |
| GEO-PLACECOORDS-INV-3 | A geocodifica riuscita scrive solo `latitude` e `longitude`, con un solo `update()` (righe 38-41). | — (non dimostrato) |

Nessuna invariante è dimostrata (vedi «Backlog test» nel README).

## Effetti collaterali

In ordine:

1. Legge `$place->address` (query sulla relazione se non già caricata).
2. Chiama [GetCoordinatesAction](get-coordinates-action.md): una richiesta HTTP a Google Maps Geocoding con l'indirizzo
   (dato personale) e la chiave API.
3. `Place::update(['latitude' => …, 'longitude' => …])`: scrittura DB, eventi Eloquent del modello.

## Errori

- `\RuntimeException` per indirizzo mancante (INV-1) o geocodifica senza risultato (INV-2).
- Le eccezioni di `GetCoordinatesAction` (chiave mancante, HTTP non 2xx, JSON non valido) escono invariate.
- Un errore di rete esce come `Illuminate\Http\Client\ConnectionException`, non come `RuntimeException`
  (nessun `try/catch` in nessuna delle due Action).

## Non fa

- Non usa il provider configurato (`geo.driver`) né i fallback: solo Google Maps.
- Non scrive città, CAP o via sull'indirizzo.
- Non cattura le eccezioni: chi la accoda (`onQueue`) le vede come job falliti.
- Non salta i `Place` che hanno già coordinate.

## Limiti noti

- **Difetto di codice (configurazione)**: `GetCoordinatesAction` legge la chiave da `services.google.maps.key`
  (`GetCoordinatesAction.php:35`), che nessun file di configurazione definisce: `config/services.php:49` espone solo
  `services.google.maps_api_key`. Con la configurazione del repository questa Action lancia sempre
  `Google Maps API key not found`. I test di `GetCoordinatesAction` passano perché impostano la chiave a mano.
- `GetCoordinatesAction` risponde `null` anche per `OVER_QUERY_LIMIT` e `REQUEST_DENIED`: l'Action le riporta come
  «Could not get coordinates», nascondendo un problema di quota o di credenziali.
