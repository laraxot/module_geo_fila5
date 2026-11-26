---
title: "ADR — Geocodifica: provider preferito da configurazione, poi catena di fallback letterale"
type: decision
status: accepted
module: Geo
decision-makers: [team back office]
tags: [adr, geo, geocoding, providers, config, phpstan]
created: 2026-06-30
updated: 2026-11-26
related:
  - ../../app/Actions/GetAddressDataFromFullAddressAction.php
  - ../../config/config.php
  - ../contracts/get-address-data-from-full-address-action.md
  - ../../tests/Unit/Actions/GetAddressDataFromFullAddressActionTest.php
---

# ADR: geocodifica con provider preferito da configurazione e catena di fallback letterale

## Contesto

- `app/Actions/` contiene un'Action per ciascun provider di geocodifica (Google, Photon, Nominatim, Bing, HERE, Mapbox,
  OpenCage, LocationIQ…): ognuna integra un'API diversa (firma, parsing, campi restituiti).
- Il dispatcher `GetAddressDataFromFullAddressAction` provava sempre gli stessi 7 provider nello stesso ordine, con un
  array scritto nel codice: per cambiare provider bisognava cambiare codice.
- Le chiavi dei provider non stanno nel repository: quale provider sia "vivo" lo sa solo l'installazione.
- Vincolo misurato su PHPStan livello max (Larastan): `app($class)->execute()` è tipizzato come l'Action concreta solo se
  `$class` è un `class-string` letterale risolto nello stesso metodo del `try` che lo usa; passato da `config()` o da un
  metodo helper degrada a `mixed` (riproduzione descritta nel commento in testa al metodo).

Domanda: come scegliere il provider per installazione, senza deploy, mantenendo il codice tipizzato?

## Driver della decisione

- La scelta del provider è per installazione (solo l'ambiente sa quali chiavi esistono): non deve richiedere un deploy.
- Il codice deve restare tipizzato per PHPStan livello max.
- Ogni provider ha una API e una risposta diversa: nessuna astrazione può appiattirle senza costo.

## Alternative scartate

- Mappa dei provider in `config/config.php`: configurabile anche l'ordine, ma il tipo di ritorno degrada a `mixed` e
  PHPStan max fallisce; servirebbero cast e assert in ogni ramo.
- Un'unica Action "driver" parametrica per tutti i provider: riscrittura di tutte le integrazioni, che hanno risposte
  diverse; nessun guadagno finché la scelta è per installazione.
- Strategy/Manager alla Laravel (`Manager::driver()`): più codice e un registro da mantenere, per sette rami fissi.
- Lasciare l'ordine fisso: ogni installazione che non ha la chiave Google paga un tentativo fallito a ogni geocodifica.

## Decisione

- Chiave `geo.driver` (`GEO_DRIVER`, default `google_maps`) in `config/config.php`.
- `GetAddressDataFromFullAddressAction::execute()` tiene la mappa `chiave => Action::class` **letterale nel metodo**, mette
  in testa il provider di `geo.driver` se è una chiave nota, e prova gli altri nell'ordine storico
  (`google_maps, photon, nominatim, bing_maps, here, mapbox, opencage`). Il primo `AddressData` vince; le eccezioni dei
  provider finiscono in `getErrors()`.
- Le Action dei singoli provider restano separate: nessuna classe "driver generica".

## Conseguenze

- Pro: provider scelto da env, nessun cambio di comportamento per chi non imposta `GEO_DRIVER`; il codice resta tipizzato.
- Contro: aggiungere un provider vuol dire toccare la mappa nel metodo (e questo ADR); l'ordine dei fallback non è
  configurabile.
- Debito: la `Notification` costruita a fine catena non viene mai inviata (manca `send()`); questa catena non ha cache né
  limite di frequenza, quindi il ramo Nominatim non rispetta la policy come fa il proxy di `QueryNominatimAction`.
- Debito: il duplicato `app/Actions/FilterCoordinatesInRadius.php` (condizione invertita `>= $raggio`, nessun chiamante;
  la regola usa `FilterCoordinatesInRadiusAction`) era stato segnato da togliere ma è ancora nel modulo.

## Conferma

- `cd laravel && vendor/bin/pest Modules/Geo/tests/Unit/Actions/GetAddressDataFromFullAddressActionTest.php` (o
  `--group=GEO-GEOCODE-INV-<N>`): `GEO-GEOCODE-INV-1` prova che con `geo.driver = photon` risponde Photon e Google non viene
  interrogato; `GEO-GEOCODE-INV-2` che un provider che lancia non ferma la catena; `GEO-GEOCODE-INV-3` che, se falliscono tutti,
  il risultato e' `null`. Contratto: [GetAddressDataFromFullAddressAction](../contracts/get-address-data-from-full-address-action.md).
- `cd laravel && ./vendor/bin/phpstan analyse Modules/Geo` fallisce se la mappa viene spostata fuori dal metodo senza ritipizzarla.
- Solo revisione: l'ordine di fallback (`GEO-GEOCODE-INV-4`) e il fatto che un provider che risponde `null` non sia un errore
  (`GEO-GEOCODE-INV-5`) non hanno un test.

## Stato attuale

Misurato il 2026-11-26. La scelta del provider da `geo.driver` vale solo per `GetAddressDataFromFullAddressAction`. Esiste un secondo
dispatcher che la ignora: `GetCoordinatesByAddressAction` prova Google, Bing, OpenCage, Nominatim e Open-Meteo in ordine fisso
(`app/Actions/GetCoordinatesByAddressAction.php:34-38`) e legge la chiave OpenCage da `services.opencage.api_key` (riga 228), mentre
`app/Actions/OpenCage/GetAddressFromOpenCageAction.php:32` legge `services.opencage.key`. Non ha chiamanti di produzione
(`rg -l GetCoordinatesByAddressAction Modules Themes app`, esclusi test e docs, non trova nulla); contratto:
[get-coordinates-by-address-action](../contracts/get-coordinates-by-address-action.md). Decisione che serve (non presa qui, il codice non e'
stato toccato): toglierlo oppure farlo passare dal dispatcher.
