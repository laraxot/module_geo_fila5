---
title: standard readme doppio modulo e tema
module: ptvx-project
type: standard
status: approved
tags: [readme, module, theme, documentation, second-brain]
created: "2026-05-27"
updated: "2026-05-27"
related:
  - ./module-theme-release-showcase-standard.md
  - ../rules/markdown-documentation-standard.md
  - ../how-to/module-wiki-documentation.md
---

# README doppio — root e docs

Ogni **modulo** (`laravel/Modules/*`) e ogni **tema** (`laravel/Themes/*`) deve avere **due** `README.md` con ruoli distinti.

| Posizione | Ruolo | Pubblico | Contenuto tipico |
|-----------|--------|----------|------------------|
| **Root** `README.md` | Vetrina / prodotto | visitatori repo, PM, onboarding rapido | valore, release, link essenziali, filosofia breve |
| **`docs/README.md`** | Mappa knowledge base | sviluppatori, agenti AI | scopo tecnico, struttura `docs/`, wiki, audit, dipendenze |

## Regole

1. **Mai** duplicare paragrafi lunghi tra i due file: la root punta a `docs/README.md`.
2. Nella root, sezione obbligatoria (o equivalente): link a `./docs/README.md`.
3. In `docs/README.md`, link obbligatorio a `../README.md` (vetrina).
4. Nomi file: solo `README.md` (maiuscolo) — eccezione ammessa dallo standard markdown.
5. Aggiornare `docs/README.md` quando cambia lo scopo del modulo o l’indice wiki.

## Template operativo

- Generazione/aggiornamento batch: `bashscripts/tools/sync-module-theme-readmes.mjs`
- Vetrina marketing: [module-theme-release-showcase-standard.md](./module-theme-release-showcase-standard.md)

## Vedi anche

- [Standard markdown](../rules/markdown-documentation-standard.md)
- [Audit documentazione moduli](../how-to/module-docs-audit.md)
