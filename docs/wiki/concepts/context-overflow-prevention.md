# Context Overflow Prevention

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

## Trigger Map

| Trigger | Load |
|---------|------|
| Context overflow / API Error 400 / compaction error | `docs/wiki/concepts/context-overflow-prevention.md` |
| AGENTS.md troppo grande / riduzione context | `bashscripts/tools/prompts/llm-wiki.txt` §16 |
| context-mode / ctx doctor / compressione | `bashscripts/ai/rules/context-compression-discipline.md` |
