---
title: "Compaction exhausted recovery"
type: "memory"
tags: [context-mode, cursor, overflow]
created: 2026-05-19
updated: 2026-05-26
sources:
  - .cursor/rules/cursor-context-discipline.mdc
  - docs/wiki/concepts/context-overflow-prevention.md
  - docs/wiki/how-to/autocompact-thrashing-recovery.md
---

# Compaction exhausted recovery

Su Cursor «Compaction exhausted»: riduci contesto (QMD `--limit`, context-mode), segui `.cursor/rules/cursor-context-discipline.mdc`, poi `docs/wiki/concepts/context-overflow-prevention.md`.

**Causa frequente in questo repo (2026-05):** regola `laravel/.cursor/rules/laravel-boost.mdc` era un monolite enorme con `alwaysApply: true` — ora è uno **stub**; il vecchio contenuto è in `laravel/.cursor/laravel-boost-guidelines.FULL.mdc.bak` (non caricato come rule).

- [context-overflow-prevention](../concepts/context-overflow-prevention.md)

## Autocompact thrashing

Se il contesto si riempie entro 3 turn dal compact per 3 volte consecutive, smettere di compattare la stessa chat: checkpoint breve, `/clear` o nuova sessione, poi ricaricare solo issue + file esatti. Playbook: [autocompact-thrashing-recovery](../how-to/autocompact-thrashing-recovery.md). Issue: [#138](https://github.com/provtv/base_ptv_fila5_mono/issues/138).
