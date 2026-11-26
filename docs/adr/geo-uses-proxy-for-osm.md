---
title: "Stub — Geo usa un proxy applicativo per OSM (superseded)"
type: decision
status: superseded
module: Geo
decision-makers: [team back office]
created: 2026-11-24
updated: 2026-11-26
superseded_by: ./0003-osm-proxy-tile-nominatim.md
qmd: "stub superseded ADR Geo geo-uses-proxy-for-osm → 0003-osm-proxy-tile-nominatim"
---

# Stub — Geo usa un proxy applicativo per OSM (superseded)

STUB → [0003-osm-proxy-tile-nominatim.md](0003-osm-proxy-tile-nominatim.md)

## Contesto

Esisteva una versione breve della decisione «tile e geocoding OpenStreetMap
passano dal nostro server». Il canone del modulo usa basename `NNNN-slug.md` e
un solo ADR vivo per decisione.

## Driver della decisione

- Un solo ADR vivo per la stessa decisione (DRY): il file breve duplicava
  `0003-osm-proxy-tile-nominatim.md`, che contiene misure, policy OSMF e link.
- Path legacy non devono restare ADR completi duplicati.
- I link storici al kebab devono puntare al canone numerato.

## Alternative scartate

- Tenere due ADR vivi sulla stessa decisione: doppia fonte di verità.
- Cancellare il file senza nota: rompe i link legacy al path kebab.

## Decisione

Questo file è **superseded**. Canonico:
[0003-osm-proxy-tile-nominatim.md](0003-osm-proxy-tile-nominatim.md), che riporta
anche la verifica `OsmProxyTest` e il throttle delle rotte.

## Conseguenze

- Pro: un solo ADR da aggiornare (`0003-…`); il kebab resta un puntatore.
- Contro: chi apre il kebab deve seguire il link al canone.

## Conferma

- Contenuto decisionale solo in `0003-osm-proxy-tile-nominatim.md`.
- Frontmatter `status: superseded` e link relativo al canone presenti.
