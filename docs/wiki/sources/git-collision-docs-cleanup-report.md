---
title: "Git collision cleanup report — module/theme docs"
type: source
status: approved
tags: [git, merge-conflicts, docs, modules, themes, second-brain]
created: "2026-05-26"
updated: "2026-05-26"
related:
  - "../how-to/git-merge-marker-sweep.md"
  - "../how-to/module-docs-deduplication.md"
  - "../concepts/second-brain-continuous-improvement.md"
  - "../rules/00-TRIGGER_MAP.md"
issue: "https://github.com/provtv/base_ptv_fila5_mono/issues/140"
---

# Git collision cleanup report — module/theme docs

## Summary

- Scope: `laravel/Modules/*/docs/**` and `laravel/Themes/*/docs/**`.
- Files changed: 115
- Conflict marker lines removed: 2034
- Strategy: remove only marker fence lines (`<<<<<<<`, standalone `=======`, `>>>>>>>`) and keep both documentation bodies.
- Reason: docs are knowledge assets; preserving both sides maximizes recall and avoids silent loss.

## Changed Files By Scope

- `Modules/Activity`: 21
- `Modules/Gdpr`: 2
- `Modules/Job`: 2
- `Modules/Lang`: 4
- `Modules/Media`: 2
- `Modules/Notify`: 6
- `Modules/UI`: 10
- `Modules/User`: 1
- `Modules/Xot`: 67

## Root `docs/` — template corrotti (maggio 2026)

- Ripuliti `.php_cs.dist.php` (delega a `.php-cs-fixer.dist.php`), `phpstan.neon.dist`, `phpunit.xml.dist` (marcatori e duplicati YAML/XML).
- Sweep `docs/raw/history/*.md` e `laravel/Modules/User/docs/volt-folio-logout-error.md` (righe `<<<<<<<` / `>>>>>>>`, separatori `=======`).
- Consolidati `laravel/Modules/Xot/docs/filament/infinite-loop-getstepbyname-fix*.md`; alias maiuscolo redirect.
- Procedura ripetibile: [`git-merge-marker-sweep.md`](../how-to/git-merge-marker-sweep.md).

## Follow-Up

- Continue deduplication with `docs/wiki/how-to/module-docs-deduplication.md`.
- Normalize Markdown naming with `docs/wiki/rules/markdown-documentation-standard.md`.
- Keep future conflict audits attached to issue #140.
