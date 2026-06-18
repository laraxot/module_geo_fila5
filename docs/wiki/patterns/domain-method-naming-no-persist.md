---
title: "naming metodi dominio — vietato persist*"
type: rule
tags: [naming, eloquent, agent, dry]
created: 2026-06-18
updated: 2026-06-18
related:
  - ../../laravel/Modules/Ptv/docs/wiki/concepts/check-criteri-esclusione.md
  - ../how-to/github-issue-agent-discipline.md
---

# Naming metodi dominio — vietato `persist*`

## Regola agente

**Non** introdurre metodi su model/contratti dominio con prefisso `persist*` (es. `persistCriteriEsclusioneEsito`).

| Usare | Evitare |
|-------|---------|
| `update()` / `save()` nell'action con guard su `$fillable` | `persist*` wrapper sul modello |
| `get*ByYear` per lettura batch | `load*ForYear` |
| `SchedaContract` nelle action scheda | `Model` generico / `BaseScheda` diretto |

**Eccezione:** API framework (Filament `persistFiltersInSession`, `persistStepInQueryString`) — non è dominio Ptv.

## Mass assignment

Prima di `update([...])` su campi business:

1. verificare che ogni chiave sia in `$fillable` del modello concreto;
2. **fail-fast** (`InvalidArgumentException`) se manca;
3. assicurarsi che il modello consumer includa i campi in `$fillable`, non solo in `$xls_fields` o regole `validate()`.

Pattern: `Check::assertAttributesAreFillable()` in `Modules/Ptv/app/Actions/CriteriEsclusione/Check.php`.

## Collegamenti

- [check criteri esclusione](../../laravel/Modules/Ptv/docs/wiki/concepts/check-criteri-esclusione.md)
- [getter ByYear](../../laravel/Modules/Ptv/docs/wiki/concepts/getter-by-year-naming.md)
