---
title: "Ingest Backlog"
module: "ptvx-project"
type: source
created: "2026-04-29T09:15:00Z"
qmd: "ingest backlog, docs priority, token-cost, wiki ingestion queue"
related:
  - "[[Second Brain Operating Model]]"
  - "[[Second Brain Continuous Improvement]]"
---

# Ingest Backlog — PTVX Project

> Prioritized list of raw doc clusters to ingest into wiki.
> Token-cost = estimated for QMD search + wiki page creation.

## Priority 1 (High-Signal, Cross-Cutting)

| Source | Scope | Rationale | ~Tokens | Reuse Freq |
|--------|-------|----------|---------|------------|
| `docs/architecture/` | Root | Affects all modules, foundational | ~3000 | Daily |
| `docs/ai/` | Root | AI agent workflows, shared by all | ~2000 | Daily |
| `docs/bmad/` | Root | BMAD methodology, all agents | ~2500 | Daily |
| `laravel/Modules/Xot/docs/` | Module | Base classes, core patterns | ~4000 | Every module task |

## Priority 2 (Module-Specific, High Density)

| Source | Rationale | ~Tokens | Reuse Freq |
|--------|----------|---------|------------|
| `laravel/Modules/Activity/docs/` | Architecture, errors, coverage, Filament | ~5000 | Weekly |
| `laravel/Modules/UI/docs/` | UI patterns, Blade components | ~3000 | Weekly |
| `laravel/Modules/User/docs/` | Auth, roles, permissions | ~2500 | Weekly |
| `laravel/Modules/Performance/docs/` | Performance models, scopes | ~2000 | Weekly |

## Priority 3 (Theme-Specific, UX/Product)

| Source | Rationale | ~Tokens | Reuse Freq |
|--------|----------|---------|------------|
| `laravel/Themes/Zero/docs/` | Theme architecture, product, roadmap | ~4000 | Weekly |
| `laravel/Themes/One/docs/` | Product, roadmap, troubleshooting | ~2000 | Weekly |

## Priority 4 (Lower-Signal, Archival)

| Source | Rationale | ~Tokens | Reuse Freq |
|--------|----------|---------|------------|
| `docs/PHPStan/` | Static analysis configs | ~1500 | Monthly |
| `laravel/Modules/*/docs/` (remaining 30 modules) | Uneven quality, pick per task | ~2000 each | Per task |

## Ingest Log Reference

See `../log.md` for completed ingests.
