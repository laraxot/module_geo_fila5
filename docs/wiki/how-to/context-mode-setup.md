---
title: "Context-Mode Optimal Setup"
type: "how-to"
tags: [context-mode, setup, performance, bun, tokens, cursor-mcp]
created: 2026-05-12
updated: 2026-05-26
---

# Context-Mode Optimal Setup — Complete Guide

> **Aggiornamento 2026-05-26:** stack MCP in **`.cursor/mcp.json`** con **`${PWD}`** (mai path fissi tipo `/var/www/_bases/base_*` nel repo — la stessa cartella serve più progetti). `CONTEXT_MODE_DIR` = `${PWD}/.claude/context-mode` (Cursor espande `${PWD}` al path assoluto del workspace; `~` **non** espanso). Riavvio MCP dopo modifiche.

> Storico: v1.0.121 era il baseline documentato nel 2026-05.

---

## Cursor — attivazione MCP (portabile tra progetti)

1. File: **`.cursor/mcp.json`** (root repo) definisce il server **`context-mode`** con:
   - `CONTEXT_MODE_DIR` → `${PWD}/.claude/context-mode`
   - `CONTEXT_MODE_PROJECT_DIR` → `${PWD}`
   - `CONTEXT_MODE_EXTERNAL_MCP_NUDGE_EVERY` → `10` (default README; suggerisce `ctx_execute` su payload MCP grandi ogni N chiamate)
   - **Vietato** committare path assoluti: `${PWD}` è la root del workspace aperta in Cursor.
2. **`npm install -g context-mode@latest`** sull’host (CI / altro dev deve ripetere).
3. Cursor: **Developer → Reload Window** (o toggle server MCP) così viene letta la nuova config e la nuova versione globale `context-mode`.

Template generico copiabile: [`docs/wiki/_templates/mcp-minimum-stack.json`](../_templates/mcp-minimum-stack.json).

### Verifica (IDE / agent)

- Tool MCP `ctx_doctor` → tutti `[OK]`; dopo reload la **Version** deve combaciare con `npm list -g context-mode`.

---

## 📋 Cos’era stato sistemato (2026-05-12 baseline)

| Before | After |
|--------|-------|
| 419K tokens → API Error 400 | < 50K tokens per session |
| Pre-load all wiki files | Load on-demand via triggers |
| No compression | 98% compression via context-mode |
| Bun missing | Bun v1.3.13 installed (3-5x speedup) |

---

## ✅ Installation Checklist

- [x] **Bun runtime** — `npm install -g bun` → v1.3.13
- [ ] **context-mode** — mantenere `npm install -g context-mode@latest` (baseline doc: v1.0.151+)
- [x] **SQLite/FTS5** — verified working
- [x] **Hooks configured** — sessionstart, pretooluse, postcompact
- [x] **Knowledge base purged** — fresh start from 2026-05-12

---

## 📁 Documentation Created

### Root Level
- ✅ `docs/wiki/concepts/context-mode-optimal-configuration.md` — Best practices + config
- ✅ `docs/wiki/concepts/context-overflow-prevention.md` — Updated with Bun + v1.0.121
- ✅ `docs/wiki/rules/00-TRIGGER_MAP.md` — Updated with context-mode triggers

### Module Level
- ✅ `laravel/Modules/Xot/docs/wiki/concepts/context-mode-xot-discipline.md`
- ✅ `laravel/Modules/User/docs/wiki/concepts/context-mode-user-discipline.md`
- ✅ `laravel/Modules/Lang/docs/wiki/concepts/context-mode-lang-discipline.md`
- ✅ `laravel/Modules/Activity/docs/wiki/concepts/context-mode-activity-discipline.md`
- ✅ `laravel/Modules/Rating/docs/wiki/concepts/context-mode-rating-discipline.md`

### Theme Level
- ✅ `laravel/Themes/CONTEXT_MODE_TEMPLATE.md` — Template per tutti i temi

### Configuration
- ✅ `.env.context-mode.example` — Copy to `.env.local` and customize

---

## 🚀 Quick Start

### 1. File già presenti nel repo

| File | Ruolo |
|------|--------|
| `.cursor/mcp.json` | Server `context-mode` + stack minimo (playwright, puppeteer, token-optimizer, laravel-boost, qmd) |
| `.cursor/hooks.json` | Hook Cursor (`preToolUse`, `postToolUse`, `sessionStart`, `stop`, `afterAgentResponse`) |
| `.cursor/rules/context-mode.mdc` | Routing in contesto (obbligatorio su Cursor) |
| `.env.local` | Variabili `CONTEXT_MODE_*` (gitignored) |
| `.cursor/settings.json` | `"context-mode@context-mode": true` nel plugin |

### 2. Installazione host (una tantum)

```bash
bun add -g context-mode@latest   # preferito; oppure npm install -g context-mode@latest
export PATH="$HOME/.nvm/versions/node/v25.6.0/bin:$PATH"
cd "$(npm root -g)/context-mode" && npm rebuild better-sqlite3   # se doctor segnala FTS5 FAIL
context-mode upgrade --platform cursor   # dalla root repo
```

### 3. Verifica

```bash
bun --version
context-mode --version
# In chat agente: chiedere «ctx doctor» oppure usare tool MCP ctx_doctor
```

**Dopo upgrade:** riavviare Cursor (Reload Window) per allineare plugin MCP alla v1.0.151.

### 3. Load Rules On-Demand
```bash
# Never load everything
qmd search "context-mode" --limit 3

# Specific module
qmd search "xotbase resource zen" --limit 2
```

---

## 📏 Discipline Rules

### ✅ DO
- File wiki ≤ 500 righe (target: ≤ 200)
- Una idea per file
- `qmd search --limit 5` always
- Cross-link pages con `[[name]]`
- Load on-demand via triggers

### ❌ DON'T
- File wiki > 500 righe
- Embed regole in CLAUDE.md
- Pre-load intero `docs/wiki/`
