---
title: "Docs Landscape: Modules and Themes"
module: "ptvx-project"
type: source
created: "2026-04-28T00:00:00Z"
updated: "2026-04-28T00:00:00Z"
related:
  - "[[Second Brain Operating Model]]"
  - "[[Project Home]]"
---

# Docs Landscape: Modules and Themes

> Source summary derived from a repository scan of `laravel/Modules/*/docs` and `laravel/Themes/*/docs`.

## Scope

This summary is based on a direct inventory of documentation folders under:

- `laravel/Modules/`
- `laravel/Themes/`
- project root `docs/`

## High-Level Observations

### Modules

- Many modules already expose `docs/wiki/`, which means the structural prerequisite for the second brain is present.
- Some modules also contain nested `source/docs`, `bashscripts/docs`, or generated documentation trees, so not every `docs` directory is equal in authority.
- `Activity` stands out as a high-density documentation area with architecture, errors, coverage, event-sourcing, Filament migration notes, and duplicate/archive material.
- Several module trees show evidence of copied or mirrored docs paths, which increases the risk of stale or repeated guidance.

### Themes

- `Themes/Zero/docs` is broad and operational, with architecture, product, quality, screenshots, roadmap, and wiki bootstrap content.
- `Themes/One/docs` is smaller but structured, including roadmap, PRD/product files, troubleshooting, and wiki bootstrap content.
- Both themes still carry mixed conventions such as `snake_case`, `kebab-case`, uppercase legacy files, and roadmap/content overlap.

### Root

- Root `docs/` acts as a cross-cutting knowledge dump for architecture, AI-agent workflows, BMAD/GSD, PHPStan, scripts, and historical project notes.
- It also contains clear duplication signals:
  - case-variant paths
  - same concept in multiple filenames
  - code-like assets and scripts living beside prose docs

## Implications for the Second Brain

1. The project does not need a new documentation system from zero.
2. It needs disciplined ingestion and synthesis across already existing raw material.
3. The wiki should become the stable answer layer, while raw docs remain the evidence layer.
4. Ingest should prioritize:
   - root architecture and AI workflow docs
   - module docs with high density and duplication
   - theme docs that define UX and frontend conventions

## Priority Candidates for Ingest

- Root `docs/ai/`, `docs/architecture/`, `docs/bmad/`, `docs/PHPStan/`
- `laravel/Modules/Activity/docs/`
- `laravel/Modules/Xot/docs/`
- `laravel/Modules/UI/docs/`
- `laravel/Modules/User/docs/`
- `laravel/Themes/Zero/docs/`
- `laravel/Themes/One/docs/`

## References

- `../concepts/second-brain-operating-model.md`
- [[Project Home]]
