---
title: "Rules Index"
type: "index"
tags: [rules, trigger-map, on-demand]
module: "root"
updated: 2026-05-26
---

# Rules — Root Wiki

> Passa prima dalla **Trigger Map**; questa pagina resta solo sommario.

## Routes

- [response-style-sintetico-conciso-italiano](../memories/response-style-sintetico-conciso-italiano.md) — **regola permanente**: tutti gli agenti devono rispondere sempre in italiano, sintetico e conciso (massima priorità)
- [00-TRIGGER_MAP](./00-TRIGGER_MAP.md) — routing canonico trigger → wiki; prima riga **BOOTSTRAP SESSIONE AGENTE** = pacchetto disciplina caricato sempre prima delle modifiche
- [on-demand-pattern](./on-demand-pattern.md) — LLM Wiki, rules, skills, QMD loading
- [bmad-v6-on-demand](./bmad-v6-on-demand.md) — BMAD Method v6 installato a livello progetto in `.claude/`; routing comando/skill/helper solo on-demand
- [validation-post-edit-rule](./validation-post-edit-rule.md) — mutex `file.ext.lock` affiancato + PHPStan / PHPMD (`laravel/tools`) / PHPInsights / E2E globale
- [github-issue-agent-discipline](../how-to/github-issue-agent-discipline.md) — issue GitHub come audit trail + `gh`; complementare alla wiki
- [autocompact-thrashing-discipline](./autocompact-thrashing-discipline.md) — **disciplina obbligatoria automatica** (trigger map + runtime-telemetry). Caricamento automatico su segnale thrashing.
- [module-theme-release-showcase-standard](../standards/module-theme-release-showcase-standard.md) — **obbligatorio**: GitHub Action semantic versioning + auto-release + changelog + README marketing "vetrina" con backlink relativi in ogni modulo e tema
- [kilo-autocompact-thrashing-prevention](../how-to/kilo-autocompact-thrashing-prevention.md) — alias storico Kilo-specifico (non usare come primario)
- [laraxot-module-namespace](./laraxot-module-namespace.md) — module namespace without `app`
- [filament-rules-summary](./filament-rules-summary.md), [xotbase-critical-rules](./xotbase-critical-rules.md), [schema-conventions](./schema-conventions.md), [ai-guidelines](./ai-guidelines.md), [filament-resource-property](./filament-resource-property.md) — Filament/XotBase rules
- [git-atomic-operations](./git-atomic-operations.md), [rule-atomicity](./rule-atomicity.md) — git forward-only + one-idea-per-rule

Usage: `qmd search "rule:<topic>" --limit 5`
