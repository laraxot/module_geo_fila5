---
title: "Code redundancy audit 2026-05-26"
type: source
status: draft
tags: [code-audit, redundancy, modules, themes, second-brain]
created: "2026-05-26"
updated: "2026-05-26"
issue: "https://github.com/provtv/base_ptv_fila5_mono/issues/150"
---

# Code redundancy audit 2026-05-26

## Sintesi

- Owner analizzati: 38
- Report locali scritti in `laravel/Modules/*/docs/code-redundancy-audit.md` e `laravel/Themes/*/docs/code-redundancy-audit.md`.
- Metodo: metriche statiche non distruttive; nessuna modifica funzionale al codice.

## Priorita'

- `module:UI` risk=high, cross_dup=20, big=7, markers=0
- `module:User` risk=high, cross_dup=19, big=6, markers=0
- `theme:One` risk=high, cross_dup=19, big=0, markers=0
- `theme:Zero` risk=high, cross_dup=19, big=0, markers=0
- `module:IndennitaResponsabilita` risk=high, cross_dup=7, big=4, markers=0
- `module:IndennitaCondizioniLavoro` risk=high, cross_dup=6, big=2, markers=0
- `module:Xot` risk=high, cross_dup=5, big=8, markers=0
- `module:Progressioni` risk=high, cross_dup=4, big=4, markers=0
- `module:Sigma` risk=high, cross_dup=3, big=8, markers=0
- `module:Performance` risk=high, cross_dup=3, big=7, markers=0
- `module:Media` risk=high, cross_dup=3, big=4, markers=0
- `module:Notify` risk=high, cross_dup=3, big=2, markers=0
- `module:Job` risk=high, cross_dup=3, big=1, markers=0
- `module:Pdnd` risk=high, cross_dup=2, big=4, markers=0
- `module:Tenant` risk=high, cross_dup=2, big=1, markers=0
- `module:Incentivi` risk=high, cross_dup=1, big=5, markers=0
- `module:DbForge` risk=high, cross_dup=0, big=5, markers=0
- `module:Badge` risk=medium, cross_dup=7, big=0, markers=0
- `module:Inail` risk=medium, cross_dup=7, big=0, markers=0
- `module:Legge104` risk=medium, cross_dup=7, big=0, markers=0

## Fonti web 2026 integrate

- HackerNoon Tip 020: note atomiche Markdown + YAML + link espliciti.
- Guide 2026 su Obsidian/AI: local-first Markdown + Git come second brain operativo.
- Studi 2026 su agent configuration: repo-level Markdown/JSON e skill manifest riducono drift se caricati on-demand.
- Ricerca 2026 su architecture descriptors: contesto architetturale navigabile riduce passi di localizzazione degli agenti.

## Gate

Docs-only audit. PHPStan/PHPMD/PHPInsights non eseguiti perche' non e' stato modificato codice PHP applicativo.
