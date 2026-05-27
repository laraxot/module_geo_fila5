---
title: "Disciplina Dependabot — mono, moduli, temi"
type: how-to
status: approved
tags: [dependabot, dependencies, ci, security]
created: "2026-05-26"
updated: "2026-05-26"
qmd: "dependabot security alerts laraxot module_fila5 npm vite"
related:
  - "../memories/dependabot-check-discipline.md"
  - "../rules/00-TRIGGER_MAP.md"
  - "../../../laravel/Modules/Xot/docs/ci/github-actions-modules.md"
issue: "https://github.com/provtv/base_ptv_fila5_mono/issues/155"
---

# Dependabot — cosa controllare

## Scopo

La sicurezza dipende da **due piani**:

1. **Monorepo** `provtv/base_ptv_fila5_mono` — composer/actions in `.github/dependabot.yml`.
2. **Repo modulo pubblicato** `laraxot/module_<nome>_fila5` — qui girano **alert Security** e PR `app/dependabot` (es. [DbForge alert #1 vite](https://github.com/laraxot/module_dbforge_fila5/security/dependabot/1)).

Il mono **non basta**: dopo merge PR su GitHub modulo, **sync subtree** e allineare `package.json` / `composer.lock` locali.

## Checklist obbligatoria (agente)

```bash
# 1) Alert SECURITY su tutti i repo laraxot/module_* (priorità massima)
bashscripts/ci/dependabot-security-repos.sh

# 2) Config + Actions obsolete nel workspace
bashscripts/ci/dependabot-sweep.sh

# 3) PR Dependabot mono
gh pr list --repo provtv/base_ptv_fila5_mono --author "app/dependabot" --state open

# 4) PR su singolo modulo (esempio DbForge)
gh pr list --repo laraxot/module_dbforge_fila5 --author "app/dependabot" --state open

# 5) Merge autonomo agente (sweep tutti i moduli/temi con remote laraxot)
bashscripts/ci/dependabot-merge-module-prs.sh
```

Vedi [`module-theme-dependabot-pr-autonomy.md`](module-theme-dependabot-pr-autonomy.md) — l’agente **non** delega all’utente le PR su `laraxot/module_*`.

## Workflow alert → fix

| Step | Azione |
|------|--------|
| 1 | Aprire `https://github.com/laraxot/module_<modulo>_fila5/security/dependabot` |
| 2 | Merge PR Dependabot **o** bump manuale allineato al default branch remoto |
| 3 | In mono: aggiornare `laravel/Modules/<Modulo>/package.json` (e lock se presente) |
| 4 | `composer audit` nel modulo; build vite se c’è `package.json` |
| 5 | Push subtree verso `laraxot/module_*` → verificare alert **chiuso** |

## Caso DbForge (vite)

- Alert: vite 4.x → advisory medium su `package.json`.
- PR merged su remote: `vite@^8.0.8`, `laravel-vite-plugin@^3.0.1`.
- Mono deve riflettere lo stesso prima del push subtree.

## Template Dependabot modulo

| File | Uso |
|------|-----|
| `.github/templates/dependabot-module.yml` | composer + github-actions |
| `.github/templates/dependabot-module-npm-snippet.yml` | aggiungere se esiste `package.json` |
| `.github/templates/dependabot-theme.yml` | temi |

Moduli con `package.json` **devono** avere ecosystem **npm** in `.github/dependabot.yml`.

## Dubbi

- Alert ancora OPEN dopo merge PR: default branch remoto ≠ mono locale → sync mancante.
- ~~`Theme_One/` vs `Themes/One/`: repo tema separato se pubblicato.~~ — risolto 2026-05-26: `Theme_One/` rinominato in `Three/` (doc-only, no composer/package separato).

## Issue

[#155](https://github.com/provtv/base_ptv_fila5_mono/issues/155)
