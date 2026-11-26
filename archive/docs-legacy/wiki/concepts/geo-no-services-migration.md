---
title: "Geo no-services migration"
type: architecture
tags: [geo, architecture, queueable-action, adapters]
created: 2026-10-08
updated: 2026-10-08
issues: []
discussions: []
status: draft
qmd: "geo: no-services architecture geo"
---

# Geo: no-services architecture

## Decision

`laravel/Modules/Geo/app/Services` is retired. Geographic use cases are exposed by
Spatie QueueableAction classes under `app/Actions`, while external HTTP integrations
remain infrastructure adapters under `app/Adapters`.

## Mapping

| Legacy responsibility | Current owner |
|---|---|
| Region/province/city/CAP data | `GeoData` actions and `LoadGeoHierarchyAction` |
| JSON integrity validation | `ValidateGeoDataIntegrityAction` |
| Distance, haversine and polygon math | `Distance`/`Math`/`Polygon` actions |
| Google Maps HTTP | `GoogleMapsClient` adapter and Google Maps actions |
| HERE Routing HTTP | `HereClient` adapter and HERE actions |
| Geocoding and map use cases | provider/map actions |

The migration preserves the useful entry points through action contracts and removes
only duplicate service facades, empty stubs and service-only tests. No PHPStan ignore,
configuration change, or `mixed` widening was introduced.
