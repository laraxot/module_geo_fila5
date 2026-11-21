---
<<<<<<< .merge_file_jYzgVE
<<<<<<< HEAD
title: "Best Practices"
=======
title: "best practices"
>>>>>>> d478251a (.)
=======
<<<<<<< .merge_file_PCmNqA
title: "best practices"
=======
title: "Best Practices"
>>>>>>> .merge_file_ERSeq2
>>>>>>> .merge_file_PD2L9P
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
<<<<<<< .merge_file_jYzgVE
<<<<<<< HEAD
qmd: "Best Practices"
=======
qmd: "best practices"
>>>>>>> d478251a (.)
=======
<<<<<<< .merge_file_PCmNqA
qmd: "best practices"
=======
qmd: "Best Practices"
>>>>>>> .merge_file_ERSeq2
>>>>>>> .merge_file_PD2L9P
issues: []
discussions: []
---

# Best Practices – Geo Module

## Principi DRY/KISS

- **DRY**: Centralizza la logica di geolocalizzazione in `GeoService`. Usa metodi statici solo per costanti.
- **KISS**: Mantieni i componenti Leaflet leggeri; usa `L.divIcon` con SVG inline per evitare dipendenze CDN esterne.
- **Clean Code**: Segui la regola `CoordinatePicker Multi-Column Save` – evita `dehydrated(false)` e usa `dehydrateStateUsing()`.

## Componenti

- Usa `LatitudeLongitudeInput` per campi diretti lat/lng (non estendere `CoordinatePicker`).
- Usa `CoordinatePicker` per selezione interattiva mappa con stato composito.
- Usa `AddressInput` per input testuale con suggerimenti e geocodifica.

## Test

- Implementa test unitari per `GeoService::geocode()`.
- Implementa test E2E per componenti Lit.
- Verifica assenza di `unpkg` o `L.Icon.Default` in bundle JS.

## Documentazione

- Aggiorna sempre `docs/index.md` quando aggiungi file.
- Riferisciti alle regole in `bashscripts/ai/.claude/rules/` per approfondimenti.
