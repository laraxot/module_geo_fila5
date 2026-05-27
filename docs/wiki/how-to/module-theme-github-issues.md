---
title: issue GitHub moduli e temi
type: guide
tags: [github, modules, themes, phpstan, agents]
updated: 2026-05-26
related:
  - ../memories/module-github-remote-discipline.md
  - ../how-to/github-issue-agent-discipline.md
  - ../../chat/module-theme-github-issues-manifest.md
---

# Issue GitHub — moduli e temi

## Scopo

Ogni modulo/tema con repo Git proprio deve avere issue di coordinamento con il monorepo (PHPStan, merge markers, ridondanza). **Non** indovinare l’org: leggere il remote.

## Trovare il repository

```bash
cd laravel/Modules/<Nome>    # oppure laravel/Themes/<Nome>
git remote -v
```

Usare `origin` (o il remote team) con `gh`:

```bash
REPO=$(git remote get-url origin | sed -E 's|.*github.com[:/]([^/]+/[^/.]+)(\.git)?|\1|')
gh issue list --repo "$REPO" --state open
```

**Notify:** in mono può non avere `origin` nel submodule — verificare prima di `gh`.

## Prototipo issue PHPStan

[`docs/wiki/_templates/phpstan-module-github-issue.md`](../_templates/phpstan-module-github-issue.md) — **una issue per modulo**, tutti gli errori nel corpo. Prompt agente: `bashscripts/tools/prompts/phpstan_module.txt`.

## PHPStan (da `laravel/`)

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/<Nome> --memory-limit=2G
```

## Titoli issue standard (2026-05-26)

| Tipo | Titolo |
|------|--------|
| Meta coordinamento | `[Meta] Coordinamento mono — PHPStan L10, merge markers, second brain` |
| Ridondanza | `[Discussione] Ridondanza codice e documentazione — DRY/KISS` |

**Eccezioni già popolate:** Job (#11–#14), Lang (#11–#12), Xot (#10 OPS) — commentare invece di duplicare.

## Firma obbligatoria su issue/commenti agente

```text
**Agente AI:** Auto (Cursor agent router)
**Modello:** Composer
```

## Mono vs modulo

| Scope | Dove `git remote -v` | Issue |
|-------|----------------------|--------|
| Progetto | root monorepo | `gh issue list` su remote root |
| Modulo/tema | `laravel/Modules/*` / `Themes/*` | remote del submodule |

Manifest batch sessione: [`module-theme-github-issues-manifest.md`](../../chat/module-theme-github-issues-manifest.md).

## Regole doc modulo

Nei file `laravel/Modules/*/docs/**` non linkare URL fissi `github.com/<org>/…` — solo `#numero` + istruzione `git remote -v` ([`module-github-remote-discipline.md`](../memories/module-github-remote-discipline.md)).
