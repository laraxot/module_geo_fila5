---
title: "Dependabot Audit Permanent Discipline"
module: "ptvx-project"
type: memory
status: approved
tags: [dependabot, security, dependencies, permanent-discipline, standing-order]
created: "2026-05-26"
updated: "2026-05-26"
qmd: "dependabot permanent discipline alerts modules themes"
related:
  - "../how-to/github-issue-agent-discipline.md"
  - "../rules/00-TRIGGER_MAP.md"
---

# Dependabot Audit Permanent Discipline

## Standing Order (Non-Negotiable)
**Dependabot alerts are important and must be regularly checked and remediated** for:
- Main monorepo (`provtv/base_ptv_fila5_mono`)
- All published Laraxot modules (`laraxot/module_*_fila5`)
- All themes (if they have separate repositories with dependencies)

This applies to **this agent and all future AI agents**.

## Why It Matters
- Security vulnerabilities (e.g. Vite path traversal, as seen in module_dbforge_fila5)
- Outdated packages leading to maintenance debt
## Multi-Agent Coordination Protocol (Improved Version)

Quando lo stesso task ampio (Dependabot remediation, PHPStan fixes, ecc.) viene assegnato a più agenti AI, si applica questo protocollo per evitare duplicati e mantenere audit trail puliti.

### 1. Per-module/theme repo discipline
- `cd` nella cartella del modulo/tema
- `git remote -v` → usa la repo pubblicata (es. `laraxot/module_dbforge_fila5`)
- Tutto il coordinamento e l'audit trail per quel modulo **deve** avvenire nelle issue di **quella repo**, non solo nel monorepo.

### 2. Lock tramite issue di coordinamento
- Prima di iniziare lavoro pesante su un modulo/tema (es. `phpstan analyse` o fix batch Dependabot), cerca issue con titolo standard:
  `[AGENT-COORD] <Task> - <NomeModulo/Tema>`
- Se non esiste, creala tu (funge da lock distribuito).
- Un solo agente alla volta “claima” l’issue.
- Linka sempre all’issue standing-order principale del monorepo (es. #154 per Dependabot).

### 3. Regola PHPStan (obbligatoria)
PHPStan va lanciato **sempre** dalla root `laravel/` del monorepo:
```
./vendor/bin/phpstan analyse Modules/<NomeModulo>
```
Mai da dentro la cartella del modulo.

### 4. Documentazione
Nel `docs/wiki/` del modulo/tema registra il numero dell’issue di coordinamento e l’esito.

Questo protocollo si applica a tutti i task pesanti assegnati a più agenti e garantisce zero sovrapposizioni su 30+ repo di moduli/temi.
- Compliance and reputation for published packages

## How to Execute
1. Use `gh api repos/OWNER/REPO/dependabot/alerts` (with `--paginate` for many alerts)
2. Filter by state=`open` and severity
3. For each alert:
   - Investigate the vulnerable dependency
   - Create PR to update (preferred)
   - Or dismiss with clear justification + comment on the alert
4. Update the relevant module/theme docs/wiki if a fix has architectural impact
5. Comment progress on the permanent GitHub issue (see below)

## Permanent Audit Trail
All work on this discipline is tracked on GitHub issue:
https://github.com/provtv/base_ptv_fila5_mono/issues/154

## Enforcement in Second Brain
- This memory is loaded automatically via TRIGGER_MAP when "dependabot" is mentioned
- The rule is also injected at high priority in `bashscripts/tools/prompts/llm-wiki.txt`
- Every agent must treat this as a recurring standing task, not a one-off

## Frequency
- At the start of any session involving dependencies or security
- Before publishing any module or theme
- At minimum once per week when active development is happening

**Never leave Dependabot alerts unaddressed.**
