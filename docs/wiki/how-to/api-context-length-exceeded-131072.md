---
title: "Errore API: maximum context length 131072 superato"
module: "ptvx-project"
type: how-to
status: approved
tags: [tokens, context-window, api, cursor, mcp, context-mode, compression]
created: "2026-05-20T00:00:00Z"
updated: "2026-05-20T00:00:00Z"
qmd: "131072 tokens context length exceeded compression plugin api error"
related:
  - "../concepts/context-overflow-prevention.md"
  - "../../../bashscripts/ai/rules/context-compression-discipline.md"
  - "../sources/context-compression-mcp-setup.md"
  - "context-mode-overflow-prevention.md"
  - "../../../docs/chat/context-api-131072-overflow.md"
  - "../_templates/cursor-mcp-starter.partial.json"
---

# Errore API: «maximum context length is 131072 tokens»

## Messaggio tipico

Testo come:

```text
This endpoint's maximum context length is 131072 tokens. However, you requested about N tokens
(X of text input, Y of tool input, Z in the output). Please reduce the length of either one,
or use the context-compression plugin to compress your prompt automatically.
```

Significa che il **backend del modello** (cap endpoint **128k token**, circa **131072**) riceve un payload **molto più grande**: nell’esempio reale del team circa **~796k token**, di cui la gran parte spesso in **text input** (cronologia, system/rules, allegati `@`) e una quota in **tool input** (output grezzo degli tool MCP prima di compressione).

## Lettura della diagnostica

| Voce | Cosa indica |
|------|-------------|
| **text input** | Prompt utente + history chat + istruzioni di sistema + file/rules sempre inclusi + contesto implicito IDE |
| **tool input** | Risultati di tool (lettura file, grep, MCP) aggregati nella richiesta |
| **output** | Riserva per la risposta del modello (spesso ~32k configurati dal client) |

Il problema **non** si risolve alzando solo il tetto «output»: bisogna **tagliare text + tool**.

## Azioni immediate (ordine consigliato)

1. **Nuova chat** con brief corto (file/path minimi, niente incolla di log giganti).
2. **Togli allegati pesanti**: niente `@`-glob su repo intero o cartelle enormi; pochi file mirati.
3. **Riduci rule sempre attive** (Cursor `.mdc` con `alwaysApply: true` giganti — nel repo è stato risolto il caso `laravel-boost.mdc`; vedere [`context-overflow-prevention.md`](../concepts/context-overflow-prevention.md)).
4. **Verifica stub Laravel (fix 2026-05-20):** `laravel/AGENTS.md` e `laravel/CLAUDE.md` devono restare stub ≤50 righe. Se superano ~100 righe, qualcuno ha re-incollato le linee guida: il monolite va solo in `laravel/*.embedded-rules.FULL.md.bak` (gitignored) e si legge a chunk.
5. **Meno tool in parallelo** e output sintetico (snippet + analisi locale), non dump multi-megabyte.
6. **Abilitare compressione contesto** lato MCP (vedi sotto).
7. Se il prodotto lo consente: **modello / modalità con finestra maggiore** (documentazione vendor aggiornata: es. [Cursor — Context / Max Mode](https://docs.cursor.com/context/max-mode)).

```bash
wc -l laravel/AGENTS.md laravel/CLAUDE.md AGENTS.md
# atteso: ciascuno ≤50 righe
```

## Compressione automatica (context-mode MCP)

Nel progetto la disciplina strumenti è descritta in [`bashscripts/ai/rules/context-compression-discipline.md`](../../../bashscripts/ai/rules/context-compression-discipline.md): uso di **context-mode** (`ctx_batch_execute`, `ctx_execute`, `ctx_search`, …) per tenere fuori dal contesto il grosso degli output.

**Installazione tipica (macchina di sviluppo):**

```bash
npm install -g context-mode@latest
```

**Cursor / MCP:** aggiungere un server MCP che esegue il binario `context-mode` (shape dipende dal client; verificare `mcp.json` locale — non tutti i path sono versionati in questo monorepo). Snippet concettuale:

```json
"context-mode": {
  "command": "context-mode",
  "args": []
}
```

Template parziale pronto da copienda (Playwright + Puppeteer + context-mode): [`docs/wiki/_templates/cursor-mcp-starter.partial.json`](../_templates/cursor-mcp-starter.partial.json).

Eseguire **`ctx doctor`** dopo l’installazione.

### Alternativa MCP (setup Cursor via `npx`)

Il progetto **[universal-context-mode](https://github.com/Phanindra208/universal-context-mode)** documenta `npx -y universal-context-mode setup cursor` per generare configurazione compressione — valutare se coesiste con context-mode senza duplicare gli stessi hook.

Eseguire **`ctx doctor`** dopo l’installazione (context-mode «ufficiale» usato nel repo).

## Letteratura esterna

- Discussione community: [Forum Cursor — context too large](https://forum.cursor.com/t/context-is-too-large-problem/60479).
- Cursor — contesto / modalità maggiore: [docs.cursor.com — Context](https://docs.cursor.com/context/max-mode).
- Panoramica su limiti pratici della finestra (ricerca web): «Cursor context window limitations».

## Aggiornamento della source «MCP setup»

Dettaglio storico installazioni nel repo: [`../sources/context-compression-mcp-setup.md`](../sources/context-compression-mcp-setup.md).

## Confronto tra agenti

Thread operativo e domande aperte: [`docs/chat/context-api-131072-overflow.md`](../../../docs/chat/context-api-131072-overflow.md).

## Riferimenti incrociati

- [Context Overflow Prevention (concept)](../concepts/context-overflow-prevention.md)
- [Context-mode overflow prevention](./context-mode-overflow-prevention.md)
