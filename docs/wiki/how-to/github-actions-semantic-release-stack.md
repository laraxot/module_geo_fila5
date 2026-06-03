---
title: "GitHub Actions — stack semantic release monorepo"
type: how-to
tags: [github-actions, semantic-release, ci, changelog, monorepo]
module: ptvx-project
created: 2026-06-03
updated: 2026-06-03
qmd: "github actions semantic release auto release changelog module-release workflow_run"
related:
  - ../standards/module-theme-release-showcase-standard.md
  - ../../../.github/workflows/release.yml
  - ../../../.github/workflows/semantic-versioning.yml
  - ../../../.github/workflows/semantic-release.yml
  - ../../../.github/workflows/module-release.yml
---

# Stack semantic release (root `.github/workflows/`)

> I workflow **esistono nella root** del monorepo (`base_ptv_fila5_mono`). Ruoli separati per evitare doppi tag su ogni push.

## Mappa workflow

| File | Ruolo | Trigger |
|------|--------|---------|
| [release.yml](../../../.github/workflows/release.yml) | **Auto release** mono: `npx semantic-release`, tag, GitHub Release, `CHANGELOG.md` | `push` `main`/`master`, `workflow_dispatch` |
| [semantic-versioning.yml](../../../.github/workflows/semantic-versioning.yml) | Tag semver + attest (github-tag-action) | Solo `workflow_dispatch` / `repository_dispatch` |
| [semantic-release.yml](../../../.github/workflows/semantic-release.yml) | Propaga release ai **moduli** cambiati | `workflow_run` dopo **Release** OK |
| [module-release.yml](../../../.github/workflows/module-release.yml) | Release per modulo (`laravel/Modules/*`) | `push` path moduli, `workflow_call`, `workflow_dispatch` |
| [release-drafter.yml](../../../.github/workflows/release-drafter.yml) | Bozza release da PR | `push` `main`/`master` |
| [update-changelog.yml](../../../.github/workflows/update-changelog.yml) | Sync `CHANGELOG.md` post-release | `workflow_run` dopo **Release** |
| [tag-version.yml](../../../.github/workflows/tag-version.yml) | Dispatch manuale **Release** | `workflow_dispatch`, `repository_dispatch` |
| [attest-release.yml](../../../.github/workflows/attest-release.yml) | Provenance artifact | `workflow_run` dopo **Release** |
| [changelog-advanced.yml](../../../.github/workflows/changelog-advanced.yml) | Analytics + contributori + grafici Mermaid | `workflow_run` / dispatch / schedule |
| [changelog-contributors.yml](../../../.github/workflows/changelog-contributors.yml) | Report settimanale contributori | mercoledì / dispatch |
| [changelog-git-cliff.yml](../../../.github/workflows/changelog-git-cliff.yml) | Changelog git-cliff | post-release / dispatch |

Dettaglio analytics: [github-actions-changelog-analytics.md](github-actions-changelog-analytics.md)

## Configurazione

- [`.releaserc.json`](../../../.releaserc.json) — plugin changelog + git + github; branch `dev` in prerelease
- [`package.json`](../../../package.json) — dipendenze `semantic-release` (root)
- [`CHANGELOG.md`](../../../CHANGELOG.md) — aggiornato da semantic-release

## Conventional Commits

Formato atteso: `feat:`, `fix:`, `chore:`, `docs:`, `BREAKING CHANGE:` — allineato a [commit-lint.yml](../../../.github/workflows/commit-lint.yml).

## Verifica locale (obbligatoria prima di dichiarare chiuso)

```bash
cd /path/to/base_ptvx_fila5
npm ci
npx semantic-release --dry-run
python3 -c "import yaml; from pathlib import Path; [yaml.safe_load(p.read_text()) for p in Path('.github/workflows').glob('*.yml')]"
```

## Dispatch manuale

```bash
# Release semantic-release
gh workflow run release.yml --repo provtv/base_ptv_fila5_mono

# Tag semver + attest (senza pipeline semantic-release completa)
gh workflow run semantic-versioning.yml --repo provtv/base_ptv_fila5_mono

# Singolo modulo
gh workflow run module-release.yml -f module-name=User --repo provtv/base_ptv_fila5_mono
```

## Note operative

1. **Non usare** `secrets.GH_TOKEN` nel mono root — usare `GITHUB_TOKEN` (o PAT repo con scope `workflow` se serve aggiornare workflow da bot).
2. Release create con `GITHUB_TOKEN` **non** emettono `on: release` — usare `workflow_run` (vedi [semantic-release docs](https://semantic-release.gitbook.io/semantic-release/recipes/ci-configurations/github-actions)).
3. Moduli/temi: workflow locali in `laravel/Modules/*/.github/` restano validi; standard vetrina: [module-theme-release-showcase-standard.md](../standards/module-theme-release-showcase-standard.md).

## Vedi anche

- Issue [#153](https://github.com/provtv/base_ptv_fila5_mono/issues/153) — standard release moduli/temi
