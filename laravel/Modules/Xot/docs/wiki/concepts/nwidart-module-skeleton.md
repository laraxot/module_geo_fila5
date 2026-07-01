---
title: Skeleton nwidart modulo
type: concept
module: Xot
tags: [nwidart, skeleton, module, guardrail]
created: 2026-07-01
updated: 2026-07-01
related:
  - ../../../../docs/wiki/concepts/nwidart-module-skeleton-contract.md
  - ./sacred-artifacts-never-delete.md
---

# Skeleton nwidart modulo

Xot è il modulo base Laraxot: la regola skeleton vale per **tutti** i moduli, non solo Xot.

## File non negoziabili

Vedi hub repo: [nwidart-module-skeleton-contract.md](../../../../docs/wiki/concepts/nwidart-module-skeleton-contract.md)

## Guard e restore

```bash
bash bashscripts/tools/guard-nwidart-module-skeleton.sh
bash bashscripts/tools/restore-nwidart-deleted-files.sh Xot
```

## Ponytail

Gli script `ponytail-wave5-archive.sh` e `ponytail-purge-bak-files.sh` rifiutano o verificano path protetti. Non archiviare mai `composer.json`, `module.json`, `package.json`, `.github/`, `*ServiceProvider.php`.

## Incidente 2026-07-01

Provider e `.github` eliminati per errore durante audit → ripristinati da `git checkout HEAD -- laravel/Modules/{Modulo}`.
