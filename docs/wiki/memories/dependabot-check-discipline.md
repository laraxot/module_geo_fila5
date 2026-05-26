---
title: "Dependabot — controllo obbligatorio periodico"
type: memory
status: approved
tags: [dependabot, dependencies, ci, security, permanent-rule]
created: "2026-05-26"
updated: "2026-05-26"
qmd: "dependabot security laraxot module_fila5 alert vite npm"
related:
  - "../how-to/dependabot-discipline.md"
  - "../rules/00-TRIGGER_MAP.md"
---

# Dependabot — regola permanente

## Regola

**Priorità massima** — non solo mono `provtv/*`, ma **ogni** `laraxot/module_*_fila5` (e temi pubblicati):

1. Eseguire `bashscripts/ci/dependabot-security-repos.sh` — elenca alert OPEN con link diretti.
2. Per ogni alert: merge PR `app/dependabot` **o** bump locale + push subtree.
3. Modulo con `package.json` → ecosystem **npm** in `.github/dependabot.yml`.
4. Dopo fix remoto, allineare `laravel/Modules/<Modulo>/` nel mono.

## Esempio canonico

- [module_dbforge_fila5 — Dependabot alert #1 (vite)](https://github.com/laraxot/module_dbforge_fila5/security/dependabot/1)
- [PR Dependabot DbForge](https://github.com/laraxot/module_dbforge_fila5/pulls/app%2Fdependabot)

## Perché

Alert Security restano OPEN se il mono non sincronizza il repo pubblicato — falsa sensazione di «già mergiato».

## Propagazione

- `.cursor/rules/dependabot-discipline.mdc`
- `bashscripts/ci/dependabot-security-repos.sh`
- TRIGGER_MAP + `llm-wiki.txt` §0
