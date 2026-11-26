---
title: "Geo — risoluzione marcatori merge PHP"
type: story
status: done
module: Geo
created: 2026-11-26
updated: 2026-11-26
tags: [geo, merge, conflict, osm-proxy, coordinate-picker, phpstan]
qmd: "geo php merge conflict comune coordinate picker osm"
related:
  - ../geo-sync-marker-repair.md
  - ../adr/0003-osm-proxy-tile-nominatim.md
  - ../adr/0002-geocoding-preferred-provider-with-fallback.md
  - ./phpstan-cleanup-geo.story.md
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

## Follow-up PHPStan HasCoordinatePicker (2026-11-26)

Root cause: PHPStan L10 perde `missingType.iterableValue` sui metodi array del trait «in context of class» (×9 componenti).

Fix (ponytail):
- Interfaccia già presente `Contracts/CoordinatePickerArrayShapes` (non creato `CoordinatePickerApi` duplicato).
- I 9 picker implementano l'interfaccia.
- `mapDefaultViewInput` → `CoordinatePickerHelpers` (privato sul trait: l'interfaccia non copre).
- `MapPickerTest`: `assertIsArray` + `@var array<string, mixed>` prima degli offset.
- `XotBaseCoordinateField`: già documentato, PHPStan non segnalava → non toccato.

Verifica: `analyse Modules/Geo` → `[OK] No errors`.

## Non fatto (debito)

- `CoordinatePickerHelpers` → ancora HTTP diretto a Nominatim (server Filament). Passaggio a `QueryNominatimAction` fuori scope merge.
- Marker residui possibili in `docs/*.md` (README/CHANGELOG/index): fuori scope missione PHP.
- Nessun commit (richiesta esplicita).
