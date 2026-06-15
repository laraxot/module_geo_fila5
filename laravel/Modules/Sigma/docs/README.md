---
title: documentazione modulo Sigma
module: Sigma
type: index
status: approved
tags: [documentation, readme, modulo, second-brain]
updated: "2026-05-27"
related:
  - ../README.md
---

# Documentazione — modulo Sigma

> **Mappa knowledge base locale.** Il [README in root](../README.md) è la vetrina (valore, release, onboarding); questo file indica **dove** trovare regole, wiki e audit per chi sviluppa o per gli agenti AI.

## Scopo

Sigma HR system integration module for the Laraxot ecosystem: data import/export, payroll sync, and external HR software interoperability.

## Dove iniziare

- [Wiki locale](./wiki/index.md)
- [code redundancy audit](./code-redundancy-audit.md)
- [architecture rules](./architecture-rules.md)
- [agent edit discipline](./agent-edit-discipline.md)
- [agent confidence protocol](./agent-confidence-protocol.md)
- [second brain](./second-brain.md)


## Struttura tipica

```text
Sigma/
├── README.md          ← vetrina (root package)
├── docs/
│   ├── README.md      ← questo indice
│   └── wiki/          ← second brain (se presente)
├── app/ o resources/
└── composer.json
```

## Namespace / confini

- Namespace: `Modules\Sigma`
- Non duplicare qui la filosofia marketing: resta nel README root.

## Indice file in docs/ (root)

| Argomento | File |
| :--- | :--- |
| accessor-delegation-audit | [accessor-delegation-audit.md](./accessor-delegation-audit.md) |
| accessor-delegation-complete-guide | [accessor-delegation-complete-guide.md](./accessor-delegation-complete-guide.md) |
| accessor-delegation-pattern | [accessor-delegation-pattern.md](./accessor-delegation-pattern.md) |
| accessor-getkey-check-final-summary | [accessor-getkey-check-final-summary.md](./accessor-getkey-check-final-summary.md) |
| accessor-getkey-check-pattern | [accessor-getkey-check-pattern.md](./accessor-getkey-check-pattern.md) |
| accessor-helper-audit-complete | [accessor-helper-audit-complete.md](./accessor-helper-audit-complete.md) |
| accessor-helper-pattern | [accessor-helper-pattern.md](./accessor-helper-pattern.md) |
| accessor-helper-status-report-final | [accessor-helper-status-report-final.md](./accessor-helper-status-report-final.md) |
| accessor-mutator-philosophy | [accessor-mutator-philosophy.md](./accessor-mutator-philosophy.md) |
| accessor-pattern-correct | [accessor-pattern-correct.md](./accessor-pattern-correct.md) |
| accessor-refactoring-philosophy | [accessor-refactoring-philosophy.md](./accessor-refactoring-philosophy.md) |
| accessor-refactoring-roadmap | [accessor-refactoring-roadmap.md](./accessor-refactoring-roadmap.md) |
| agent-confidence-discipline | [agent-confidence-discipline.md](./agent-confidence-discipline.md) |
| agent-confidence-protocol | [agent-confidence-protocol.md](./agent-confidence-protocol.md) |
| agent-edit-discipline | [agent-edit-discipline.md](./agent-edit-discipline.md) |
| analysis-report | [analysis-report.md](./analysis-report.md) |
| architecture-dry-kiss | [architecture-dry-kiss.md](./architecture-dry-kiss.md) |
| architecture-rules | [architecture-rules.md](./architecture-rules.md) |
| architecture | [architecture.md](./architecture.md) |
| bugfix-accessor-save-pattern | [bugfix-accessor-save-pattern.md](./bugfix-accessor-save-pattern.md) |
| bugfix-import-json-action | [bugfix-import-json-action.md](./bugfix-import-json-action.md) |
| business-logic-analysis | [business-logic-analysis.md](./business-logic-analysis.md) |
| business-logic | [business-logic.md](./business-logic.md) |
| code-quality-improvements | [code-quality-improvements.md](./code-quality-improvements.md) |
| code-redundancy-audit | [code-redundancy-audit.md](./code-redundancy-audit.md) |
| comprehensive-analysis | [comprehensive-analysis.md](./comprehensive-analysis.md) |
| confidence_guidelines | [confidence_guidelines.md](./confidence_guidelines.md) |
| consolidation-plan | [consolidation-plan.md](./consolidation-plan.md) |
| current-quality-status | [current-quality-status.md](./current-quality-status.md) |
| deep-analysis | [deep-analysis.md](./deep-analysis.md) |
| duplicate-methods-census | [duplicate-methods-census.md](./duplicate-methods-census.md) |
| docs-archive-policy | [docs-archive-policy.md](./docs-archive-policy.md) |
| filament-version | [filament-version.md](./filament-version.md) |
| fix-accessor-save-pattern | [fix-accessor-save-pattern.md](./fix-accessor-save-pattern.md) |
| fix-duplicate-entry-error-summary | [fix-duplicate-entry-error-summary.md](./fix-duplicate-entry-error-summary.md) |
| fixes-applied | [fixes-applied.md](./fixes-applied.md) |
| git-conflicts-inventory | [git-conflicts-inventory.md](./git-conflicts-inventory.md) |
| laravel-13-upgrade | [laravel-13-upgrade.md](./laravel-13-upgrade.md) |
| launch-plan | [launch-plan.md](./launch-plan.md) |
| mago-rector-tools | [mago-rector-tools.md](./mago-rector-tools.md) |
| module-dependencies | [module-dependencies.md](./module-dependencies.md) |

## Collegamenti

- [README root (vetrina)](../README.md)
- [Xot (framework base)](../Xot/docs/README.md)
- [Wiki progetto](../../../../docs/wiki/README.md)
- [Standard README doppio](../../../../docs/wiki/standards/module-theme-readme-dual.md)

## Per agenti

1. Leggere scopo in questo file.
2. Aprire `docs/wiki/index.md` se esiste.
3. Seguire [disciplina issue GitHub](../../../../docs/wiki/how-to/github-issue-agent-discipline.md) prima di modifiche sostanziali.
