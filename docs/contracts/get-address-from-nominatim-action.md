---
title: "Contratto — GetAddressFromNominatimAction"
type: contract
action: "Modules\\Geo\\Actions\\Nominatim\\GetAddressFromNominatimAction"
module: Geo
status: active
tags: [contract, action, geocoding, nominatim, openstreetmap, privacy]
created: 2026-11-26
updated: 2026-11-26
related:
  - query-nominatim-action.md
  - get-address-data-from-full-address-action.md
  - ../adr/0003-osm-proxy-tile-nominatim.md
  - ../../app/Actions/Nominatim/GetAddressFromNominatimAction.php
---

# GetAddressFromNominatimAction

Geocodifica un indirizzo su Nominatim (OpenStreetMap) e lo restituisce come `AddressData`. È il ramo `nominatim` della
catena di [GetAddressDataFromFullAddressAction](get-address-data-from-full-address-action.md) (riga 61 del dispatcher) ed è
l'unico chiamante di produzione. Sorgente: `app/Actions/Nominatim/GetAddressFromNominatimAction.php`. Nessun test la
esercita (`rg -l GetAddressFromNominatimAction Modules/Geo/tests` non trova nulla).

**Non è il proxy OpenStreetMap.** Il progetto prescrive che il geocoding OSM passi dal proxy del modulo
([ADR](../adr/0003-osm-proxy-tile-nominatim.md), [QueryNominatimAction](query-nominatim-action.md)); questa Action chiama
Nominatim direttamente dal server, senza le garanzie del proxy.

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).

## Input

- `string $address`: indirizzo libero. **È un dato personale**: parte verso OSMF.

## Output

- `AddressData` costruito dal primo risultato; `null` se la risposta non è 2xx o la lista è vuota.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| GEO-NOMCHAIN-INV-1 | Per esecuzione parte una sola richiesta GET a `https://nominatim.openstreetmap.org/search` con `format=json`, `addressdetails=1`, `limit=1` (righe 35-42). | — (non dimostrato) |
| GEO-NOMCHAIN-INV-2 | Una risposta non 2xx o senza risultati dà `null`, non un'eccezione (righe 50-59). | — (non dimostrato) |

Nessuna invariante è dimostrata (vedi «Backlog test» nel README).

## Effetti collaterali

- Una richiesta HTTP GET a Nominatim con lo User-Agent fisso `Xot/1.0`. Nessuna cache, nessun limite di frequenza,
  nessuna scrittura locale.

## Errori

- Status non 2xx = `null`.
- Un errore di rete (`ConnectionException`) non è catturato: esce dall'Action; nella catena lo cattura
  `GetAddressDataFromFullAddressAction` (che lo registra in `getErrors()` e prosegue), altrove esce al chiamante.

## Non fa

- Non rispetta la Nominatim Usage Policy come fa il proxy: 1 richiesta al secondo per tutta l'applicazione, User-Agent con
  contatto, cache dei risultati, interruttore `geo.config.osm_proxy.nominatim.enabled`.
- Non filtra né limita i parametri: `q` è l'indirizzo così com'è.
- Non passa dalla rotta `/api/geo/nominatim` né condivide il limitatore `geo:nominatim:upstream` di `QueryNominatimAction`.

## Limiti noti

- Aggira l'ADR del proxy lato server: se la catena arriva al ramo `nominatim` più volte al secondo (per esempio in una
  bulk action) OSMF riceve più di una richiesta al secondo dallo stesso IP e può bloccarlo. Lo spegnimento da
  configurazione (`nominatim.enabled`) non ha effetto su questo percorso. Proposta: far passare questa Action da
  `QueryNominatimAction` (decisione del lead, non presa in questa passata).
- Valori inventati quando il risultato è incompleto: `latitude`/`longitude` valgono `0` se mancano (riga 65-66),
  `country` vale `Italia` e `country_code` vale `IT` (riga 67, 69), `postal_code` vale `0` se manca o non è numerico.
  Chi scrive le coordinate (`UpdateCoordinatesFromAddressAction`) potrebbe scrivere `0,0`.
- `locality` e `district` sono entrambi `address.suburb` (righe 71 e 75).
