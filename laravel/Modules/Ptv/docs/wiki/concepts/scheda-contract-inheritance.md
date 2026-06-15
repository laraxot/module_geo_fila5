---
title: "Ereditarietà SchedaContract su BaseScheda"
type: concept
tags: [ptv, scheda, contract, inheritance, architecture]
created: 2026-06-15
updated: 2026-06-15
qmd: "Ptv BaseScheda SchedaContract implements figlio extends gerarchia"
related:
  - ../../../../../../docs/wiki/rules/module-hierarchy-inheritance-pattern.md
  - ./phpstan-scheda-actions.md
  - ../log.md
---

# Ereditarietà SchedaContract su BaseScheda

## Scopo

Il modulo **Ptv** possiede la gerarchia scheda condivisa: contratto, relazioni Sigma (`asz()`), campi comuni. I moduli dominio (**Progressioni**, futuro **Legge104**) estendono `BaseScheda` senza ripetere `implements SchedaContract`.

## Regola

| Layer | Dichiarazione |
|-------|----------------|
| `SchedaContract` | interface in `Ptv\Models\Contracts` |
| `BaseScheda` | `implements SchedaContract` + `asz()` |
| `Progressioni\Scheda` | `extends BaseScheda` **solo** |

## Perché (business + zen)

- **Un punto di verità** per filtri anagrafici e type-hint action
- **Meno rumore** in review e PHPStan
- **Coerenza** con [eloquent-relationship-encapsulation](../../../../../../docs/wiki/rules/eloquent-relationship-encapsulation.md)

## Audit

```bash
bash bashscripts/tools/audit-scheda-contract-inheritance.sh
```

## Pending

`Legge104\Models\Scheda` → migrare a `extends BaseScheda` (STORY-002 Phase 3).
