---
title: Geo — delete Services riesumati (wave3 post-phpstan-zero)
type: story
module: Geo
status: done
created: 2026-10-20
updated: 2026-10-20
tags: [services-to-actions, geo, boy-scout]
qmd: "geo services zombie delete hereservice geodataservice googlemaps geodata actions"
related:
  - ../decision-log.md
  - ../architecture/actions-over-services.md
  - ../../Xot/docs/stories/services-to-actions-global-wave.story.md
  - ../../Xot/docs/stories/phpstan-modules-zero-wave3.story.md
---

# Geo: Services zombie eliminati

## Perche'

I cinque file in `app/Services/` erano copie riesumate dal merge dopo che
`b112b61b` (2026-10-08) li aveva sostituiti con Actions. Scopo reale:

| Service rimosso | Caso d'uso | Action canonica |
|-----------------|------------|-----------------|
| `HereService` | route/summary HERE | `Actions/Here/*` |
| `GeoDataService` | gerarchia regioni/province/citta/CAP | `Actions/GeoData/LoadGeoHierarchyAction` (+ GetCities/Regions) |
| `GoogleMapsService` | HTTP Google Maps | `Actions/GoogleMaps/*` |
| `GeoService` / `BaseGeoService` | distanza / polygon / facade naming | `Actions/Distance/*`, `Actions/Polygon/*`; facade `GeoServiceFacade` punta ad Action |

`rg` su produzione (esclusi docs/tests): nessun `use Modules\Geo\Services\…` vivo — solo menzioni in commenti Action.

## Verifica

- File assenti sotto `app/Services/*Service.php`
- `phpstan analyse Modules` resta a 0 (remeasure coordinatore)
