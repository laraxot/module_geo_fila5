---
title: "Ponytail — installazione e verifica (Cursor / OpenCode)"
type: how-to
tags: [ponytail, cursor, opencode, yagni, agent]
created: 2026-07-01
updated: 2026-07-01
qmd: "ponytail setup installazione cursor opencode sync lazy senior dev"
related:
  - ../../ponytail-audit-plan.md
  - ../../ponytail-audit-report.md
  - ./phpstan-modules-swarm.md
  - ../../../bashscripts/tools/ponytail-sync.sh
---

# Ponytail — setup progetto

[Ponytail](https://github.com/DietrichGebert/ponytail) impone la «scala YAGNI» agli agenti: meno codice, stesse guardie su sicurezza/validazione.

## Componenti in questo repo

| Pezzo | Path | Ruolo |
|-------|------|--------|
| npm (OpenCode) | `laravel/package.json` → `@dietrichgebert/ponytail@4.8.4` | plugin OpenCode + skills npm |
| OpenCode config | `opencode.json` (root) | plugin path verso `laravel/node_modules/...` |
| Sorgente sync | `ponytail-source/` (clone locale, gitignored) | `.cursor/rules`, skills Cursor |
| Sync script | `bashscripts/tools/ponytail-sync.sh` | copia regole/skills in `.cursor/` e `bashscripts/ai/` |
| Audit piano | [ponytail-audit-plan.md](../../ponytail-audit-plan.md) | audit over-engineering (discussione) |

## Installazione (prima volta)

```bash
# 1. Dipendenze Laravel (include ponytail npm)
cd laravel && npm install

# 2. Clone sorgente upstream (solo per regole Cursor — non in git)
cd ..
git clone --depth 1 --branch v4.8.4 https://github.com/DietrichGebert/ponytail.git ponytail-source

# 3. Regole Cursor + skills + bundle AI
bash bashscripts/tools/ponytail-sync.sh
```

## Verifica

```bash
# Gate sessione (ponytail-skill, ponytail-rule-cursor, ponytail-sync)
bash bashscripts/tools/run-session-gate.sh | grep ponytail

# Test upstream (opzionale; 1 test correctness può fallire su ambiente senza promptfoo)
cd ponytail-source && npm test

# MCP opzionale (prompt/tool, non always-on)
cd ponytail-source/ponytail-mcp && npm install && npm test
```

Atteso gate: `ponytail-skill: ok`, `ponytail-rule-cursor: ok`, `ponytail-sync: ok`.

## Cursor

- Regola always-on: `.cursor/rules/ponytail.mdc` (`alwaysApply: true`)
- Skills on-demand: `.cursor/skills/ponytail-audit/`, `ponytail-review/`, ecc.
- Comandi equivalenti in chat: «esegui ponytail-audit», «ponytail-review sul diff»

## OpenCode

`opencode.json` carica il plugin da `laravel/node_modules`. Comandi: `/ponytail [lite|full|ultra|off]`, `/ponytail-audit`, `/ponytail-review`.

## Aggiornamento versione

```bash
cd ponytail-source && git fetch --tags && git checkout v4.8.4   # o tag nuovo
cd ../laravel && npm install @dietrichgebert/ponytail@4.8.4
bash bashscripts/tools/ponytail-sync.sh
```

## Collegamenti

- [ponytail-audit-plan.md](../../ponytail-audit-plan.md) — audit repo (Pdnd/Incentivi esclusi)
- [phpstan-modules-swarm.md](./phpstan-modules-swarm.md) — qualità PHP post-edit
- Upstream: [agent-portability.md](https://github.com/DietrichGebert/ponytail/blob/main/docs/agent-portability.md)
