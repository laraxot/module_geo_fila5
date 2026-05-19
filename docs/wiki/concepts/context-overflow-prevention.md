---
title: "Context Overflow Prevention"
module: "ptvx-project"
type: concept
status: approved
tags: [tokens, context-window, compaction, cursor, mcp]
created: "2026-05-12T00:00:00Z"
updated: "2026-05-20T00:00:00Z"
qmd: "context overflow 262144 131072 compaction context-mode AGENTS stub"
related:
  - "../how-to/api-context-length-exceeded-131072.md"
  - "../how-to/context-mode-overflow-prevention.md"
  - "../../../bashscripts/ai/rules/context-compression-discipline.md"
---

# Context Overflow Prevention

## Errore API: limite endpoint 131072 vs richiesta enorme

Messaggio tipico (Anthropic-compat / vari client IDE):

`This endpoint's maximum context length is 131072 tokens. However, you requested about …`

Non è solo «Compaction exhausted»: è un **rifiuto hard** dell’API prima della risposta. La diagnosi elenca spesso **text input**, **tool input** e **output** riservato.

**Playbook dedicato (procedure e link esterni verificati):** [`../how-to/api-context-length-exceeded-131072.md`](../how-to/api-context-length-exceeded-131072.md).

**Discussione multi-agente:** [`../../docs/chat/context-api-131072-overflow.md`](../../docs/chat/context-api-131072-overflow.md).

---

## Root Cause

The 262144-token context limit is exceeded when AI tools pre-load large files into context. The primary culprit was `bashscripts/ai/AGENTS.md` at **204KB / 5349 lines** (~50K+ tokens) — a BMAD auto-generated file with embedded agent definitions.

## Definitive Fixes Applied 2026-05-12

### 1. AGENTS.md ridotto a stub (204KB → 18 lines)

Il file `bashscripts/ai/AGENTS.md` è stato sostituito da uno stub on-demand di 18 righe.
La fonte canonica dei BMAD agents rimane `.bmad-core/agents/`, caricabile on-demand via `*agent <name>`.

### 2. Merge conflicts risolti

- `bashscripts/ai/.agents/kilo.jsonc` — risolti conflitti `<<<<<<< HEAD` su `compaction.reserved`
- `bashscripts/ai/rules/context-compression-discipline.md` — risolti conflitti su sezione errore BMAD

### 3. context-mode MCP v1.0.121 installato e configurato + Bun runtime

`context-mode` è un plugin MCP che comprime automaticamente il contesto del 98% (315KB → 5.4KB).

**Installazione Bun (3-5x speedup):**
```bash
npm install -g bun
bun --version  # v1.3.13+
```

**Installazione context-mode:**
```bash
npm install -g context-mode@latest
context-mode --version  # v1.0.121+
```

**Configurazione MCP server** (in `mcp_config.json` e `mcp.json`):
```json
"context-mode": {
  "command": "context-mode",
  "args": [],
  "env": {}
}
```

**Plugin enabled** in `settings.json`:
```json
"enabledPlugins": {
  "context-mode@context-mode": true
}
```

**Comandi:**
| Comando | Azione |
|---------|--------|
| `ctx doctor` | Diagnostica setup |
| `ctx stats` | Metriche compressione |
| `ctx purge` | Reset knowledge base |
| `ctx upgrade` | Aggiorna context-mode |

### Verifica funzionamento

```bash
# Test MCP server
echo '{"jsonrpc":"2.0","id":1,"method":"initialize","params":{"protocolVersion":"2024-11-05","capabilities":{},"clientInfo":{"name":"test","version":"1.0"}}}' | timeout 5 context-mode

# Dovrebbe rispondere con capabilities (tools, resources, prompts)
```

## Regole per prevenire recurrence

1. **AGENTS.md sempre ≤50 righe** — mai embeddare regole, skills o agent definitions
2. **Wiki è single source of truth** — rules/skills/memories caricate on-demand via QMD
3. **context-mode MCP sempre attivo** — auto-compression durante compaction
4. **QMD search --limit 5** mai caricare più di 5 risultati per ricerca
5. **Bootstrap files ≤50 righe** — CLAUDE.md, GEMINI.md, QWEN.md, AGENTS.md
6. **Vietato `.cache/` dentro progetto** — usare `~/.cache/`

## Cursor IDE: «Compaction exhausted» (dopo 3 tentativi)

Messaggio tipico: `Compaction exhausted: context still exceeds model limits after 3 attempts`.

**Cosa significa:** il tentativo automatico di riassumere la conversazione per stare sotto il limite del modello **non è riuscito**: il payload (cronologia + allegati + output tool + regole sempre attive) resta troppo grande anche dopo più passate.

**Recovery immediata (ordine consigliato):**

1. **Nuova conversazione** e incolla solo un mini-brief (obiettivo, file chiave, stato, blocchi).
2. **Rimuovi** riferimenti globali pesanti (`@` su intere cartelle, codebase-wide, decine di file).
3. **Spezza il lavoro**: meno chiamate tool in parallelo; leggi file a chunk (`offset`/`limit`).
4. Se l’IDE lo offre, **azzera il contesto** della chat corrente prima di proseguire.
5. Valuta un **modello con finestra più ampia** o riduci overhead (meno tab/file nel contesto implicito).

**Prevenzione nel repo:**

1. **Regola compatta root:** `.cursor/rules/cursor-context-discipline.mdc` (`alwaysApply: true`, pochissime righe — unisce compaction + lock + reminder PHP).
2. **Causa ricorrente (fix 2026-05):** `laravel/.cursor/rules/laravel-boost.mdc` era un **monolite ~143k righe** con `alwaysApply: true` e riempiva il contesto da solo → sostituito con **stub**; contenuto storico spostato in `laravel/.cursor/laravel-boost-guidelines.FULL.mdc.bak` (**non** è una rule caricata da Cursor).
3. Altre rule `laravel/.cursor/rules/*.mdc` restano piccole; evitare di reintrodurre file megabyte in questa cartella con `alwaysApply: true`.

Per CLI/OpenCode e MCP vedi anche [context-overflow-prevention (rules)](../rules/context-overflow-prevention.md).

**Letture utili (esterno):**

- [Forum Cursor — «Context is too large»](https://forum.cursor.com/t/context-is-too-large-problem/60479)
- [Cursor — messaggi «condensed to fit»](https://forum.cursor.com/t/this-file-has-been-condensed-to-fit-in-context-message/128120)

## Trigger Map

| Trigger | Load |
|---------|------|
| Context overflow / API Error 400 / compaction error / **131072 endpoint limit** | `docs/wiki/concepts/context-overflow-prevention.md`, `docs/wiki/how-to/api-context-length-exceeded-131072.md` |
| AGENTS.md troppo grande / riduzione context | `bashscripts/tools/prompts/llm-wiki.txt` §16 |
| context-mode / ctx doctor / compressione | `bashscripts/ai/rules/context-compression-discipline.md` |
