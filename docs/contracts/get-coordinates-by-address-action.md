---
title: "Contratto — GetCoordinatesByAddressAction"
type: contract
action: "Modules\\Geo\\Actions\\GetCoordinatesByAddressAction"
module: Geo
status: active
tags: [contract, action, geocoding, coordinates, privacy, external-services]
created: 2026-11-26
updated: 2026-11-26
related:
  - get-address-data-from-full-address-action.md
  - get-address-from-nominatim-action.md
  - ../adr/0003-osm-proxy-tile-nominatim.md
  - ../../app/Actions/GetCoordinatesByAddressAction.php
  - ../../tests/Unit/Actions/GetCoordinatesByAddressActionTest.php
---

# GetCoordinatesByAddressAction

Da un indirizzo libero a una coppia di coordinate (`CoordinatesData`), provando fino a cinque servizi esterni in cascata.
Sorgente: `app/Actions/GetCoordinatesByAddressAction.php`. **È un secondo dispatcher di geocodifica, distinto da
[GetAddressDataFromFullAddressAction](get-address-data-from-full-address-action.md)**: provider, ordine, chiavi di
configurazione e gestione degli errori sono diversi. Chiamanti di produzione al 2026-11-26: nessuno
(`rg "GetCoordinatesByAddressAction" Modules Themes app`, esclusi test e docs); si risolve solo dal container.

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`). Prova:
`cd laravel && vendor/bin/pest Modules/Geo/tests/Unit/Actions/GetCoordinatesByAddressActionTest.php`
(oppure `--group=GEO-BYADDRESS-INV-<N>`).

## Input

- `string $address`: indirizzo libero. **È un dato personale** e parte verso i servizi elencati sotto.
- Chiavi di configurazione (solo i nomi; i valori stanno in `.env`): `services.google.maps_api_key`,
  `services.bing.maps_api_key`, `services.opencage.api_key`. Nominatim e Open-Meteo non vogliono chiavi.

## Output

- `CoordinatesData` (`latitude`, `longitude`) del primo servizio che trova un risultato; `null` se nessuno lo trova o se
  l'indirizzo è vuoto.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| GEO-BYADDRESS-INV-1 | Un indirizzo vuoto o di soli spazi dà `null` senza alcuna richiesta e senza notifica (ritorno anticipato, righe 28-31). Violata = quota e richieste spese per una domanda senza risposta. | `GEO-BYADDRESS-INV-1` |
| GEO-BYADDRESS-INV-2 | Google, Bing e OpenCage senza chiave configurata (assente o stringa vuota) sono saltati senza richiesta. | — (non dimostrato) |
| GEO-BYADDRESS-INV-3 | Ordine fisso Google, Bing, OpenCage, Nominatim, Open-Meteo; il primo risultato vince e i successivi non sono interrogati (catena di `??`, righe 34-38). | — (non dimostrato) |
| GEO-BYADDRESS-INV-4 | Se nessun servizio restituisce coordinate (risposte vuote, `ZERO_RESULTS`, status HTTP non 2xx) il risultato è `null`, non un'eccezione. | `GEO-BYADDRESS-INV-4` |

**Dimostrato** (`GetCoordinatesByAddressActionTest.php`, rete bloccata con `Http::preventStrayRequests()`): INV-1 con
`Http::assertNothingSent()`; INV-4 con Google che risponde `ZERO_RESULTS` e tutti gli altri a `[]`. **Promesso ma non
coperto**: INV-2 (il test «google api key not configured» controlla solo che il risultato sia `null`, non che Google
non sia stato chiamato) e INV-3.

## Effetti collaterali

In ordine, fermandosi al primo risultato:

1. Con indirizzo vuoto: nessuno (INV-1).
2. Google (`maps.googleapis.com`), Bing (`dev.virtualearth.net`, **in `http://`**, `GeoApiEndpoints::BING_LOCATIONS`),
   OpenCage (`api.opencagedata.com`): una richiesta GET ciascuno, solo se la chiave c'è. La chiave viaggia nella query
   string.
3. Nominatim (`nominatim.openstreetmap.org/search`, `limit=1`): richiesta GET diretta, **senza** passare da
   `QueryNominatimAction`, senza limite di frequenza, senza cache, con lo User-Agent predefinito del client HTTP.
4. Open-Meteo (`api.open-meteo.com/v1/geocoding`, `count=1`): richiesta GET, nessuna chiave.
5. Se nessuno risponde: una `Notification` Filament `danger` e `persistent` con testo inglese fisso, **inviata** (`send()`).

## Errori

- Status HTTP non 2xx, JSON senza i campi attesi o lista vuota di un servizio = si passa al servizio successivo.
- Nessun errore di rete è catturato: una `ConnectionException` (rete assente, timeout) esce dall'Action e **interrompe**
  la catena senza provare i servizi successivi.
- L'esito «nessuno ha risposto» non distingue «indirizzo non trovato» da «tutti i servizi in errore».

## Non fa

- Non sceglie il provider da configurazione (`geo.driver` vale per `GetAddressDataFromFullAddressAction`, non qui).
- Non restituisce città, CAP o via: solo latitudine e longitudine.
- Non scrive sul DB, non mette in cache, non limita le richieste.
- Non passa dal proxy OpenStreetMap (`/api/geo/nominatim`) né rispetta la Nominatim Usage Policy (1 richiesta al
  secondo, User-Agent con contatto): [ADR proxy](../adr/0003-osm-proxy-tile-nominatim.md).
- Non chiede consenso né anonimizza l'indirizzo.

## Limiti noti

- Dato personale verso fino a cinque terzi (Google, Bing, OpenCage, OSMF, Open-Meteo); Bing è chiamato in chiaro
  (`http://`), con la chiave nell'URL.
- La chiave OpenCage è letta da `services.opencage.api_key`, mentre `GetAddressFromOpenCageAction` legge
  `services.opencage.key` (riga 32): la stessa credenziale richiede due chiavi di configurazione diverse.
- Open-Meteo è un geocoder di nomi di luogo, non di indirizzi civici: un indirizzo con via e numero ottiene al
  più il Comune, e quel punto approssimato viene restituito come se fosse esatto.
- La notifica di errore è inviata anche fuori da un contesto Filament (CLI, coda) e il suo testo non è tradotto.
- Codice morto di produzione: nessun chiamante, nessun contratto di uso. Prima di riusarla, valutare di sostituirla con
  `GetAddressDataFromFullAddressAction`, che ha provider configurabile e gestione delle eccezioni.
