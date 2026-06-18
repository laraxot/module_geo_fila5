---
title: "Bugfix: business logic prima del tipo"
type: pattern
tags: [bugfix, business-logic, type-safety, eloquent, second-brain]
created: 2026-06-18
updated: 2026-06-18
qmd: "bugfix business logic before type error relation builder alternative paths"
related:
  - ../second-brain/bugfix-business-logic-before-type.md
  - ./phpstan-error-resolution-guide.md
  - ../../laravel/Modules/Sigma/docs/wiki/concepts/function-extra-relation-query-pattern.md
  - ../../laravel/Modules/Ptv/docs/wiki/concepts/trova-esclusi-gg-cascade.md
  - ../../laravel/Modules/Xot/docs/wiki/concepts/agent-confidence-discipline.md
---

# Bugfix: business logic prima del tipo

## Scopo

Un `TypeError` o un errore PHPStan non è il problema: è un sintomo. Prima di patchare firme o cast, l'agente deve capire **cosa fa** il codice, **perché** esiste e **quale percorso** preserva la logica di dominio.

## Metodo (obbligatorio)

1. **Traccia la catena** — chi chiama chi, quale dato di dominio serve (es. giorni presenza, criterio esclusione).
2. **Leggi i vincoli impliciti** — relazioni Eloquent (`ente`+`matr`), scope anno, filtri `propro`/`posfun`.
3. **Elenca percorsi possibili** — non solo quello che fa sparire l'errore.
4. **Scarta i percorsi che rompono il dominio** — anche se PHPStan o il runtime sono contenti.
5. **Scegli il fix minimo** coerente col design esistente nel file/modulo.
6. **Documenta** decisione + percorsi scartati nella wiki del modulo owner.

## Anti-pattern

| Tentazione | Perché è pericoloso |
|------------|---------------------|
| Allargare solo il type hint | Può mascherare un metodo concettualmente sbagliato |
| `->getQuery()` sulla relazione per ottenere `Builder` | Perde vincoli FK della `HasMany` (`ente`+`matr`) |
| Duplicare filtri in un'Action | Viola encapsulation relazione (vedi regola Ptv su `asz()`) |
| `@phpstan-ignore` senza analisi | Debito permanente, nessuna memoria per sessioni future |

## Pattern Eloquent correlato

Query su dati del dipendente → partire dalla **relazione** (`$model->qua00f()`), non da `Qua00f::query()`.

Helper privati che applicano `where`/`selectRaw` devono accettare `Builder|Relation` se i chiamanti passano relazioni — coerenza già usata in `FunctionExtra` per `applyQua00fCoalesceTotSelect`.

## Caso di riferimento (2026-06-18)

**Errore:** `applyQua00fProproFilters(Builder $qua00f)` riceveva `HasMany` da `ggInSedeTot()`.

**Catena business:** Trova esclusi → `gg_cateco_posfun_no_asz` → `gg_cateco_posfun` − assenze → `Anag::ggInSedeTot()` su `qua00f`.

**Percorso scelto:** `Builder|Relation` su `applyQua00fProproFilters` — allineamento ai metodi gemelli, vincolo FK preservato.

**Percorsi migliori a lungo termine (non nel fix immediato):**

- Action/query object dedicato (`GgInSedeTotQuery`) — testabilità
- Relazioni scoped (`qua00fForGgFilter`) — DRY encapsulation
- Batch + eager loading in Trova esclusi — performance N+1

Dettaglio: [function-extra-relation-query-pattern](../../laravel/Modules/Sigma/docs/wiki/concepts/function-extra-relation-query-pattern.md).

## Collegamenti

- [agent-confidence-discipline](../../laravel/Modules/Xot/docs/wiki/concepts/agent-confidence-discipline.md)
- [trova-esclusi-gg-cascade](../../laravel/Modules/Ptv/docs/wiki/concepts/trova-esclusi-gg-cascade.md)
- [phpstan-error-resolution-guide](./phpstan-error-resolution-guide.md)
