---
title: "Unified Trigger Map"
type: "rule"
tags: [trigger-map, on-demand, routing]
created: 2026-05-12
updated: 2026-05-12
---

# 00-TRIGGER_MAP

> Canonical routing table: task trigger → wiki resources to load on-demand.

## Triggers

| Trigger | Load |
|---------|------|
| New module/theme | `docs/wiki/concepts/module-structure.md` |
| Architecture decision | `docs/wiki/concepts/architecture-guardrails.md`, `docs/wiki/rules/on-demand-pattern.md` |
| Permission/RBAC | `docs/wiki/concepts/spatie-permission-teams-laravel-13.md` |
| Wiki/doc maintenance | `docs/wiki/concepts/second-brain-operating-model.md`, `docs/wiki/concepts/second-brain-continuous-improvement.md` |
| Token overflow | `docs/wiki/concepts/context-mode-plugin.md`, `docs/wiki/concepts/context-mode-cli-reference.md` |
| QMD search | `docs/wiki/how-to/qmd-search-guide.md` |
| BMAD workflow | `docs/wiki/concepts/bmad-operating-model.md` |
| Agent coordination | `docs/wiki/agents/INDEX.md` |
| Skill needed | `docs/wiki/skills/INDEX.md` |
| Command reference | `docs/wiki/commands/INDEX.md` |
| Pattern/memory recall | `docs/wiki/memories/INDEX.md` |
| LLM wiki discipline | `docs/wiki/concepts/llm-wiki-operational-discipline.md` |
| Git policy | `docs/wiki/concepts/llm-wiki-operational-discipline.md` |
| Cache discipline | `docs/wiki/concepts/llm-wiki-operational-discipline.md` |
| Bootstrap stub size | `docs/wiki/concepts/llm-wiki-operational-discipline.md` |
| Laravel upgrade | `docs/wiki/concepts/laravel13-modular-composer-upgrade.md` |
| Accessor/mutator | `docs/wiki/concepts/accessor-auto-persistence.md` |
| Filament ->label() / traduzioni | `docs/wiki/rules/filament-rules-summary.md`, `docs/wiki/rules/schema-conventions.md` |
| Filament class extension / XotBase | `docs/wiki/rules/filament-rules-summary.md`, `docs/wiki/rules/xotbase-critical-rules.md` |
| Filament resource/page/widget | `docs/wiki/rules/xotbase-critical-rules.md`, `docs/wiki/rules/ai-guidelines.md` |
| Filament $resource property / visibilità | `docs/wiki/rules/filament-resource-property.md` |
| XotBaseListRecords / getResource auto-resolve | `docs/wiki/rules/filament-resource-property.md` |
| Skill: crea filament page | `laravel/Modules/Xot/docs/wiki/skills/filament-page-creation.md` |
| Namespace modulo / `\app\` nel namespace | `docs/wiki/rules/laraxot-module-namespace.md` |
| Context overflow / token limit / 262K | `docs/wiki/rules/context-overflow-prevention.md` |
| Session troppo lunga / compaction error | `docs/wiki/rules/context-overflow-prevention.md` |
| User Filament translations / LangServiceProvider | `laravel/Modules/User/docs/wiki/rules/INDEX.md`, `laravel/Modules/User/docs/wiki/skills/filament-translation-audit.md` |
| Lang translation keys / translation ownership | `laravel/Modules/Lang/docs/wiki/rules/translation-key-governance.md`, `laravel/Modules/Lang/docs/wiki/skills/translation-key-audit.md` |
| Activity XotBaseResource zen pattern | `laravel/Modules/Activity/docs/wiki/rules/INDEX.md`, `laravel/Modules/Activity/docs/wiki/concepts/xotbase-resource-zen-pattern.md` |
| Rating Filament resource zen pattern | `laravel/Modules/Rating/docs/wiki/rules/INDEX.md`, `laravel/Modules/Rating/docs/wiki/concepts/filament-resource-zen-pattern.md` |

## Usage

```bash
# Identify trigger → consult this map
qmd search "<trigger topic>" --limit 5
# Read matched files, apply rule/use skill
```
