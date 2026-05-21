---
title: "Unified Trigger Map"
type: "rule"
tags: [trigger-map, on-demand, routing]
created: 2026-05-12
updated: 2026-05-20
---

# 00-TRIGGER_MAP

> Canonical routing table: task trigger -> wiki resources to load on-demand.

## Triggers

| Trigger | Load |
|---|---|
| New module/theme | `docs/wiki/concepts/module-structure.md` |
| Architecture decision | `docs/wiki/concepts/architecture-guardrails.md`, `docs/wiki/rules/on-demand-pattern.md` |
| Wiki/doc maintenance | `docs/wiki/concepts/second-brain-operating-model.md`, `docs/wiki/concepts/second-brain-continuous-improvement.md` |
| Nuovo o edit `.md` wiki / standard YAML + atomicità | `docs/wiki/concepts/markdown-note-minimum-standard.md`, `docs/wiki/concepts/second-brain-operating-model.md` |
| Second brain quality / wiki maintenance | `docs/wiki/concepts/second-brain-operating-model.md`, `docs/wiki/concepts/second-brain-continuous-improvement.md`, `docs/wiki/concepts/second-brain-audit-checks.md` |
| Rules on-demand / skill routing | `docs/wiki/rules/on-demand-pattern.md`, `docs/wiki/skills/INDEX.md` |
| Skill needed | `docs/wiki/skills/INDEX.md` |
| Skill authoring / reusable workflow | `docs/wiki/skills/on-demand-skill-maintenance.md`, `docs/wiki/rules/on-demand-pattern.md` |
| Command reference | `docs/wiki/commands/INDEX.md` |
| Pattern/memory recall | `docs/wiki/memories/INDEX.md` |
| Agent coordination | `docs/wiki/agents/INDEX.md` |
| QMD search | `docs/wiki/how-to/qmd-search-guide.md` |
| GitHub issue ↔ wiki (audit trail agent) | `docs/wiki/how-to/github-issue-agent-discipline.md` |
| Creare/chiudere issue GitHub senza chiedere all’utente | `docs/wiki/how-to/github-issue-agent-discipline.md`, `docs/wiki/memories/github-issues-proactive.md` |
| PHPStan unknown class Spatie ModelStates / Xot States | `docs/wiki/memories/spatie-model-states-php84.md`, `laravel/Modules/Xot/docs/wiki/concepts/laravel13-modular-package-compatibility-matrix.md` |
| Passaggio MySQL → MariaDB (WSL / datadir) | `docs/wiki/how-to/switch-mysql-to-mariadb.md`, `bashscripts/mysql/switch-to-mariadb.sh` |
| Mutex lock affiancato / validazione PHP post-edit | `docs/wiki/rules/validation-post-edit-rule.md` |
| Token overflow / API «maximum context length is 131072» | `docs/wiki/how-to/api-context-length-exceeded-131072.md`, `docs/wiki/concepts/context-overflow-prevention.md`, `docs/chat/context-api-131072-overflow.md` |
| Token overflow / 262K / API 400 / compaction / Cursor «Compaction exhausted» | `docs/wiki/concepts/context-overflow-prevention.md` |
| LLM wiki discipline / git policy / cache discipline / bootstrap stub size | `docs/wiki/concepts/llm-wiki-operational-discipline.md` |
| MCP minimum stack (context-mode, playwright, puppeteer, token-optimizer, laravel-boost) | `docs/wiki/how-to/mcp-minimum-stack.md`, `docs/wiki/_templates/mcp-minimum-stack.json` |
| Permission/RBAC | `docs/wiki/concepts/spatie-permission-teams-laravel-13.md` |
| BMAD workflow | `docs/wiki/concepts/bmad-operating-model.md` |
| Laravel upgrade | `docs/wiki/concepts/laravel13-modular-composer-upgrade.md` |
| Accessor/mutator | `docs/wiki/concepts/accessor-auto-persistence.md` |
| Filament ->label() / traduzioni | `docs/wiki/rules/filament-rules-summary.md`, `docs/wiki/rules/schema-conventions.md` |
| Filament class extension / XotBase | `docs/wiki/rules/filament-rules-summary.md`, `docs/wiki/rules/xotbase-critical-rules.md` |
| Filament versione stack (**v5**, non v4) | `docs/wiki/memories/filament-version-policy.md`, `laravel/Modules/Xot/docs/filament-5-laraxot-rules.md` |
| Filament resource/page/widget | `docs/wiki/rules/xotbase-critical-rules.md`, `docs/wiki/rules/ai-guidelines.md` |
| Filament $resource property / visibilità | `docs/wiki/rules/filament-resource-property.md` |
| XotBaseListRecords / getResource auto-resolve | `docs/wiki/rules/filament-resource-property.md` |
| Skill: crea filament page | `laravel/Modules/Xot/docs/wiki/skills/filament-page-creation.md` |
| Namespace modulo / `\app\` nel namespace | `docs/wiki/rules/laraxot-module-namespace.md` |
| User Filament translations / LangServiceProvider | `laravel/Modules/User/docs/wiki/rules/INDEX.md`, `laravel/Modules/User/docs/wiki/skills/filament-translation-audit.md` |
| Lang translation keys / translation ownership | `laravel/Modules/Lang/docs/wiki/rules/translation-key-governance.md`, `laravel/Modules/Lang/docs/wiki/skills/translation-key-audit.md` |
| Activity XotBaseResource zen pattern | `laravel/Modules/Activity/docs/wiki/rules/INDEX.md`, `laravel/Modules/Activity/docs/wiki/concepts/xotbase-resource-zen-pattern.md` |
| Rating Filament resource zen pattern | `laravel/Modules/Rating/docs/wiki/rules/INDEX.md`, `laravel/Modules/Rating/docs/wiki/concepts/filament-resource-zen-pattern.md` |
| Git atomic / forward-only commits | `docs/wiki/rules/git-atomic-operations.md` |
| Memory system / durable decisions | `docs/wiki/how-to/memory-system-usage.md`, `docs/wiki/memories/INDEX.md` |
| Skill discovery | `docs/wiki/how-to/skill-discovery.md`, `docs/wiki/skills/INDEX.md` |
| Rule atomicity / one idea per file | `docs/wiki/rules/rule-atomicity.md` |
| Wiki activity log / audit trail | `docs/wiki/log.md`, `docs/wiki/how-to/github-issue-agent-discipline.md` |
| Wikilink / cross-reference cleanup | `docs/wiki/how-to/wikilink-cross-reference.md` |
| Context-mode / ctx compression | `docs/wiki/concepts/context-mode-usage.md`, `docs/wiki/how-to/context-mode-setup.md` |
| PHPStan module analysis | `docs/wiki/rules/phpstan-rules.md` |
| New module wiki bootstrap | `docs/wiki/how-to/module-wiki-documentation.md`, `docs/wiki/concepts/module-structure.md` |
| property_exists on Eloquent | `docs/wiki/rules/coding-standards.md`, `docs/wiki/memories/eloquent-hasattribute-not-property-exists.md` |
| Compaction exhausted / Cursor recovery | `docs/wiki/memories/compaction-exhausted-recovery.md`, `.cursor/rules/cursor-context-discipline.mdc`, `laravel/.cursor/rules/laravel-boost.mdc` (stub — non usare monolite `.bak`) |
| XotBase / no direct Filament extend | `docs/wiki/memories/xotbase-never-extend-filament.md`, `docs/wiki/rules/xotbase-critical-rules.md` |

## Usage

```bash
qmd search "<trigger topic>" --limit 5
```
