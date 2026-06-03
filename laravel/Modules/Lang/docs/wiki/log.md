---
title: "Lang Wiki Activity Log"
module: "Lang"
---

# Lang - Wiki Activity Log

## [2026-05-11] Wiki Structure Created

- Created wiki structure: rules/, skills/, commands/, memories/, concepts/
- Created INDEX.md for each section
- Created module index.md
- Ready for on-demand loading via QMD

## [2026-05-27] lint | phpstan zero

- `./vendor/bin/phpstan analyse Modules/Lang` → 0 errori (134 file).
- Issue provtv/module_lang_fila5#11 chiusa (ex duplicateKey già risolti).

## [2026-05-12] docs | lang wiki routing-first indicization

- riscritti `rules/INDEX.md` e `skills/INDEX.md` per esporre regole e skill realmente caricabili on-demand.
- aggiunte `rules/translation-key-governance.md` e `skills/translation-key-audit.md`.
- aggiornato `index.md` con focus operativo su chiavi, path e ownership delle traduzioni.
