---
title: "Environment Verification & Cleanup 2026-05"
type: "memory"
tags: [env, lint, cleanup, naming-standard]
created: 2026-05-12
updated: 2026-05-12
---

# Environment Verification & Cleanup

> Verification of the project environment against the LLM Wiki on-demand pattern and naming standards.

## Verified Actions

- **Forbidden Directories Removed:**
    - `.cache/` (violation of Karpathy pattern)
    - `bashscripts/ai/.agents/node_modules/` (violation of agent structure rules)
- **Bootstrap Stubs Verified:**
    - `AGENTS.md`, `CLAUDE.md`, `GEMINI.md`, `QWEN.md` are all ≤50 lines and point to the wiki.
- **Root Naming Standards applied:**
    - Renamed several root `.md` files to lowercase kebab-case.
    - Renamed uppercase folders in `docs/` to lowercase (e.g., `docs/phpstan`, `docs/oauth`).
- **PRD Audit:**
    - Verified all modules and themes have a `prd.md` (or `PRD.md`).
    - Identified a duplicate `prd.md` vs `PRD.md` issue in `Xot` module.
    - Identified missing PRD in `laravel/Themes/Three` (ex `Theme_One`, rinominato 2026-05-26).

## Technical Insights

- **Xot Documentation:** The `laravel/Modules/Xot/docs/` directory contains thousands of files, many with legacy naming (uppercase). A batch refactoring strategy with link updating is required for full compliance.
- **Three** (ex `Theme_One`, rinominato 2026-05-26): doc-only folder; nessun composer.json né asset frontend. Conserva governance/release-discipline docs.

## Linked Rules

- [llm-wiki-operational-discipline](../concepts/llm-wiki-operational-discipline.md)
- [on-demand-pattern](../rules/on-demand-pattern.md)
