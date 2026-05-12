---
title: "Context-Mode Optimal Configuration"
type: "rule"
tags: [context-mode, compression, token-budget, configuration]
created: 2026-05-12
updated: 2026-05-12
confidence: high
---

# Context-Mode Optimal Configuration

> Evita overflow contesto (419k tokens) mediante disciplina atomica.

## Problema Risolto

**Prima:** Contesto esplodeva a 419k quando limite è 262k  
**Causa:** Pre-caricamento di wiki troppo grandi senza limiti  
**Soluzione:** Context-mode v1.0.121 + Bun + atomic wiki loading

---

## 1. Installazione

```bash
# 1. Installa Bun (3-5x speedup)
npm install -g bun
bun --version

# 2. Verifica context-mode v1.0.121+
node "${CLAUDE_PLUGIN_ROOT}/hooks/sessionstart.mjs"
```

---

## 2. Configurazione Ambiente

Aggiungi a `.env.local` (gitignored):

```bash
# Context-mode
CONTEXT_MODE_MAX_FILE_BYTES=50000       # 50KB per file
CONTEXT_MODE_MAX_WIKI_ENTRIES=100       # Max 100 wiki entries
CONTEXT_MODE_AUTO_INDEX=true            # Auto-index on load
CONTEXT_MODE_FTS5_LIMIT=500             # Query limit default
CONTEXT_MODE_BATCH_CONCURRENCY=4        # Parallel batch commands

# Performance
NODE_RUNTIME=bun                        # Use Bun instead of Node
```

---

## 3. Atomic Wiki Discipline

### ✅ DO (Atomico)
- File wiki ≤ 500 righe
- Una idea per file
- Cross-link frequente (`[[name]]`)
- Separate INDEX.md per ogni sezione

### ❌ DON'T (Monolitico)
- File wiki > 500 righe
- "Comprehensive guides" in un file
- Embed tutto in CLAUDE.md
- Pre-caricamento di interi `docs/wiki/`

### Struttura Corretta

```
docs/wiki/
├── index.md                    # 30 righe max — porta di ingresso
├── rules/
│   ├── 00-TRIGGER_MAP.md      # ≤50 righe
│   ├── on-demand-pattern.md   # ≤200 righe
│   └── laraxot-module-namespace.md
├── concepts/
│   ├── context-mode-optimal-configuration.md  # ← questo file
│   ├── llm-wiki-operational-discipline.md
│   └── architecture-guardrails.md
├── skills/INDEX.md            # Link a skill folder
├── commands/INDEX.md
└── memories/INDEX.md

laravel/Modules/<Name>/docs/wiki/
├── index.md                   # Modulo-local catalog
├── rules/INDEX.md
├── skills/INDEX.md
└── concepts/
    └── <module>-specific-pattern.md
```

---

## 4. Context-Mode Tool Selection

| Attività | Tool | Perché |
|----------|------|--------|
| Esecuzione comando | `ctx_batch_execute` | Auto-index risultati |
| Ricerca follow-up | `ctx_search` | FTS5 rapido |
| Processing log | `ctx_execute_file` | Analizza senza toccare file |
| Fetch URL | `ctx_fetch_and_index` | Indicizza in sandbox |
| Index docs | `ctx_index` | Carica fonte di verità |

**VIETATO:** Bash per output >20 righe, Read per analisi, WebFetch per URL.

---

## 5. Query Best Practices

```bash
# ✅ Specifico (limitato)
qmd search "namespace modulo laraxot" --limit 5

# ✅ Multi-query una sola volta
ctx_search(queries: [
  "namespace rules",
  "filament conventions",
  "xotbase patterns"
], limit: 3)

# ❌ Query generica
qmd search "laravel"  # Too broad

# ❌ Carica tutto
qmd search ".*"       # Never
```

---

## 6. Purge & Reset

Se contesto explode ancora:

```bash
# Purge knowledge base
ctx_purge --confirm true

# Riprendi da zero con on-demand loading
qmd search "trigger map" --limit 1
```

---

## 7. Monitoraggio

```bash
# Status
ctx_stats

# Diagnostics
ctx_doctor

# Upgrade
ctx_upgrade
```

**Target:** < 50K token per session (context-mode mantiene sandbox separato)

---

## 8. Vedi anche

- [llm-wiki-operational-discipline](./llm-wiki-operational-discipline.md)
- [on-demand-pattern](../rules/on-demand-pattern.md)
- [00-TRIGGER_MAP](../rules/00-TRIGGER_MAP.md)
