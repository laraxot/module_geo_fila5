---
title: documentazione modulo User
module: User
type: index
status: approved
tags: [documentation, readme, modulo, second-brain]
updated: "2026-05-27"
related:
  - ../README.md
---

# Documentazione — modulo User

> **Mappa knowledge base locale.** Il [README in root](../README.md) è la vetrina (valore, release, onboarding); questo file indica **dove** trovare regole, wiki e audit per chi sviluppa o per gli agenti AI.

## Scopo

User management module for the Laraxot ecosystem: authentication, roles, teams, tenants, and OAuth.

## Dove iniziare

- [Wiki locale](./wiki/index.md)
- [code redundancy audit](./code-redundancy-audit.md)
- [architecture rules](./architecture-rules.md)
- [agent edit discipline](./agent-edit-discipline.md)
- [agent confidence protocol](./agent-confidence-protocol.md)
- [second brain](./second-brain.md)


## Struttura tipica

```text
User/
├── README.md          ← vetrina (root package)
├── docs/
│   ├── README.md      ← questo indice
│   └── wiki/          ← second brain (se presente)
├── app/ o resources/
└── composer.json
```

## Namespace / confini

- Namespace: `Modules\User`
- Non duplicare qui la filosofia marketing: resta nel README root.

## Indice file in docs/ (root)

| Argomento | File |
| :--- | :--- |
| 00-index | [00-index.md](./00-index.md) |
| 2fa-guide | [2fa-guide.md](./2fa-guide.md) |
| 2fa | [2fa.md](./2fa.md) |
| BUSINESS-LOGIC-ANALYSIS | [BUSINESS-LOGIC-ANALYSIS.md](./BUSINESS-LOGIC-ANALYSIS.md) |
| BUSINESS-LOGIC-DEEP-DIVE | [BUSINESS-LOGIC-DEEP-DIVE.md](./BUSINESS-LOGIC-DEEP-DIVE.md) |
| BUSINESS_LOGIC_ANALYSIS | [BUSINESS_LOGIC_ANALYSIS.md](./BUSINESS_LOGIC_ANALYSIS.md) |
| MODEL-INHERITANCE-FIXES | [MODEL-INHERITANCE-FIXES.md](./MODEL-INHERITANCE-FIXES.md) |
| MODEL_INHERITANCE_FIXES | [MODEL_INHERITANCE_FIXES.md](./MODEL_INHERITANCE_FIXES.md) |
| ON-DEMAND-PATTERN | [ON-DEMAND-PATTERN.md](./ON-DEMAND-PATTERN.md) |
| PERFORMANCE-OPTIMIZATION | [PERFORMANCE-OPTIMIZATION.md](./PERFORMANCE-OPTIMIZATION.md) |
| PRODUCT_LAUNCH_PLAN | [PRODUCT_LAUNCH_PLAN.md](./PRODUCT_LAUNCH_PLAN.md) |
| PRODUCT_ROADMAP | [PRODUCT_ROADMAP.md](./PRODUCT_ROADMAP.md) |
| PRODUCT_STRATEGY | [PRODUCT_STRATEGY.md](./PRODUCT_STRATEGY.md) |
| PROJECT-STRUCTURE | [PROJECT-STRUCTURE.md](./PROJECT-STRUCTURE.md) |
| QMD-SETUP | [QMD-SETUP.md](./QMD-SETUP.md) |
| QUERY_OPTIMIZATION_ANALYSIS | [QUERY_OPTIMIZATION_ANALYSIS.md](./QUERY_OPTIMIZATION_ANALYSIS.md) |
| REDUNDANCY_ANALYSIS | [REDUNDANCY_ANALYSIS.md](./REDUNDANCY_ANALYSIS.md) |
| SPRINT_PLANNING | [SPRINT_PLANNING.md](./SPRINT_PLANNING.md) |
| USER_RESEARCH | [USER_RESEARCH.md](./USER_RESEARCH.md) |
| WIDGET-RENDERING-ANALYSIS | [WIDGET-RENDERING-ANALYSIS.md](./WIDGET-RENDERING-ANALYSIS.md) |
| accessor-delegation-pattern | [accessor-delegation-pattern.md](./accessor-delegation-pattern.md) |
| actions-path-convention | [actions-path-convention.md](./actions-path-convention.md) |
| actions-structure-1 | [actions-structure-1.md](./actions-structure-1.md) |
| actions-structure-2 | [actions-structure-2.md](./actions-structure-2.md) |
| actions-structure | [actions-structure.md](./actions-structure.md) |
| actions | [actions.md](./actions.md) |
| actions_structure | [actions_structure.md](./actions_structure.md) |
| activitylog-moderation-best-practices | [activitylog-moderation-best-practices.md](./activitylog-moderation-best-practices.md) |
| activitylog | [activitylog.md](./activitylog.md) |
| advanced-user-architecture | [advanced-user-architecture.md](./advanced-user-architecture.md) |
| agent-confidence-discipline | [agent-confidence-discipline.md](./agent-confidence-discipline.md) |
| agent-confidence-protocol | [agent-confidence-protocol.md](./agent-confidence-protocol.md) |
| agent-edit-discipline | [agent-edit-discipline.md](./agent-edit-discipline.md) |
| ai-methodologies | [ai-methodologies.md](./ai-methodologies.md) |
| analisi-metodi-duplicati | [analisi-metodi-duplicati.md](./analisi-metodi-duplicati.md) |
| analisi-metodiuplicati | [analisi-metodiuplicati.md](./analisi-metodiuplicati.md) |
| analysis | [analysis.md](./analysis.md) |
| architecture-rules | [architecture-rules.md](./architecture-rules.md) |
| architecture | [architecture.md](./architecture.md) |
| architecture_rules | [architecture_rules.md](./architecture_rules.md) |

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
