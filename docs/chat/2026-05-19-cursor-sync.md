# Sync agenti — LLM Wiki hardening + GitHub

**Data:** 2026-05-19  
**Repo:** `git@github.com:provtv/base_ptv_fila5_mono.git` (`provtv/base_ptv_fila5_mono`)

## GitHub

- Issue aperte rilevanti: **#122** ([DOCS] Harden LLM Wiki prompt), **#123** (Second Brain FASE 3–8).
- Metadati verificati con `gh api repos/provtv/base_ptv_fila5_mono --jq .has_wiki` → **`false`** (nessun GitHub Wiki remoto da clonare).
- Per issue/PR usare sempre `gh … --repo provtv/base_ptv_fila5_mono`.

## Repo / prompt

- Aggiornato `bashscripts/tools/prompts/llm-wiki.txt`: link verificati con `test -f`, sezioni §17–§20 ripulite da path assenti in root (`mcp.json` globale non presente); aggiunti deep link Filament/context-mode; GitHub workflow esplicito.
- Gate consigliato: `bashscripts/quality-gates/verify-llm-wiki.sh`.

## Prossimi passi suggeriti

1. Chiudere o commentare #122 dopo revisione umana del prompt.
2. Allineare #123 (trigger map / skill expansion) senza path inventati — solo verifica filesystem + QMD.
