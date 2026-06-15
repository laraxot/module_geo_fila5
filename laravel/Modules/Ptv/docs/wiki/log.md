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
  - `SchedaContract` / `ProgressioneSchedaContract`: `@phpstan-require-extends Model`, `@mixin \Eloquent`, proprietà relazione documentate.
  - `EloquentModelResolver`: narrowing `class-string<Model>` per action generiche su schede Performance.
  - `BaseScheda::performanceIndividuale()`: relazione verso `Modules\Performance\Models\Individuale` (classe `Performance` inesistente).
  - Rimosso `getActivitylogOptions()` da `BaseScheda` (trait `LogsActivity` disabilitato, pacchetto activitylog assente in vendor).
  - `ListaAszTipCodEsclusoSubito`: query diretta su `Asz00k1` con `ofRangeDate` invece di scope su `HasMany` non tipizzato.
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

**Last Activity:** None  
**Total Operations:** 0
