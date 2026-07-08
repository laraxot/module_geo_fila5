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
- Componenti con dominio geografico vanno spostati o disattivati fuori dall'autoload PHP.

## Caso LocationSelector

`app/Filament/Forms/Components/LocationSelector.php` non appartiene a `UI` (importa `Modules\Geo\Models\Comune`).

Rinominato `.old` il 2026-07-08. Se servira' un selettore geografico, crearlo in `Modules/Geo/` usando contratti UI o primitive generiche.

## Caso InteractiveMap

`app/Livewire/Components/Map/InteractiveMap.php` non appartiene a `UI`.

Rinominato `.old` il 2026-07-08 (era riapparso come `.php` attivo). Nel progetto corrente il modulo `Geo` non e' necessario, quindi il componente resta disattivato come:

```text
app/Livewire/Components/Map/InteractiveMap.php.old
```

Non riattivarlo in `UI`. Se in futuro servira' una mappa, crearla nel modulo `Geo` e usare eventuali componenti UI solo come base visuale.

## Motivazione

Questa separazione evita dipendenze inverse, classi mancanti e accoppiamento tra design system e dominio geografico.

## 2026-07-08 PHPStan

`InteractiveMap.php` e la view Blade collegata sono stati rinominati `.old`: `UI` non deve importare `Modules\Geo\*` né tenere componenti geografici in autoload.
