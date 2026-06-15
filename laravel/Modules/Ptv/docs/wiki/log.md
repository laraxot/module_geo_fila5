---
title: "Activity Log"
module: "Ptv"
---

# Activity Log — Ptv

> **Purpose:** Append-only chronological activity record tracking ingests, queries, and lint passes.

## Log Entries

### 2026-06-15 — PHPStan livello max (modulo Ptv)

- **Prima:** ~133 errori PHPStan su `Modules/Ptv` (primo ingresso in scope `phpstan analyse Modules`).
- **Dopo:** 0 errori su `Modules/Ptv` e `Modules` intero.
- **Pattern applicati:**
   - `SchedaContract`: `@phpstan-require-extends Model`, `@mixin \Eloquent`, proprietà relazione documentate (`asz`).
   - `ProgressioneSchedaContract`: **rimosso** (2026-06-15) — superfluo, Scheda estende BaseScheda che implementa SchedaContract.
  - `EloquentModelResolver`: narrowing `class-string<Model>` per action generiche su schede Performance.
  - `BaseScheda::performanceIndividuale()`: relazione verso `Modules\Performance\Models\Individuale` (classe `Performance` inesistente).
  - Rimosso `getActivitylogOptions()` da `BaseScheda` (trait `LogsActivity` disabilitato, pacchetto activitylog assente in vendor).
  - `SchedaContract`: `@method asz()` + `BaseScheda::asz()` — unico contratto (ProgressioneSchedaContract eliminato).
  - `ListaAszTipCodEsclusoSubito`: `$scheda->asz()->ofRangeDate()` con type-hint `SchedaContract`.
  - `Check::execute()`: parametro `$criteriEsclusione` come `iterable<int, Model>` per compatibilità Eloquent Collection cross-modulo (covarianza template).
- **Riferimenti:** [phpstan-optional-contracts](../../../../docs/wiki/patterns/phpstan-optional-contracts.md)


### Format

```
[YYYY-MM-DD HH:MM:SS UTC] [OPERATION] Description
```

**Operations:**
- `INGEST` — Added raw document to wiki
- `QUERY` — Answered question from wiki
- `LINT` — Maintained wiki quality
- `UPDATE` — Modified existing wiki page

---

**Last Activity:** 2026-06-15 — PHPStan Ptv remediation  
**Total Operations:** 1
