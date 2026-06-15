---
title: documentazione modulo Progressioni
module: Progressioni
type: index
status: approved
tags: [documentation, readme, modulo, second-brain]
updated: "2026-05-27"
related:
  - ../README.md
---

# Documentazione — modulo Progressioni

> **Mappa knowledge base locale.** Il [README in root](../README.md) è la vetrina (valore, release, onboarding); questo file indica **dove** trovare regole, wiki e audit per chi sviluppa o per gli agenti AI.

## Scopo

Career progression management module for the Laraxot ecosystem: promotions, salary advancements, and professional development tracking.

## Dove iniziare

- [Wiki locale](./wiki/index.md)
- [code redundancy audit](./code-redundancy-audit.md)
- [architecture rules](./architecture-rules.md)
- [agent edit discipline](./agent-edit-discipline.md)
- [agent confidence protocol](./agent-confidence-protocol.md)
- [second brain](./second-brain.md)


## Struttura tipica

```text
Progressioni/
├── README.md          ← vetrina (root package)
├── docs/
│   ├── README.md      ← questo indice
│   └── wiki/          ← second brain (se presente)
├── app/ o resources/
└── composer.json
```

## Namespace / confini

- Namespace: `Modules\Progressioni`
- Non duplicare qui la filosofia marketing: resta nel README root.

## Indice file in docs/ (root)

| Argomento | File |
| :--- | :--- |
| 00-index | [00-index.md](./00-index.md) |
| activity-log-override-rationale | [activity-log-override-rationale.md](./activity-log-override-rationale.md) |
| agent-confidence-discipline | [agent-confidence-discipline.md](./agent-confidence-discipline.md) |
| agent-confidence-protocol | [agent-confidence-protocol.md](./agent-confidence-protocol.md) |
| agent-edit-discipline | [agent-edit-discipline.md](./agent-edit-discipline.md) |
| architecture-rules | [architecture-rules.md](./architecture-rules.md) |
| code-redundancy-audit | [code-redundancy-audit.md](./code-redundancy-audit.md) |
| compila-scheda-fix | [compila-scheda-fix.md](./compila-scheda-fix.md) |
| confidence_guidelines | [confidence_guidelines.md](./confidence_guidelines.md) |
| database-connection-progressione | [database-connection-progressione.md](./database-connection-progressione.md) |
| docs-archive-policy | [docs-archive-policy.md](./docs-archive-policy.md) |
| filament-resource-navigation | [filament-resource-navigation.md](./filament-resource-navigation.md) |
| filament-resource-schemas-tables | [filament-resource-schemas-tables.md](./filament-resource-schemas-tables.md) |
| filament-resource-wire-assenze | [filament-resource-wire-assenze.md](./filament-resource-wire-assenze.md) |
| filament-v4-upgrade | [filament-v4-upgrade.md](./filament-v4-upgrade.md) |
| filament-version | [filament-version.md](./filament-version.md) |
| group-column-usage | [group-column-usage.md](./group-column-usage.md) |
| html-parsing-error-fix | [html-parsing-error-fix.md](./html-parsing-error-fix.md) |
| html-validation-script | [html-validation-script.md](./html-validation-script.md) |
| html2pdf-migration-guide | [html2pdf-migration-guide.md](./html2pdf-migration-guide.md) |
| laravel-13-upgrade | [laravel-13-upgrade.md](./laravel-13-upgrade.md) |
| launch-plan | [launch-plan.md](./launch-plan.md) |
| mailtemplate-resource-integration | [mailtemplate-resource-integration.md](./mailtemplate-resource-integration.md) |
| override-vs-duplication | [override-vs-duplication.md](./override-vs-duplication.md) |
| pdf-view-translation-bug-fix | [pdf-view-translation-bug-fix.md](./pdf-view-translation-bug-fix.md) |
| phpstan-analysis-complete-summary | [phpstan-analysis-complete-summary.md](./phpstan-analysis-complete-summary.md) |
| phpstan-analysis | [phpstan-analysis.md](./phpstan-analysis.md) |
| phpstan-errors-analysis | [phpstan-errors-analysis.md](./phpstan-errors-analysis.md) |
| phpstan-errors-roadmap | [phpstan-errors-roadmap.md](./phpstan-errors-roadmap.md) |
| phpstan-errors-systematic-fix-plan | [phpstan-errors-systematic-fix-plan.md](./phpstan-errors-systematic-fix-plan.md) |
| phpstan-fixes-summary | [phpstan-fixes-summary.md](./phpstan-fixes-summary.md) |
| phpstan-typing-strategy | [phpstan-typing-strategy.md](./phpstan-typing-strategy.md) |
| prd | [prd.md](./prd.md) |
| product-requirements | [product-requirements.md](./product-requirements.md) |
| release-marketing-standard | [release-marketing-standard.md](./release-marketing-standard.md) |
| rename-schede-to-scheda | [rename-schede-to-scheda.md](./rename-schede-to-scheda.md) |
| roadmap | [roadmap.md](./roadmap.md) |
| schedacriteri-resource-fix | [schedacriteri-resource-fix.md](./schedacriteri-resource-fix.md) |
| schema | [schema.md](./schema.md) |
| second-brain | [second-brain.md](./second-brain.md) |
| sprint-planning | [sprint-planning.md](./sprint-planning.md) |
| strategy | [strategy.md](./strategy.md) |
| translation-array-error-prevention | [translation-array-error-prevention.md](./translation-array-error-prevention.md) |

## Collegamenti

- [README root (vetrina)](../README.md)
- [Xot (framework base)](../Xot/docs/README.md)
- [Wiki progetto](../../../../docs/wiki/README.md)
- [Standard README doppio](../../../../docs/wiki/standards/module-theme-readme-dual.md)

## Per agenti

1. Leggere scopo in questo file.
2. Aprire `docs/wiki/index.md` se esiste.
3. Seguire [disciplina issue GitHub](../../../../docs/wiki/how-to/github-issue-agent-discipline.md) prima di modifiche sostanziali.
