---
title: "Architecture Decision Records"
type: index
tags: [adr, decisioni]
created: 2026-11-18
updated: 2026-11-23
---

# Architecture Decision Records

Il **perche'** delle scelte di questo pacchetto: una decisione per file, con le alternative scartate.
Il nome del file e' l'argomento, senza date ne' numeri (la data sta nella frontmatter).

## Formato

```markdown
---
title: "ADR — <decisione in una riga>"
type: decision
status: accepted | superseded | deprecated
created: AAAA-MM-GG
updated: AAAA-MM-GG
issues: []
---

# ADR: <decisione>

## Contesto
Fatti e vincoli che hanno reso necessaria la scelta (misure, norme, policy, incidenti).

## Decisione
Cosa si fa, in concreto, e dove sta nel codice.

## Alternative scartate
Ogni alternativa seria, con il motivo per cui non e' stata scelta.

## Conseguenze
Pro, contro, debito che resta, cosa misurare. Chi cambia la decisione scrive un nuovo ADR e segna questo `superseded`.
```

## Decisioni

- [Le integrazioni HTTP geografiche sono Actions, non Services](no-service-geo-integrations.md)
- [Proxy Geo incluso nella cache delle rotte](route-cache-includes-proxy.md)
- [ADR — Tile e geocoding OpenStreetMap passano dal nostro server](osm-proxy-tile-nominatim.md)
- [Geocoding e tile OSM passano dal proxy](geo-uses-proxy-for-osm.md)

## Decisioni precedenti (formato libero, non ancora ADR)

- [geo-geocoding-driver-consolidation](../wiki/decisions/geo-geocoding-driver-consolidation.md)
- [standardized-geo-architecture](../wiki/decisions/standardized-geo-architecture.md)
