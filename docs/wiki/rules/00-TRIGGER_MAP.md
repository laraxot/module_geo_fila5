---
title: "Unified Trigger Map"
type: rule
tags: [trigger-map, on-demand, routing, bootstrap, mandatory-discipline]
created: 2026-05-12
updated: 2026-05-26
qmd: "trigger map bootstrap sessione agente ROUTING mandatory discipline automatic load git merge markers"
---

# 00-TRIGGER_MAP

> **Routing canonico.** Prima il pacchetto **BOOTSTRAP SESSIONE AGENTE** (prima riga della tabella) — così la disciplina diventa **meccanica**, non dalla memoria del modello.

## Contratto automatico (wiki = legge operativa)

1. **Bootstrap** — prima di modificare file nel repo (`.md`, `.php`, config, MCP, ecc.), caricare tutti i path della riga **BOOTSTRAP SESSIONE AGENTE** (prima riga tabella); esclude solo risposte teoricamente «una riga» senza toccare il tree del repo.
2. **Routing incrementale** — individuare la riga più specifica (Compaction, Filament, MySQL…); caricare solo i path elencati, non intere cartelle.
3. **Verifica caricamento** — `qmd search "<trigger keywords>" --limit 5` o `Read` puntuali.
4. **Chiusura** — `docs/wiki/how-to/github-issue-agent-discipline.md` + aggiornare `docs/wiki/log.md` se la policy pubblica cambia.

## Triggers

| Trigger | Load |
|---|---|
| **BOOTSTRAP SESSIONE AGENTE** _(obbligatorio prima di ogni task su file / toolchain / MCP / wiki)_ | `docs/wiki/memories/response-style-sintetico-conciso-italiano.md`, `docs/wiki/how-to/github-issue-agent-discipline.md`, `docs/wiki/memories/github-issues-proactive.md`, `docs/wiki/concepts/context-overflow-prevention.md`, `docs/wiki/how-to/mcp-minimum-stack.md`, `docs/wiki/how-to/context-mode-setup.md`, `docs/wiki/rules/markdown-documentation-standard.md`, `docs/wiki/concepts/llm-wiki-operational-discipline.md` |
| New module/theme | `docs/wiki/concepts/module-structure.md` |
| Architecture decision | `docs/wiki/concepts/architecture-guardrails.md`, `docs/wiki/rules/on-demand-pattern.md` |
| Wiki/doc maintenance | `docs/wiki/concepts/second-brain-operating-model.md`, `docs/wiki/concepts/second-brain-continuous-improvement.md` |
| Nuovo o edit `.md` wiki / standard YAML + atomicità | `docs/wiki/rules/markdown-documentation-standard.md`, `docs/wiki/concepts/markdown-note-minimum-standard.md`, `docs/wiki/concepts/second-brain-operating-model.md` |
| Second brain quality / wiki maintenance | `docs/wiki/concepts/second-brain-operating-model.md`, `docs/wiki/concepts/second-brain-continuous-improvement.md`, `docs/wiki/concepts/second-brain-audit-checks.md` |
| Rules on-demand / skill routing | `docs/wiki/rules/on-demand-pattern.md`, `docs/wiki/skills/INDEX.md` |
| Skill needed | `docs/wiki/skills/INDEX.md` |
| Skill authoring / reusable workflow | `docs/wiki/skills/on-demand-skill-maintenance.md`, `docs/wiki/rules/on-demand-pattern.md` |
| Command reference | `docs/wiki/commands/INDEX.md` |
| Pattern/memory recall | `docs/wiki/memories/INDEX.md` |
| Agent coordination | `docs/wiki/agents/INDEX.md` |
| Massima confidenza agente / verifica prima di concludere | `docs/wiki/rules/agent-confidence-protocol.md`, `docs/wiki/memories/agent-confidence-protocol.md` |
| QMD search | `docs/wiki/how-to/qmd-search-guide.md` |
| GitHub issue ↔ wiki (audit trail agent) | `docs/wiki/how-to/github-issue-agent-discipline.md` |
| Residui conflitto Git (`<<<<<<<` / `>>>>>>>` / separatori, template `docs/` corrotti) | `docs/wiki/how-to/git-merge-marker-sweep.md`, `docs/wiki/sources/git-collision-docs-cleanup-report.md`, `docs/wiki/concepts/second-brain-operating-model.md` |
| Creare/chiudere issue GitHub senza chiedere all’utente | `docs/wiki/how-to/github-issue-agent-discipline.md`, `docs/wiki/memories/github-issues-proactive.md` |
| PHPStan unknown class Spatie ModelStates / Xot States | `docs/wiki/memories/spatie-model-states-php84.md`, `laravel/Modules/Xot/docs/wiki/concepts/laravel13-modular-package-compatibility-matrix.md` |
| Passaggio MySQL → MariaDB (WSL / datadir) | `docs/wiki/how-to/switch-mysql-to-mariadb.md`, `bashscripts/mysql/switch-to-mariadb.sh` |
| Mutex lock affiancato / validazione PHP post-edit | `docs/wiki/rules/validation-post-edit-rule.md` |
| Autocompact thrashing / «refilled within 3 turns» / runtime-telemetry token spike post-compact | `docs/wiki/rules/autocompact-thrashing-discipline.md` (**disciplina obbligatoria — caricamento automatico via trigger**), `docs/wiki/how-to/autocompact-thrashing-recovery.md` (**playbook canonico + recovery**), `docs/wiki/concepts/context-overflow-prevention.md` |
| Token overflow / API «maximum context length is 131072» | `docs/wiki/how-to/api-context-length-exceeded-131072.md`, `docs/wiki/concepts/context-overflow-prevention.md`, `docs/chat/context-api-131072-overflow.md` _(CI: opzionale `scripts/ai_token_guard.py`; template issue collegato se serve)_ |
| Token overflow / 262K / API 400 / compaction / Cursor «Compaction exhausted» | `docs/wiki/concepts/context-overflow-prevention.md`, `docs/wiki/memories/compaction-exhausted-recovery.md` _(workflow: `.github/workflows/context-index.yml`; preflight: `scripts/ai_token_guard.py` su letture voluminose)_ |
| Claude usa troppi token per chiamata / tool output troppo largo / `git status` enorme | `docs/wiki/rules/token-optimization-discipline.md` (**disciplina automatica obbligatoria**), `docs/wiki/rules/autocompact-thrashing-discipline.md`, `docs/wiki/concepts/context-overflow-prevention.md` |
| AGENTS.md enorme / BMAD rigenerato / bootstrap troppo grande | `docs/wiki/concepts/context-overflow-prevention.md`, `docs/wiki/concepts/llm-wiki-operational-discipline.md`, `bashscripts/ai/rules/bmad.md` |
| LLM wiki discipline / git policy / cache discipline / bootstrap stub size | `docs/wiki/concepts/llm-wiki-operational-discipline.md` |
| MCP minimum stack (context-mode, playwright, puppeteer, token-optimizer, laravel-boost) | `docs/wiki/how-to/mcp-minimum-stack.md`, `docs/wiki/_templates/mcp-minimum-stack.json` |
| MCP config contiene path assoluti workspace / `.cursor/mcp.json` non portabile | `docs/wiki/how-to/context-mode-setup.md`, `docs/wiki/how-to/mcp-minimum-stack.md`, `docs/wiki/rules/00-TRIGGER_MAP.md` |
| Attivare/configurare context-mode MCP / `ctx` o `context-mode` non trovato | `docs/wiki/rules/token-optimization-discipline.md`, `docs/wiki/how-to/context-mode-setup.md`, `docs/wiki/concepts/context-mode-optimal-configuration.md` |
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
| Stile risposta agenti (sintetico + conciso + italiano obbligatorio) | `docs/wiki/memories/response-style-sintetico-conciso-italiano.md` |
| Dependabot / security alert `laraxot/module_*` / vite npm / PR app/dependabot | `docs/wiki/how-to/dependabot-discipline.md`, `docs/wiki/memories/dependabot-check-discipline.md`, `bashscripts/ci/dependabot-security-repos.sh`, `bashscripts/ci/dependabot-sweep.sh` |
| Activity XotBaseResource zen pattern | `laravel/Modules/Activity/docs/wiki/rules/INDEX.md`, `laravel/Modules/Activity/docs/wiki/concepts/xotbase-resource-zen-pattern.md` |
| Rating Filament resource zen pattern | `laravel/Modules/Rating/docs/wiki/rules/INDEX.md`, `laravel/Modules/Rating/docs/wiki/concepts/filament-resource-zen-pattern.md` |
| Semantic versioning / auto release / auto changelog / README marketing moduli-temi | `docs/wiki/rules/semantic-release-module-theme-standard.md` |
| Dependabot audit & remediation (permanent discipline, all modules + themes) | `docs/wiki/memories/dependabot-audit-permanent-discipline.md`, GitHub #154 |
| Git atomic / forward-only commits | `docs/wiki/rules/git-atomic-operations.md` |
| Memory system / durable decisions | `docs/wiki/how-to/memory-system-usage.md`, `docs/wiki/memories/INDEX.md` |
| Skill discovery | `docs/wiki/how-to/skill-discovery.md`, `docs/wiki/skills/INDEX.md` |
| Rule atomicity / one idea per file | `docs/wiki/rules/rule-atomicity.md` |
| Wiki activity log / audit trail | `docs/wiki/log.md`, `docs/wiki/how-to/github-issue-agent-discipline.md` |
| Wikilink / cross-reference cleanup | `docs/wiki/how-to/wikilink-cross-reference.md` |
| Context-mode / ctx compression / verifica installazione | `docs/wiki/concepts/context-mode-usage.md`, `docs/wiki/how-to/context-mode-setup.md`, `docs/wiki/concepts/context-mode-cli-reference.md` |
| PHPStan module analysis | `docs/wiki/rules/phpstan-rules.md` |
| New module wiki bootstrap | `docs/wiki/how-to/module-wiki-documentation.md`, `docs/wiki/concepts/module-structure.md` |
| Module/Theme semantic release + marketing README (vetrina) | `docs/wiki/standards/module-theme-release-showcase-standard.md` + root `.github/workflows/semantic-release.yml` + `module-release.yml` |
| property_exists on Eloquent | `docs/wiki/rules/coding-standards.md`, `docs/wiki/memories/eloquent-hasattribute-not-property-exists.md` |
| Compaction exhausted / Cursor recovery | `docs/wiki/memories/compaction-exhausted-recovery.md`, `.cursor/rules/cursor-context-discipline.mdc`, `laravel/.cursor/rules/laravel-boost.mdc` (stub — non usare monolite `.bak`) |
| XotBase / no direct Filament extend | `docs/wiki/memories/xotbase-never-extend-filament.md`, `docs/wiki/rules/xotbase-critical-rules.md` |
| Tool selection hierarchy / context-safe usage | `docs/wiki/rules/context-safe-tool-usage.md` |

| Autocompact thrashing | docs/wiki/solutions/context_overflow_prevention.md, docs/wiki/rules/autocompact-thrashing-discipline.md |

## Enforcement (obbligatoria — include bootstrap)

Ogni agente DEVE:

1. **Eseguire il BOOTSTRAP** (prima riga tabella «BOOTSTRAP SESSIONE AGENTE») prima di modifiche sostanziali o di sequenze di tool che toccano la codebase — **nessuna eccezione** «solo quick fix», salvo reply puramente conversazionale senza accesso al tree.
2. **Applicare il trigger dominante**: caricare unicamente i file della/e riga/e corrispondente/i; combinare bootstrap + riga specifica se serve.
3. **`git remote -v`** + **`gh issue list …`** come da `docs/wiki/how-to/github-issue-agent-discipline.md`; commentare l’issue a fine task.
4. **Evitare** letture/integration di contesto larghi prima di aver caricato le policy delle righe scelte (`Read` chunked, MCP `ctx_*` dove configurato).
5. **Propagare qui** ogni fallimento ricorrente: nuova riga trigger o aggiornamento path.

## Usage

```bash
qmd search "<trigger topic>" --limit 5
```
