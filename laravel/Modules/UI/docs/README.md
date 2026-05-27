---
title: documentazione modulo UI
module: UI
type: index
status: approved
tags: [documentation, readme, modulo, second-brain]
updated: "2026-05-27"
related:
  - ../README.md
---

# Documentazione — modulo UI

> **Mappa knowledge base locale.** Il [README in root](../README.md) è la vetrina (valore, release, onboarding); questo file indica **dove** trovare regole, wiki e audit per chi sviluppa o per gli agenti AI.

## Scopo

UI components, layouts, and shared interface elements for Laraxot applications with Filament integration.

## Dove iniziare

- [Wiki locale](./wiki/index.md)
- [code redundancy audit](./code-redundancy-audit.md)
- [architecture rules](./architecture-rules.md)
- [agent edit discipline](./agent-edit-discipline.md)
- [agent confidence protocol](./agent-confidence-protocol.md)
- [second brain](./second-brain.md)


## Struttura tipica

```text
UI/
├── README.md          ← vetrina (root package)
├── docs/
│   ├── README.md      ← questo indice
│   └── wiki/          ← second brain (se presente)
├── app/ o resources/
└── composer.json
```

## Namespace / confini

- Namespace: `Modules\UI`
- Non duplicare qui la filosofia marketing: resta nel README root.

## Indice file in docs/ (root)

| Argomento | File |
| :--- | :--- |
| 00-INDEX | [00-INDEX.md](./00-INDEX.md) |
| 00-index | [00-index.md](./00-index.md) |
| ARCHITECTURE | [ARCHITECTURE.md](./ARCHITECTURE.md) |
| BRANDS_ICONS | [BRANDS_ICONS.md](./BRANDS_ICONS.md) |
| BRANDS_ICONS_INTEGRATION | [BRANDS_ICONS_INTEGRATION.md](./BRANDS_ICONS_INTEGRATION.md) |
| DESIGN_COMUNI_IMPLEMENTATION | [DESIGN_COMUNI_IMPLEMENTATION.md](./DESIGN_COMUNI_IMPLEMENTATION.md) |
| METODI-DUPLICATI-ANALISI | [METODI-DUPLICATI-ANALISI.md](./METODI-DUPLICATI-ANALISI.md) |
| METODI_DUPLICATI_ANALISI | [METODI_DUPLICATI_ANALISI.md](./METODI_DUPLICATI_ANALISI.md) |
| ON-DEMAND-PATTERN | [ON-DEMAND-PATTERN.md](./ON-DEMAND-PATTERN.md) |
| PERFORMANCE-OPTIMIZATION | [PERFORMANCE-OPTIMIZATION.md](./PERFORMANCE-OPTIMIZATION.md) |
| PRODUCT_LAUNCH_PLAN | [PRODUCT_LAUNCH_PLAN.md](./PRODUCT_LAUNCH_PLAN.md) |
| PRODUCT_ROADMAP | [PRODUCT_ROADMAP.md](./PRODUCT_ROADMAP.md) |
| PRODUCT_STRATEGY | [PRODUCT_STRATEGY.md](./PRODUCT_STRATEGY.md) |
| PROJECT-STRUCTURE | [PROJECT-STRUCTURE.md](./PROJECT-STRUCTURE.md) |
| QMD-SETUP | [QMD-SETUP.md](./QMD-SETUP.md) |
| REDUNDANCY_ANALYSIS | [REDUNDANCY_ANALYSIS.md](./REDUNDANCY_ANALYSIS.md) |
| SPRINT_PLANNING | [SPRINT_PLANNING.md](./SPRINT_PLANNING.md) |
| SVG_ICONS_AUTOMATIC_REGISTRATION | [SVG_ICONS_AUTOMATIC_REGISTRATION.md](./SVG_ICONS_AUTOMATIC_REGISTRATION.md) |
| SVG_ICONS_COMPLETE | [SVG_ICONS_COMPLETE.md](./SVG_ICONS_COMPLETE.md) |
| USER_RESEARCH | [USER_RESEARCH.md](./USER_RESEARCH.md) |
| advanced-form-components | [advanced-form-components.md](./advanced-form-components.md) |
| advanced_form_components | [advanced_form_components.md](./advanced_form_components.md) |
| agent-confidence-discipline | [agent-confidence-discipline.md](./agent-confidence-discipline.md) |
| agent-confidence-protocol | [agent-confidence-protocol.md](./agent-confidence-protocol.md) |
| agent-edit-discipline | [agent-edit-discipline.md](./agent-edit-discipline.md) |
| ai-methodologies | [ai-methodologies.md](./ai-methodologies.md) |
| algolia-docsearch-1 | [algolia-docsearch-1.md](./algolia-docsearch-1.md) |
| algolia-docsearch | [algolia-docsearch.md](./algolia-docsearch.md) |
| algolia-docsearch_1 | [algolia-docsearch_1.md](./algolia-docsearch_1.md) |
| algolia_docsearch | [algolia_docsearch.md](./algolia_docsearch.md) |
| altro | [altro.md](./altro.md) |
| analysis | [analysis.md](./analysis.md) |
| api | [api.md](./api.md) |
| architecture- | [architecture-.md](./architecture-.md) |
| architecture-archive-1 | [architecture-archive-1.md](./architecture-archive-1.md) |
| architecture-archive-2 | [architecture-archive-2.md](./architecture-archive-2.md) |
| architecture-rules-1 | [architecture-rules-1.md](./architecture-rules-1.md) |
| architecture-rules | [architecture-rules.md](./architecture-rules.md) |
| architecture-rules_1 | [architecture-rules_1.md](./architecture-rules_1.md) |
| architecture | [architecture.md](./architecture.md) |

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
