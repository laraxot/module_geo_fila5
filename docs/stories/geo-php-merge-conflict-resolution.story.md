---
title: "Geo — risoluzione marcatori merge PHP"
type: story
status: done
module: Geo
created: 2026-11-26
updated: 2026-11-26
tags: [geo, merge, conflict, osm-proxy, coordinate-picker]
qmd: "geo php merge conflict comune coordinate picker osm"
related:
  - ../geo-sync-marker-repair.md
  - ../adr/osm-proxy-tile-nominatim.md
  - ../adr/geocoding-preferred-provider-with-fallback.md
---

# Geo — risoluzione marcatori merge PHP

## Perché

Il sync con `laraxot/dev` ha lasciato `<<<<<<<` in PHP sotto `Modules/Geo`. `Comune.php` non passava `php -l`.
Senza merge semantico si rischia di ripristinare chiamate Nominatim dal browser o di perdere i gruppi invarianti del proxy OSM.

## Cosa

- 22 file PHP con marker → 0 marker; `php -l` OK su tutti i file toccati (critico: `app/Models/Comune.php`).
- Trait picker = wrapper su `CoordinatePickerHelpers`; Actions Bing/Google con validazione coordinate / API key.
- Test proxy e geocode: gruppi `GEO-*-INV-*` tenuti.
- Docs: aggiornato [geo-sync-marker-repair.md](../geo-sync-marker-repair.md); ADR OSM senza marker.

## Non fatto (debito)

- `CoordinatePickerHelpers` → ancora HTTP diretto a Nominatim (server Filament). Passaggio a `QueryNominatimAction` fuori scope merge.
- Marker residui possibili in `docs/*.md` (README/CHANGELOG/index): fuori scope missione PHP.
- Nessun commit (richiesta esplicita).
