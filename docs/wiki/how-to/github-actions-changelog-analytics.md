---
title: "GitHub Actions — changelog analytics e contributori"
type: how-to
tags: [github-actions, changelog, contributors, mermaid, analytics]
module: ptvx-project
created: 2026-06-03
updated: 2026-06-03
qmd: "changelog advanced contributors report mermaid git-cliff release-changelog-builder"
related:
  - github-actions-semantic-release-stack.md
  - ../../../.github/workflows/changelog-advanced.yml
  - ../../../.github/workflows/changelog-contributors.yml
  - ../../../bashscripts/ci/generate-changelog-report.mjs
---

# Changelog analytics (contributori + grafici)

Complementa [semantic-release stack](github-actions-semantic-release-stack.md): oltre a `CHANGELOG.md` automatico, il mono genera **report con tabelle e grafici Mermaid** (pie/bar, render nativo su GitHub).

## Workflow

| File | Quando | Output |
|------|--------|--------|
| [changelog-advanced.yml](../../../.github/workflows/changelog-advanced.yml) | Dopo **Release** OK, `workflow_dispatch`, lunedì 07:00 UTC | `CHANGELOG-ANALYTICS.md`, `docs/chat/changelog-release-report.md`, artifact CI, append note su GitHub Release |
| [changelog-contributors.yml](../../../.github/workflows/changelog-contributors.yml) | Mercoledì 08:00 UTC, dispatch | `docs/chat/changelog-contributors-weekly.md` (ultimi 30 giorni) |
| [changelog-git-cliff.yml](../../../.github/workflows/changelog-git-cliff.yml) | Post-release / dispatch | `docs/chat/changelog-git-cliff.md` via [cliff.toml](../../../cliff.toml) |
| [update-changelog.yml](../../../.github/workflows/update-changelog.yml) | Post-release | Sync `CHANGELOG.md` |

## Cosa include il report avanzato

1. **Tabella contributori** — commit e percentuale per autore  
2. **Grafici Mermaid** — pie commit per contributore/tipo; bar chart per modulo/tema  
3. **release-changelog-builder** — changelog strutturato da PR/label (`mikepenz/release-changelog-builder-action`)  
4. **JSON** — `CHANGELOG-ANALYTICS.json` per dashboard o tool esterni  
5. **Artifact** — bundle scaricabile da run Actions  

Script locale: [generate-changelog-report.mjs](../../../bashscripts/ci/generate-changelog-report.mjs)

## Verifica locale

```bash
cd /path/to/base_ptvx_fila5
git fetch --tags
CHANGELOG_FROM_TAG=v1.0.0 CHANGELOG_TO_REF=HEAD node bashscripts/ci/generate-changelog-report.mjs
# oppure ultimi 30 giorni:
CHANGELOG_SINCE=$(date -u -d '30 days ago' +%Y-%m-%d) OUTPUT_MD=/tmp/weekly.md node bashscripts/ci/generate-changelog-report.mjs
```

## Dispatch

```bash
gh workflow run changelog-advanced.yml --repo provtv/base_ptv_fila5_mono
gh workflow run changelog-contributors.yml --repo provtv/base_ptv_fila5_mono
gh workflow run changelog-git-cliff.yml --repo provtv/base_ptv_fila5_mono
```

## Vedi anche

- Issue [#153](https://github.com/provtv/base_ptv_fila5_mono/issues/153)
