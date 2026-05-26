---
title: "Semantic release per moduli e temi"
type: rule
status: approved
tags: [semantic-release, github-actions, changelog, modules, themes, readme]
created: "2026-05-26"
updated: "2026-05-26"
issue: "https://github.com/provtv/base_ptv_fila5_mono/issues/153"
---

# Semantic release per moduli e temi

Ogni modulo e tema deve avere:

- `.github/workflows/semantic-release.yml`
- `.releaserc.json`
- `CHANGELOG.md`
- `README.md` marketing con backlink relativi a `./docs`
- `docs/release-marketing-standard.md`

Standard: Conventional Commits, semantic-release, auto GitHub release, auto changelog.
