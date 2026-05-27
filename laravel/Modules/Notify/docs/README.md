---
title: documentazione modulo Notify
module: Notify
type: index
status: approved
tags: [documentation, readme, modulo, second-brain]
updated: "2026-05-27"
related:
  - ../README.md
---

# Documentazione — modulo Notify

> **Mappa knowledge base locale.** Il [README in root](../README.md) è la vetrina (valore, release, onboarding); questo file indica **dove** trovare regole, wiki e audit per chi sviluppa o per gli agenti AI.

## Scopo

Notification management module for the Laraxot ecosystem: email, SMS, WhatsApp, Telegram, and FCM push.

## Dove iniziare

- [Wiki locale](./wiki/index.md)
- [code redundancy audit](./code-redundancy-audit.md)
- [architecture rules](./architecture-rules.md)
- [agent edit discipline](./agent-edit-discipline.md)
- [agent confidence protocol](./agent-confidence-protocol.md)
- [second brain](./second-brain.md)


## Struttura tipica

```text
Notify/
├── README.md          ← vetrina (root package)
├── docs/
│   ├── README.md      ← questo indice
│   └── wiki/          ← second brain (se presente)
├── app/ o resources/
└── composer.json
```

## Namespace / confini

- Namespace: `Modules\Notify`
- Non duplicare qui la filosofia marketing: resta nel README root.

## Indice file in docs/ (root)

| Argomento | File |
| :--- | :--- |
| -repos | [-repos.md](./-repos.md) |
| 00-index | [00-index.md](./00-index.md) |
| ON-DEMAND-PATTERN | [ON-DEMAND-PATTERN.md](./ON-DEMAND-PATTERN.md) |
| PERFORMANCE-OPTIMIZATION | [PERFORMANCE-OPTIMIZATION.md](./PERFORMANCE-OPTIMIZATION.md) |
| PHPSTAN_FIXES | [PHPSTAN_FIXES.md](./PHPSTAN_FIXES.md) |
| PRODUCT_LAUNCH_PLAN | [PRODUCT_LAUNCH_PLAN.md](./PRODUCT_LAUNCH_PLAN.md) |
| PRODUCT_ROADMAP | [PRODUCT_ROADMAP.md](./PRODUCT_ROADMAP.md) |
| PRODUCT_STRATEGY | [PRODUCT_STRATEGY.md](./PRODUCT_STRATEGY.md) |
| PROJECT-STRUCTURE | [PROJECT-STRUCTURE.md](./PROJECT-STRUCTURE.md) |
| QMD-SETUP | [QMD-SETUP.md](./QMD-SETUP.md) |
| REDUNDANCY_ANALYSIS | [REDUNDANCY_ANALYSIS.md](./REDUNDANCY_ANALYSIS.md) |
| SPRINT_PLANNING | [SPRINT_PLANNING.md](./SPRINT_PLANNING.md) |
| USER_RESEARCH | [USER_RESEARCH.md](./USER_RESEARCH.md) |
| _repos | [_repos.md](./_repos.md) |
| _todo | [_todo.md](./_todo.md) |
| acronym-naming-conventions | [acronym-naming-conventions.md](./acronym-naming-conventions.md) |
| acronym_naming_conventions | [acronym_naming_conventions.md](./acronym_naming_conventions.md) |
| actions-calling-actions-pattern | [actions-calling-actions-pattern.md](./actions-calling-actions-pattern.md) |
| actions-calling-actions | [actions-calling-actions.md](./actions-calling-actions.md) |
| advanced-template-system | [advanced-template-system.md](./advanced-template-system.md) |
| agent-confidence-discipline | [agent-confidence-discipline.md](./agent-confidence-discipline.md) |
| agent-confidence-protocol | [agent-confidence-protocol.md](./agent-confidence-protocol.md) |
| agent-edit-discipline | [agent-edit-discipline.md](./agent-edit-discipline.md) |
| analisi-dettagliata-8 | [analisi-dettagliata-8.md](./analisi-dettagliata-8.md) |
| analisi-dettagliata | [analisi-dettagliata.md](./analisi-dettagliata.md) |
| analisi-miglioramenti | [analisi-miglioramenti.md](./analisi-miglioramenti.md) |
| analisi_completa | [analisi_completa.md](./analisi_completa.md) |
| analisi_dettagliata_4 | [analisi_dettagliata_4.md](./analisi_dettagliata_4.md) |
| analisi_dettagliata_6 | [analisi_dettagliata_6.md](./analisi_dettagliata_6.md) |
| analysis-dettagliata-2 | [analysis-dettagliata-2.md](./analysis-dettagliata-2.md) |
| analysis-dettagliata-3 | [analysis-dettagliata-3.md](./analysis-dettagliata-3.md) |
| analysis-dettagliata-5 | [analysis-dettagliata-5.md](./analysis-dettagliata-5.md) |
| analysis-dettagliata-7 | [analysis-dettagliata-7.md](./analysis-dettagliata-7.md) |
| analysis-dettagliata-8 | [analysis-dettagliata-8.md](./analysis-dettagliata-8.md) |
| analysis-dettagliata | [analysis-dettagliata.md](./analysis-dettagliata.md) |
| analysis-improvements | [analysis-improvements.md](./analysis-improvements.md) |
| analysis | [analysis.md](./analysis.md) |
| appointment-field-naming-issues | [appointment-field-naming-issues.md](./appointment-field-naming-issues.md) |
| appointment-field-namings | [appointment-field-namings.md](./appointment-field-namings.md) |
| appointment-notifications | [appointment-notifications.md](./appointment-notifications.md) |

## Collegamenti

- [README root (vetrina)](../README.md)
- [Xot (framework base)](../Xot/docs/README.md)
- [Wiki progetto](../../../../docs/wiki/README.md)
- [Standard README doppio](../../../../docs/wiki/standards/module-theme-readme-dual.md)

## Per agenti

1. Leggere scopo in questo file.
2. Aprire `docs/wiki/index.md` se esiste.
3. Seguire [disciplina issue GitHub](../../../../docs/wiki/how-to/github-issue-agent-discipline.md) prima di modifiche sostanziali.

## Panoramica estesa

- [overview-extended.md](./overview-extended.md) — contenuto storico da `readme.md` (kebab-case unificato)
