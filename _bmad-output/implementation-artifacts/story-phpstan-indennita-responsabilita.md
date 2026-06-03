---
title: "PHPStan zero — IndennitaResponsabilita"
type: story
status: in-progress
agent: Bob (SM)
created: 2026-05-27
ac:
  - PHPStan 0 errori (level max)
  - Issue GitHub chiusa con [OK] No errors
  - Inventario wiki aggiornato
---

# Story: PHPStan zero — IndennitaResponsabilita

## Context
Risoluzione di 33 errori PHPStan rilevati nel modulo IndennitaResponsabilita.

## Acceptance Criteria
- [ ] `./vendor/bin/phpstan analyse Modules/IndennitaResponsabilita --memory-limit=2G` restituisce 0 errori.
- [ ] Issue GitHub creata nel repository del modulo.
- [ ] Fix applicati seguendo i pattern Laraxot (no @phpstan-ignore).
- [ ] Documentazione modulo aggiornata in `docs/phpstan-analysis.md`.
- [ ] Inventario wiki aggiornato in `docs/wiki/memories/phpstan-modules-inventory.md`.

## Tasks
1. [ ] Creare issue GitHub.
2. [ ] Risolvere errori `theCodingMachineSafe.function` in `UpdateModuleDocumentation.php`.
3. [ ] Risolvere errori interface/property in `DatiSalvati.php`.
4. [ ] Risolvere class.notFound in `ProgressIndicator.php`.
5. [ ] Risolvere return.type in Resources.
6. [ ] Risolvere whereRaw literal-string errors.
