---
title: Validation Scripts
description: Script di validazione per pattern architetturali e controlli PHPStan
tags: [validation, scripts, bash, phpstan]
updated: 2026-06-15
---

# Validation Scripts

## audit-scheda-contract-inheritance.sh

Verifica gerarchia Scheda / SchedaContract:

- `BaseScheda` implementa `SchedaContract` (unico file nel monorepo)
- Nessun figlio `extends BaseScheda implements SchedaContract`
- Nessun `ProgressioneSchedaContract` in PHP
- `Progressioni\Scheda extends BaseScheda`

```bash
bash bashscripts/tools/audit-scheda-contract-inheritance.sh
```

## audit-eloquent-relationship-duplication.sh

Verifica che le action non duplichino filtri già presenti nelle relazioni Eloquent.

```bash
bash bashscripts/tools/audit-eloquent-relationship-duplication.sh
```

Canon: [eloquent-relationship-encapsulation.md](../rules/eloquent-relationship-encapsulation.md)
