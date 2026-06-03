---
title: documentazione tema Zero
module: Zero
type: index
status: approved
tags: [documentation, readme, tema, second-brain]
updated: "2026-05-27"
related:
  - ../README.md
---

# Documentazione — tema Zero

> **Mappa knowledge base locale.** Il [README in root](../README.md) è la vetrina (valore, release, onboarding); questo file indica **dove** trovare regole, wiki e audit per chi sviluppa o per gli agenti AI.

## Scopo

Zero theme for Laraxot PTVX: frontend theme with Tailwind, Vite, Flowbite and Alpine.js integration.

## Dove iniziare

- [Wiki locale](./wiki/index.md)
- [code redundancy audit](./code-redundancy-audit.md)
- [architecture rules](./architecture-rules.md)
- [agent edit discipline](./agent-edit-discipline.md)
- [agent confidence protocol](./agent-confidence-protocol.md)
- [second brain](./second-brain.md)


## Struttura tipica

```text
Zero/
├── README.md          ← vetrina (root package)
├── docs/
│   ├── README.md      ← questo indice
│   └── wiki/          ← second brain (se presente)
├── app/ o resources/
└── composer.json
```

## Namespace / confini

- Namespace: `Themes\Zero`
- Non duplicare qui la filosofia marketing: resta nel README root.

## Indice file in docs/ (root)

| Argomento | File |
| :--- | :--- |
| 00-index | [00-index.md](./00-index.md) |
| CONFLICT_RESOLUTION_SUMMARY | [CONFLICT_RESOLUTION_SUMMARY.md](./CONFLICT_RESOLUTION_SUMMARY.md) |
| accessor-delegation-pattern | [accessor-delegation-pattern.md](./accessor-delegation-pattern.md) |
| agent-confidence-discipline | [agent-confidence-discipline.md](./agent-confidence-discipline.md) |
| agent-confidence-protocol | [agent-confidence-protocol.md](./agent-confidence-protocol.md) |
| agent-edit-discipline | [agent-edit-discipline.md](./agent-edit-discipline.md) |
| ai-development-guide | [ai-development-guide.md](./ai-development-guide.md) |
| ai-handoff | [ai-handoff.md](./ai-handoff.md) |
| analisi-completa-tema | [analisi-completa-tema.md](./analisi-completa-tema.md) |
| architecture-rules | [architecture-rules.md](./architecture-rules.md) |
| architecture | [architecture.md](./architecture.md) |
| auth-examples | [auth-examples.md](./auth-examples.md) |
| authentication | [authentication.md](./authentication.md) |
| chartjs-datalabels-background-styling | [chartjs-datalabels-background-styling.md](./chartjs-datalabels-background-styling.md) |
| chartjs-datalabels-filament5-implementation | [chartjs-datalabels-filament5-implementation.md](./chartjs-datalabels-filament5-implementation.md) |
| chartjs-datalabels-multiple-labels-complete-guide | [chartjs-datalabels-multiple-labels-complete-guide.md](./chartjs-datalabels-multiple-labels-complete-guide.md) |
| chartjs-datalabels-theme-integration | [chartjs-datalabels-theme-integration.md](./chartjs-datalabels-theme-integration.md) |
| chartjs-export-theme-integration | [chartjs-export-theme-integration.md](./chartjs-export-theme-integration.md) |
| chartjs-plugin-datalabels-filament5 | [chartjs-plugin-datalabels-filament5.md](./chartjs-plugin-datalabels-filament5.md) |
| code-quality-improvements | [code-quality-improvements.md](./code-quality-improvements.md) |
| code-redundancy-audit | [code-redundancy-audit.md](./code-redundancy-audit.md) |
| components | [components.md](./components.md) |
| comprehensive-theme-analysis | [comprehensive-theme-analysis.md](./comprehensive-theme-analysis.md) |
| conflict-resolution-summary | [conflict-resolution-summary.md](./conflict-resolution-summary.md) |
| conflict-resolution | [conflict-resolution.md](./conflict-resolution.md) |
| customization | [customization.md](./customization.md) |
| database-governance | [database-governance.md](./database-governance.md) |
| doc-first-workflow | [doc-first-workflow.md](./doc-first-workflow.md) |
| docs-archive-policy | [docs-archive-policy.md](./docs-archive-policy.md) |
| docs-confidence-audit | [docs-confidence-audit.md](./docs-confidence-audit.md) |
| docs-deduplication | [docs-deduplication.md](./docs-deduplication.md) |
| dry-kiss-analysis | [dry-kiss-analysis.md](./dry-kiss-analysis.md) |
| dry-kiss-best-practices-historic | [dry-kiss-best-practices-historic.md](./dry-kiss-best-practices-historic.md) |
| dry-kiss-best-practices | [dry-kiss-best-practices.md](./dry-kiss-best-practices.md) |
| env-development-configuration | [env-development-configuration.md](./env-development-configuration.md) |
| examples | [examples.md](./examples.md) |
| filament-5-nested-resources-complete-guide | [filament-5-nested-resources-complete-guide.md](./filament-5-nested-resources-complete-guide.md) |
| filament-chart-integration | [filament-chart-integration.md](./filament-chart-integration.md) |
| filament-infolist-pattern | [filament-infolist-pattern.md](./filament-infolist-pattern.md) |
| filament-version | [filament-version.md](./filament-version.md) |

## Collegamenti

- [README root (vetrina)](../README.md)
- [Xot (framework base)](../../../Modules/Xot/docs/README.md)
- [Wiki progetto](../../../../docs/wiki/README.md)
- [Standard README doppio](../../../../docs/wiki/standards/module-theme-readme-dual.md)

## Per agenti

1. Leggere scopo in questo file.
2. Aprire `docs/wiki/index.md` se esiste.
3. Seguire [disciplina issue GitHub](../../../../docs/wiki/how-to/github-issue-agent-discipline.md) prima di modifiche sostanziali.
