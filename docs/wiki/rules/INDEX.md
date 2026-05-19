---
title: "Rules Index"
type: "index"
tags: [rules, trigger-map, on-demand]
module: "root"
updated: 2026-05-19
---

# Rules — Root Wiki

> Route through the trigger map first; keep this file summary-only.

## Routes

- [00-TRIGGER_MAP](./00-TRIGGER_MAP.md) — canonical trigger -> resource routing
- [on-demand-pattern](./on-demand-pattern.md) — LLM Wiki, rules, skills, QMD loading
- [validation-post-edit-rule](./validation-post-edit-rule.md) — mutex `file.ext.lock` affiancato + PHPStan / PHPMD (`laravel/tools`) / PHPInsights / E2E globale
- [github-issue-agent-discipline](../how-to/github-issue-agent-discipline.md) — issue GitHub come audit trail + `gh`; complementare alla wiki
- [laraxot-module-namespace](./laraxot-module-namespace.md) — module namespace without `app`
- [filament-rules-summary](./filament-rules-summary.md), [xotbase-critical-rules](./xotbase-critical-rules.md), [schema-conventions](./schema-conventions.md), [ai-guidelines](./ai-guidelines.md), [filament-resource-property](./filament-resource-property.md) — Filament/XotBase rules
- [git-atomic-operations](./git-atomic-operations.md), [rule-atomicity](./rule-atomicity.md) — git forward-only + one-idea-per-rule

Usage: `qmd search "rule:<topic>" --limit 5`
