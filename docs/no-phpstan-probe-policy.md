---
title: "no phpstan probe policy"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "no phpstan probe policy"
issues: []
discussions: []
description: Divieto di creare cartelle o file probe per PHPStan in questo modulo.
---

# No PHPStan probe files in Geo

## Regola

Nel modulo `Geo` non devono esistere:

- directory `app/Phpstan`
- file che finiscono per `PhpstanProbeModel.php`
- file che finiscono per `PhpstanTraitProbe.php` o nomi simili (probe fittizi)

## Perché

Questi file sono modelli o classi artificiali create solo per far passare PHPStan.
Se un trait risulta non usato: **wiring su un modello reale** (es. `GeoTrait` →
`Address`) oppure eliminazione se dead. Vietato `@phpstan-ignore trait.unused` e
vietati i probe. Se un test deve esercitare un trait, si usa una fixture reale
collegata a un test Pest esistente (non un probe).

Il ragionamento completo (logica/politica/filosofia/religione/zen di questo divieto) è
in `Modules/Xot/docs/wiki/concepts/phpstan-trait-probes.md`.

## Storico (2026-07-27)

Rimossi in questo modulo:

- `app/Phpstan/TraitProbes.php` (e la cartella `app/Phpstan/`);
- `tests/Fixtures/Traits/{GeoPhpstanProbeModel,GeoTraitPhpstanProbe,HasAddressesPhpstanProbe,HasPlaceTraitPhpstanProbe,GeographicalScopesPhpstanProbe,SushiToJsonsPhpstanProbe,GeoPhpstanTraitProbes}.php`;
- l'intera cartella duplicata a solo case diverso `tests/fixtures/traits/` (sintomo di
  scaffolding non governato che si era già biforcato).

Storico 2026-07-27: era stato aggiunto `@phpstan-ignore trait.unused` su trait
senza consumer. **2026-09-24**: `GeoTrait` wired su `Address` (solo distanza/scope);
`HasAddress` resta usato dalla fixture `HasAddressTestModel` — ignore sullo
`scopeInCity` rimosso (`Builder<TModel>`). Trait dead eliminati (niente probe):
`GeographicalScopes` (superseded da `GeoTrait`), `HasAddresses` (duplicato di
`HasAddress`), `Models\Traits\SushiToJsons` (nessun consumer Geo; Tenant ha il
suo).

## Regressione (rilevata 2026-10-06)

I commit `af8982cb` (2026-09-25) e `dd55f6dd` (2026-09-26) hanno riportato nel
modulo quello che le sezioni sopra avevano tolto. Stato trovato su `dev`:

- probe tornati in `tests/Fixtures/Traits/`: `GeoPhpstanProbeModel`,
  `GeoTraitPhpstanProbe`, `HasPlaceTraitPhpstanProbe`, e tre che usano trait
  eliminati e quindi non si caricano (`GeographicalScopesPhpstanProbe`,
  `HasAddressesPhpstanProbe`, `SushiToJsonsPhpstanProbe`), più
  `HasAddressesTestModel` (fixture del trait `HasAddresses` eliminato);
- `tests/Unit/Traits/HasAddressTest.php` e `TestModel.php` sovrascritti con due
  copie del modello fixture al posto del test Pest;
- `HasAddressTestModel` senza `@use HasAddress<HasAddressTestModel>`.

Ripristinati il 2026-10-06: il test Pest in `HasAddressTest.php` e il `@use`
sulla fixture. Rimossi lo stesso giorno i cinque file che non si caricavano o
duplicavano un consumer reale (`GeoTraitPhpstanProbe`, `GeographicalScopesPhpstanProbe`,
`HasAddressesPhpstanProbe`, `HasAddressesTestModel`, `SushiToJsonsPhpstanProbe`)
e `tests/Unit/Traits/TestModel.php`, senza riferimenti. PHPStan `Modules`: 0 errori.

**Decisione aperta su `HasPlaceTrait`**: nessun modello lo usa, l'unico consumer
è `HasPlaceTraitPhpstanProbe` (con la sua base `GeoPhpstanProbeModel`). Togliere
il probe fa emergere `trait.unused`; le alternative ammesse da questa policy sono
collegarlo a un modello reale o eliminare il trait.

`tests/Fixtures/Traits/HasAddressTestModel.php` **non** è un probe: è la fixture reale
usata da `tests/Unit/Traits/HasAddressTest.php` ed è stata mantenuta.

## Riferimento

Vedi anche:

- `bashscripts/ai/wiki/rules/no-phpstan-probe-models.md`
- `Modules/Xot/docs/phpstan-modules-fix-log.md`
