---
title: "Activity Log"
module: "Sigma"
---

# Activity Log — Sigma

> **Purpose:** Append-only chronological activity record tracking ingests, queries, and lint passes.

## Log Entries

[2026-06-15] [UPDATE] `SigmaEnteMatrFields`: `matrField()`/`enteField()` + helper `hasManyByEnteMatr`/`hasOneByEnteMatr`. Vedi [ente-matr-field-ownership](./concepts/ente-matr-field-ownership.md).

[2026-06-15] [UPDATE] `Sto00f extends BaseDateRangeModel` — `st2kas`/`st2kdi`/`stann`; no `BaseDateRangeModelCarbon`. Vedi [sto00f-date-range](./concepts/sto00f-date-range.md).

[2026-06-15] [LINT] Regola CARDINAL documentata: `.cursor/rules/eloquent-basemodel-hierarchy.mdc`, memoria wiki, audit `audit-eloquent-basemodel-hierarchy.sh` (rg). `Qua00f extends BaseDateRangeModel` confermato.

[2026-06-15] [UPDATE] Ereditarietà modelli: zero `extends Model`; `BaseDateRangeModel implements Models\Contracts\SigmaDateRangeFields`; `Asz00k1`, `Asz00f`, `Qua00f`, `Qua03f`, `Rep00f` estendono il base senza ripetere `implements`. Vedi [sigma-model-inheritance](./concepts/sigma-model-inheritance.md).

[2026-06-15] [UPDATE] `Sto00f extends BaseDateRangeModel` — `st2kas`/`st2kdi`/`stann`; no `BaseDateRangeModelCarbon`. Vedi [sto00f-date-range](./concepts/sto00f-date-range.md).

[2026-06-15] [LINT] Gate PHPStan livello max su `Modules/Sigma`: 0 errori. Pattern: `whereRaw` con binding `?`, `selectRaw` letterale per aggregati gg.

[2026-06-15] [UPDATE] Architettura `CommonScope`: `rangeFromField` / `rangeToField` / `annFieldName` **abstract** nel trait, implementati su ogni modello (no `match(static::class)`). Vedi [common-scope-date-range-ownership](./concepts/common-scope-date-range-ownership.md).

[2026-06-15] [UPDATE] `Sto00f extends BaseDateRangeModel`: aggiunti `rangeFromField()='st2kas'`, `rangeToField()='st2kdi'`, `annFieldName()='stann'`; rimossi `scopeOfYear`/`scopeOfEnteYear` override (forniti da `CommonScope`). Aggiornati docs `architecture.md`, `sigma-model-inheritance.md`, `common-scope-date-range-ownership.md`, `basemodel-hierarchy.md`.

[2026-06-15] [FIX] `Qua00f`/`Rep00f`: rimosso `implements Contracts\SigmaDateRangeFields` ridondante (già su `BaseDateRangeModel`). Nuova regola: [contract-inheritance-no-redeclare](./rules/contract-inheritance-no-redeclare.md). Vedi anche [sigma-model-inheritance](../concepts/sigma-model-inheritance.md).

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

**Last Activity:** 2026-06-15 — PHPStan Sigma 0 errori  
**Total Operations:** 1
