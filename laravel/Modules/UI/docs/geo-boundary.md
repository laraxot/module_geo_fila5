---
title: "Confine UI e Geo"
type: rule
module: UI
created: 2026-07-06
updated: 2026-07-08
---

# Confine UI e Geo

## Regola

Il modulo `UI` non deve dipendere dal modulo `Geo`.

`UI` fornisce componenti visuali generici e riusabili. La logica geografica, mappe interattive, geocoding, marker, export GeoJSON/KML e integrazioni GIS appartengono al dominio `Geo`.

## Dipendenze consentite

- `Geo` puo' dipendere da `UI` per usare primitive visuali.
- `UI` non deve importare namespace `Modules\Geo\*`.
- `UI` non deve contenere service geografici, geocoder o map service.
- Componenti con dominio geografico vanno rimossi dall'autoload PHP (o backup locale `.old`, gitignored).

## Caso LocationSelector

`app/Filament/Forms/Components/LocationSelector.php` non appartiene a `UI` (importa `Modules\Geo\Models\Comune`).

Rimosso dal repo il 2026-07-08; backup locale opzionale `LocationSelector.php.old` (`*.old` in `.gitignore`).

Se servira' un selettore geografico, crearlo in `Modules/Geo/` usando contratti UI o primitive generiche.

## Caso InteractiveMap

`app/Livewire/Components/Map/InteractiveMap.php` non appartiene a `UI`.

Rimosso dal repo il 2026-07-08; backup locale opzionale `InteractiveMap.php.old` (`*.old` in `.gitignore`).

Non riattivarlo in `UI`. Se in futuro servira' una mappa, crearla nel modulo `Geo` e usare eventuali componenti UI solo come base visuale.

## Motivazione

Questa separazione evita dipendenze inverse, classi mancanti e accoppiamento tra design system e dominio geografico.

## Verifica

```bash
grep -r "Modules\\\\Geo" app/ --include="*.php" | grep -v '\.old' | grep -v '\.to_geo'
test ! -f app/Livewire/Components/Map/InteractiveMap.php
test ! -f app/Filament/Forms/Components/LocationSelector.php
```
