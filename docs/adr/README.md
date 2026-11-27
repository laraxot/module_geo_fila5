---
title: "ADR del modulo Geo"
type: index
tags: [adr, decisioni, geo]
created: 2026-11-18
updated: 2026-11-24
---

# ADR del modulo Geo

Il **perché** delle forme di codice di Geo che sembrano strane e che un agente rischia di "semplificare": il proxy
OpenStreetMap lato server (privacy e policy di OSMF), la mappa dei provider di geocodifica scritta dentro l'Action
(vincolo di PHPStan), i componenti mappa Lit in Light DOM (stabilità nei wizard Livewire).

Leggili prima di: far chiamare al browser un servizio di mappe esterno, spostare la scelta dei provider in config o
aggiungerne uno, scrivere o copiare un componente mappa JS.

Formato (cinque sezioni, `type: decision`, nome file senza date né numeri) e regole:
[action-behavioral-contract](../../../Xot/docs/rules/action-behavioral-contract.md). Chi cambia una decisione scrive un
nuovo ADR e segna il vecchio `status: superseded`.

## Indice

- [Tile e geocoding OpenStreetMap passano dal nostro server](osm-proxy-tile-nominatim.md) — il browser parla solo con il nostro dominio; il server rispetta cache, User-Agent e 1 richiesta/s di OSMF.
- [Geocodifica: provider preferito da configurazione, poi fallback letterale](geocoding-preferred-provider-with-fallback.md) — `geo.driver` sceglie il primo provider; la mappa resta nel metodo per restare tipizzata.
- [Componenti mappa Lit in Light DOM con pane Leaflet protetto](map-components-lit-light-dom.md) — `createRenderRoot`, `guard([])` e `ResizeObserver` per mappe che sopravvivono a step, tab e Livewire.
