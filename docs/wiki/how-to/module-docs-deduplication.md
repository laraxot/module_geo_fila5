---
title: "deduplica documentazione moduli e temi"
type: how-to
tags: [docs, dry, second-brain, deduplication]
created: 2026-05-21
updated: 2026-05-21
related:
  - "../concepts/second-brain-operating-model.md"
  - "../concepts/second-brain-audit-checks.md"
  - "./github-issue-agent-discipline.md"
  - "../../../bashscripts/tools/dedup_module_docs.py"
---

# Deduplica documentazione moduli e temi

## Scopo

Ridurre copie identiche e policy propagate in `laravel/Modules/*/docs` e `laravel/Themes/*/docs`, mantenendo **un puntatore per modulo/tema** verso la fonte canonica (wiki root, Xot, Media).

Issue di riferimento: [#124](https://github.com/provtv/base_ptv_fila5_mono/issues/124).

## Canonici

| Argomento | Percorso canonico |
|-----------|-------------------|
| Html2Pdf | `laravel/Modules/Media/docs/html2pdf/` |
| Concetti wiki cross-modulo | `laravel/Modules/Xot/docs/wiki/concepts/` |
| Policy agent / GitHub | `docs/wiki/how-to/github-issue-agent-discipline.md` |
| Overflow contesto | `docs/wiki/concepts/context-overflow-prevention.md` |
| Second brain | `docs/wiki/concepts/second-brain-operating-model.md` |

Nei altri moduli/temi: file **stub** (front matter + link), non paragrafi interi.

## Tool

```bash
# Anteprima
python3 bashscripts/tools/dedup_module_docs.py --dry-run

# Esecuzione (genera report)
python3 bashscripts/tools/dedup_module_docs.py --execute
```

Report: `bashscripts/tools/dedup_module_docs_report.txt`.

Complementare: `python3 bashscripts/tools/cleanup_docs.py` (suffissi `_1.md` identici).

## Regole operative

1. **Non** creare nuove cartelle `docs/`; lavorare solo in quelle esistenti.
2. Nomi file in minuscolo kebab-case; eccezione `README.md`.
3. Dopo una campagna dedup: append in `docs/wiki/log.md` e nel `docs/wiki/log.md` del modulo owner (Xot / Media).
4. Commentare o chiudere checklist su issue #124.

## Campagna 2026-05-21

- ~2807 file eliminati (MD5 duplicati, path `app/`, `legacy/`, `source/docs`, html2pdf fuori Media).
- ~349 stub html2pdf / wiki concepts / policy globale.
- ~5 rinomine `_N.md` → base quando l’originale mancava.

Residuo atteso: gruppi MD5=2 con basenames diversi (revisione manuale o seconda passata conservativa).

## Riferimenti modulo

- Xot: [../../../laravel/Modules/Xot/docs/docs-deduplication.md](../../../laravel/Modules/Xot/docs/docs-deduplication.md)
- Media (html2pdf): [../../../laravel/Modules/Media/docs/html2pdf/README.md](../../../laravel/Modules/Media/docs/html2pdf/README.md)
