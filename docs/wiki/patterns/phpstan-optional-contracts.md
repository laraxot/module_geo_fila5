---
title: "PHPStan Optional Contracts"
type: pattern
tags: [phpstan, contracts, modules, eloquent, larastan]
created: 2026-06-15
updated: 2026-06-15
qmd: "phpstan optional module contracts larastan eloquent relation generic this"
issues:
  - "https://github.com/provtv/base_ptv_fila5_mono/issues/136"
  - "https://github.com/laraxot/module_ui_fila5/issues/5"
  - "https://github.com/laraxot/module_user_fila5/issues/27"
related:
  - "../memories/phpstan-modules-inventory.md"
  - "../../../laravel/Modules/User/docs/wiki/concepts/no-comment-module-dependency.md"
  - "../../../laravel/Modules/UI/docs/wiki/concepts/phpstan-dynamic-array-normalization.md"
---

# PHPStan Optional Contracts

> Pattern operativo per riportare PHPStan a zero quando un modulo punta a classi opzionali o a generic Eloquent non coerenti.

## Regola

Non importare classi di moduli assenti solo per far compilare il consumer.

Usare invece:

- un contratto locale nel modulo owner della feature UI;
- una action locale che delega al modulo opzionale solo se la classe esiste;
- PHPDoc Eloquent con declaring model `$this` quando la relazione nasce da trait/base model.

## Applicazione

- `UI`: `InteractiveMap` dipende da `MapServiceContract` e `GeocodingServiceContract`, non da `Modules\Geo\Services\*` assenti.
- `UI`: `ResolveLocalizedBlockDataAction` delega al modulo `Cms` solo se disponibile.
- `User`: `CanComment` non vive in `User`; il modulo `User` non dipende da `Comment`.
- `Xot`: `HasRelationshipModelClass` separa `getModelClass()` per RelationManager/ManageRelatedRecords da `HasXotTable`.
- `Ptv`: `EloquentModelResolver` + contratti scheda `@phpstan-require-extends Model` per action generiche su Performance.
- `Progressioni`: `Assert::subclassOf` su `hasMany` dinamici; `Assenza` (non `Assenze`); **`$scheda->asz()->ofRangeDate()`** nelle action (mai query manuale ASZ); helper `getRouteParameters()` in Xot.

## Verifica

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules
```

Risultato atteso: `No errors`.
