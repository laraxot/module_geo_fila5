---
title: "MCP minimum stack (5 servers)"
type: how-to
tags: [mcp, cursor, context-mode, playwright, puppeteer, laravel-boost]
module: ptvx-project
created: 2026-05-20
updated: 2026-05-21
qmd: "mcp minimum stack context-mode playwright puppeteer token-optimizer laravel-boost"
related:
  - "../concepts/context-overflow-prevention.md"
  - "../_templates/mcp-minimum-stack.json"
  - "../../chat/context-api-131072-overflow.md"
---

# MCP minimum stack

> Ogni agente full-stack su questo monorepo deve avere **configurati e funzionanti** questi cinque MCP.

| MCP | Ruolo | Verifica rapida |
|-----|--------|-----------------|
| **context-mode** | Comprime tool output / sandbox `ctx_*` | `context-mode --version` |
| **playwright** | UI / E2E browser | MCP attivo in IDE; `npx -y @playwright/mcp --help` |
| **puppeteer** | Browser automation alternativa | `npx -y @modelcontextprotocol/server-puppeteer` (avvio MCP) |
| **token-optimizer** | Riduzione token su payload ripetuti | `npx -y @ooples/token-optimizer-mcp` o bin locale sotto `bashscripts/mcp/` |
| **laravel-boost** | Docs/search Laravel via `boost:mcp` | `php laravel/artisan boost:mcp --help` (da root repo; `command` in JSON = `php`) |

## File canonici nel repo

- Template: [`mcp-minimum-stack.json`](../_templates/mcp-minimum-stack.json)
- Cursor progetto: `.cursor/mcp.json`
- Root / CLI: `.mcp.json` (include anche **qmd** come sesto server opzionale wiki)

Dopo modifica: riavviare MCP in Cursor (Developer: Reload Window o toggle MCP).

## Installazione host

```bash
npm install -g context-mode@latest
cd bashscripts/mcp && npm install   # token-optimizer locale (opzionale se si usa npx)
php laravel/artisan boost:install  # se boost:mcp non risponde
```

## Gate

```bash
bashscripts/quality-gates/verify-llm-wiki.sh   # sezione MCP minimum
```

**Upstream:** [Trigger Map](../rules/00-TRIGGER_MAP.md)
