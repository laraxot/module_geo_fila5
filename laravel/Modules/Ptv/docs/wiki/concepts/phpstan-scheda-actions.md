---
title: "PHPStan e action su schede Ptv"
type: concept
tags: [ptv, phpstan, scheda, performance, eloquent]
created: 2026-06-15
updated: 2026-06-15
qmd: "Ptv PHPStan Scheda EloquentModelResolver BaseScheda Performance"
related:
  - ../../../../../docs/wiki/patterns/phpstan-optional-contracts.md
  - ../log.md
  - ./second-brain-local-discipline.md
---

# PHPStan e action su schede Ptv

## Scopo business

Il modulo **Ptv** gestisce schede valutazione/performance collegate a **Sigma** (anagrafiche) e **Performance** (organizzativa, fondi, quote). Le action in `app/Actions/Scheda/` eseguono aggiornamenti SQL batch su tabelle anno/type (quote teoriche, resti, budget, giorni presenza).

## Ingresso PHPStan (2026-06-15)

Primo scan con `Ptv` in scope `phpstan analyse Modules`: ~145 errori → **0** dopo fix forward-only.

## Pattern applicati

### 1. `EloquentModelResolver`

Action generiche ricevono `class-string<Model>` (es. `Organizzativa`). Prima usavano `app($class)` senza narrowing → `mixed`.

```php
$model = EloquentModelResolver::newInstance($class);
$conn = $model->getConnection();
```

File: `app/Support/EloquentModelResolver.php`.

### 2. Contratti scheda con `@phpstan-require-extends Model`

`SchedaContract` espone `@property` relazione (`criteriEsclusione`, `asz`, …) consumate da `BaseSchedaResource` e action criteri esclusione.

### 3. Modulo Performance opzionale nel mono

- `BaseScheda::performanceIndividuale()` punta a `Modules\Performance\Models\Individuale` (classe reale), non `Performance` (inesistente).
- Modulo Performance resta in `excludePaths` PHPStan ma le classi esistono in filesystem per runtime.

### 4. Activity log

`LogsActivity` commentato su `BaseScheda`; rimosso `getActivitylogOptions()` perché `spatie/laravel-activitylog` non è in vendor.

### 5. Relazioni Eloquent (regola cardinale)

PHPStan **non** giustifica bypass delle relazioni. Vedi root wiki:

- [eloquent-relationship-encapsulation.md](../../../../../docs/wiki/rules/eloquent-relationship-encapsulation.md)
- [scheda-asz-relationship-query.md](../../../../../docs/wiki/patterns/scheda-asz-relationship-query.md)

## Action ad alto impatto (per audit futuro)

| Action | Scopo |
|--------|-------|
| `UpdateQuotaTeoricaAction` | Ricalcolo quote teoriche da giorni presenza e coeff categorie |
| `UpdateRestiPondByValutatoreIdAction` | Aggiorna resti ponderati per valutatore |
| `CheckValutatoreAction` | Validazione coerenza valutatore su scheda |
| `ListaAszTipCodEsclusoSubito` | Criteri esclusione ASZ — **`$scheda->asz()->ofRangeDate()`** (mai `Asz00k1::query()`) |

## Verifica

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Ptv
cd laravel && ./vendor/bin/phpstan analyse Modules   # gate completo moduli in scope
```
