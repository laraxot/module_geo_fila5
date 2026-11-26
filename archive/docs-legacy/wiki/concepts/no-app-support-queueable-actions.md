---
title: "no app/Support — Geo QueueableAction"
type: concept
tags: [geo, actions, queueable-action, support, infrastructure]
created: 2026-07-12
updated: 2026-10-22
qmd: "Geo module no Support GeoMapDataset GeoApiEndpoints GeoDataConfig Infrastructure"
related:
  - ../../../../../../docs/second-brain/process/no-app-support-queueable-actions.md
status: draft
---

# Geo — `app/Support/` eliminato

| Legacy | Destinazione |
|--------|--------------|
| `GeoMapDataset` | `Actions/Maps/*` + `Actions/Geo/GeoMapDatasetAction` |
| `GeoApiEndpoints` | `Infrastructure/Config/GeoApiEndpoints` (costanti, **non** Action) |
| `GeoDataConfig` | `Infrastructure/Config/GeoDataConfig` (costanti, **non** Action) |

Wave 2026-10-22: costanti uscite da `Actions/Config` (faux `execute()`) → Infrastructure.
Filament Geo selectors invocano solo Actions tipizzate (`LoadGeoHierarchyAction`, ecc.).

## Deep audit 2026-10-22

`GeoDataValidationRules` (solo const + payload) → `Infrastructure/Validation/` — non Action.
