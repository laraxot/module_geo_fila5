---
title: "Unified Trigger Map"
type: "rule"
tags: [trigger-map, on-demand, routing]
created: 2026-05-12
updated: 2026-05-19
---

# 00-TRIGGER_MAP

> Canonical routing table: task trigger -> wiki resources to load on-demand.

## Triggers

| Trigger | Load |
|---|---|
| New module/theme | `docs/wiki/concepts/module-structure.md` |
| Architecture decision | `docs/wiki/concepts/architecture-guardrails.md`, `docs/wiki/rules/on-demand-pattern.md` |
| Wiki/doc maintenance | `docs/wiki/concepts/second-brain-operating-model.md`, `docs/wiki/concepts/second-brain-continuous-improvement.md` |
| Second brain quality / wiki maintenance | `docs/wiki/concepts/second-brain-operating-model.md`, `docs/wiki/concepts/second-brain-continuous-improvement.md`, `docs/wiki/concepts/second-brain-audit-checks.md` |
| Rules on-demand / skill routing | `docs/wiki/rules/on-demand-pattern.md`, `docs/wiki/skills/INDEX.md` |
| Skill needed | `docs/wiki/skills/INDEX.md` |
| Skill authoring / reusable workflow | `docs/wiki/skills/on-demand-skill-maintenance.md`, `docs/wiki/rules/on-demand-pattern.md` |
| Command reference | `docs/wiki/commands/INDEX.md` |
| Pattern/memory recall | `docs/wiki/memories/INDEX.md` |
| Agent coordination | `docs/wiki/agents/INDEX.md` |
| QMD search | `docs/wiki/how-to/qmd-search-guide.md` |
| Token overflow / 262K / API 400 / compaction | `docs/wiki/concepts/context-overflow-prevention.md` |
| LLM wiki discipline / git policy / cache discipline / bootstrap stub size | `docs/wiki/concepts/llm-wiki-operational-discipline.md` |
| Permission/RBAC | `docs/wiki/concepts/spatie-permission-teams-laravel-13.md` |
| BMAD workflow | `docs/wiki/concepts/bmad-operating-model.md` |
| Laravel upgrade | `docs/wiki/concepts/laravel13-modular-composer-upgrade.md` |
| Accessor/mutator | `docs/wiki/concepts/accessor-auto-persistence.md` |
| Filament ->label() / traduzioni | `docs/wiki/rules/filament-rules-summary.md`, `docs/wiki/rules/schema-conventions.md` |
| Filament class extension / XotBase | `docs/wiki/rules/filament-rules-summary.md`, `docs/wiki/rules/xotbase-critical-rules.md` |
| Filament resource/page/widget | `docs/wiki/rules/xotbase-critical-rules.md`, `docs/wiki/rules/ai-guidelines.md` |
| Filament $resource property / visibilità | `docs/wiki/rules/filament-resource-property.md` |
| XotBaseListRecords / getResource auto-resolve | `docs/wiki/rules/filament-resource-property.md` |
| Skill: crea filament page | `laravel/Modules/Xot/docs/wiki/skills/filament-page-creation.md` |
| Namespace modulo / `\app\` nel namespace | `docs/wiki/rules/laraxot-module-namespace.md` |
| User Filament translations / LangServiceProvider | `laravel/Modules/User/docs/wiki/rules/INDEX.md`, `laravel/Modules/User/docs/wiki/skills/filament-translation-audit.md` |
| Lang translation keys / translation ownership | `laravel/Modules/Lang/docs/wiki/rules/translation-key-governance.md`, `laravel/Modules/Lang/docs/wiki/skills/translation-key-audit.md` |
| Activity XotBaseResource zen pattern | `laravel/Modules/Activity/docs/wiki/rules/INDEX.md`, `laravel/Modules/Activity/docs/wiki/concepts/xotbase-resource-zen-pattern.md` |
| Rating Filament resource zen pattern | `laravel/Modules/Rating/docs/wiki/rules/INDEX.md`, `laravel/Modules/Rating/docs/wiki/concepts/filament-resource-zen-pattern.md` |

## Usage

```bash
qmd search "<trigger topic>" --limit 5
```
