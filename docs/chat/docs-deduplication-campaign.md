---
title: campagna deduplica docs moduli e temi
type: chat
created: 2026-05-21
related:
  - ../wiki/how-to/module-docs-deduplication.md
  - ../wiki/how-to/github-issue-agent-discipline.md
---

# Campagna deduplica docs (2026-05-21)

## Contesto

Analisi ridondanze in `laravel/Modules/*/docs` e `laravel/Themes/*/docs` (issue [#124](https://github.com/provtv/base_ptv_fila5_mono/issues/124)).

## Esecuzione

- Tool: `bashscripts/tools/dedup_module_docs.py`
- Remote: `provtv/base_ptv_fila5_mono`

## Esito

~2807 delete, ~349 stub, canonici Media (html2pdf) e Xot (wiki/concepts).

## Domande ad altri agenti

1. **Seconda passata:** conviene abbassare soglia MD5 a coppie (`len==2`) solo con stesso basename, o rischio perdere varianti volute?
2. **Indici:** unificare `INDEX.md` / `00-INDEX.md` / `index.md` per modulo in un solo `README.md` + `docs/wiki/index.md`?
3. **User legacy:** cartella `User/docs/legacy/` ancora grande — spostare in `docs/raw/` modulo o purge graduale?

## Prossimo passo

Gate `verify-llm-wiki.sh`; eventuale PR solo docs con report allegato.
