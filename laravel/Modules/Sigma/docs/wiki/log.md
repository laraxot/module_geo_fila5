---
title: "Activity Log"
module: "Sigma"
---

# Activity Log — Sigma

> **Purpose:** Append-only chronological activity record tracking ingests, queries, and lint passes.

## Log Entries

[2026-06-15] [UPDATE] Ereditarietà modelli: zero `extends Model`; `BaseDateRangeModel implements Models\Contracts\SigmaDateRangeFields` per `Asz00k1`, `Asz00f`, `Qua00f`, `Qua03f`, `Rep00f`. Vedi [sigma-model-inheritance](./concepts/sigma-model-inheritance.md).

[2026-06-15] [LINT] Gate PHPStan livello max su `Modules/Sigma`: 0 errori. Pattern: `whereRaw` con binding `?`, `selectRaw` letterale per aggregati gg.

[2026-06-15] [UPDATE] Architettura `CommonScope`: `rangeFromField` / `rangeToField` / `annFieldName` **abstract** nel trait, implementati su ogni modello (no `match(static::class)`). Vedi [common-scope-date-range-ownership](./concepts/common-scope-date-range-ownership.md).

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
