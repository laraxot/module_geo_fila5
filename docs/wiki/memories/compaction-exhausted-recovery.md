---
title: "Compaction exhausted recovery"
type: "memory"
tags: [context-mode, cursor, overflow]
created: 2026-05-19
updated: 2026-05-20
sources:
  - .cursor/rules/cursor-context-discipline.mdc
  - docs/wiki/concepts/context-overflow-prevention.md
---

# Compaction exhausted recovery

Su Cursor «Compaction exhausted»: riduci contesto (QMD `--limit`, context-mode), segui `.cursor/rules/cursor-context-discipline.mdc`, poi `docs/wiki/concepts/context-overflow-prevention.md`.

**Causa frequente in questo repo (2026-05):** regola `laravel/.cursor/rules/laravel-boost.mdc` era un monolite enorme con `alwaysApply: true` — ora è uno **stub**; il vecchio contenuto è in `laravel/.cursor/laravel-boost-guidelines.FULL.mdc.bak` (non caricato come rule).

- [context-overflow-prevention](../concepts/context-overflow-prevention.md)
