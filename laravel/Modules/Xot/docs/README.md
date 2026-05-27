---
title: documentazione modulo Xot
module: Xot
type: index
status: approved
tags: [documentation, readme, modulo, second-brain]
updated: "2026-05-27"
related:
  - ../README.md
---

# Documentazione — modulo Xot

> **Mappa knowledge base locale.** Il [README in root](../README.md) è la vetrina (valore, release, onboarding); questo file indica **dove** trovare regole, wiki e audit per chi sviluppa o per gli agenti AI.

## Scopo

xot module, heart of the laraxot repository

## Dove iniziare

- [Wiki locale](./wiki/index.md)
- [code redundancy audit](./code-redundancy-audit.md)
- [architecture rules](./architecture-rules.md)
- [agent edit discipline](./agent-edit-discipline.md)
- [agent confidence protocol](./agent-confidence-protocol.md)
- [second brain](./second-brain.md)


## Struttura tipica

```text
Xot/
├── README.md          ← vetrina (root package)
├── docs/
│   ├── README.md      ← questo indice
│   └── wiki/          ← second brain (se presente)
├── app/ o resources/
└── composer.json
```

## Namespace / confini

- Namespace: `Modules\Xot`
- Non duplicare qui la filosofia marketing: resta nel README root.

## Indice file in docs/ (root)

| Argomento | File |
| :--- | :--- |
| 00-INDEX | [00-INDEX.md](./00-INDEX.md) |
| 00-MASTER-INDEX | [00-MASTER-INDEX.md](./00-MASTER-INDEX.md) |
| 00-index-v2 | [00-index-v2.md](./00-index-v2.md) |
| 00-index | [00-index.md](./00-index.md) |
| 01-filament-5-migration-guide | [01-filament-5-migration-guide.md](./01-filament-5-migration-guide.md) |
| 01-index-details | [01-index-details.md](./01-index-details.md) |
| 01-indexetails | [01-indexetails.md](./01-indexetails.md) |
| CODE_QUALITY_ANALYSIS | [CODE_QUALITY_ANALYSIS.md](./CODE_QUALITY_ANALYSIS.md) |
| COMMON_FILAMENT_TRAIT_CONFLICTS | [COMMON_FILAMENT_TRAIT_CONFLICTS.md](./COMMON_FILAMENT_TRAIT_CONFLICTS.md) |
| COMPREHENSIVE_CODE_ANALYSIS | [COMPREHENSIVE_CODE_ANALYSIS.md](./COMPREHENSIVE_CODE_ANALYSIS.md) |
| COMPREHENSIVE_IMPROVEMENT_RECOMMENDATIONS | [COMPREHENSIVE_IMPROVEMENT_RECOMMENDATIONS.md](./COMPREHENSIVE_IMPROVEMENT_RECOMMENDATIONS.md) |
| DAISYUI | [DAISYUI.md](./DAISYUI.md) |
| DIRECTORY_STRUCTURE_RULES | [DIRECTORY_STRUCTURE_RULES.md](./DIRECTORY_STRUCTURE_RULES.md) |
| DRY_KISS_REFACTORING | [DRY_KISS_REFACTORING.md](./DRY_KISS_REFACTORING.md) |
| LARAXOT_ARCHITECTURE_RULES | [LARAXOT_ARCHITECTURE_RULES.md](./LARAXOT_ARCHITECTURE_RULES.md) |
| LICENSE | [LICENSE.md](./LICENSE.md) |
| MCP_SERVERS | [MCP_SERVERS.md](./MCP_SERVERS.md) |
| MIGRATION_PHILOSOPHY | [MIGRATION_PHILOSOPHY.md](./MIGRATION_PHILOSOPHY.md) |
| MISSING_TRAITS_AND_IMPROVEMENTS | [MISSING_TRAITS_AND_IMPROVEMENTS.md](./MISSING_TRAITS_AND_IMPROVEMENTS.md) |
| MODEL_INHERITANCE_AUDIT | [MODEL_INHERITANCE_AUDIT.md](./MODEL_INHERITANCE_AUDIT.md) |
| MODERN_TECH_STACK_OPTIMIZATION | [MODERN_TECH_STACK_OPTIMIZATION.md](./MODERN_TECH_STACK_OPTIMIZATION.md) |
| ON-DEMAND-PATTERN | [ON-DEMAND-PATTERN.md](./ON-DEMAND-PATTERN.md) |
| PERFORMANCE-OPTIMIZATION | [PERFORMANCE-OPTIMIZATION.md](./PERFORMANCE-OPTIMIZATION.md) |
| PERFORMANCE_GUIDELINES | [PERFORMANCE_GUIDELINES.md](./PERFORMANCE_GUIDELINES.md) |
| PRD | [PRD.md](./PRD.md) |
| PRODUCT_LAUNCH_PLAN | [PRODUCT_LAUNCH_PLAN.md](./PRODUCT_LAUNCH_PLAN.md) |
| PRODUCT_ROADMAP | [PRODUCT_ROADMAP.md](./PRODUCT_ROADMAP.md) |
| PRODUCT_STRATEGY | [PRODUCT_STRATEGY.md](./PRODUCT_STRATEGY.md) |
| PROJECT-STRUCTURE | [PROJECT-STRUCTURE.md](./PROJECT-STRUCTURE.md) |
| QMD-SETUP | [QMD-SETUP.md](./QMD-SETUP.md) |
| REDUNDANCY_ANALYSIS | [REDUNDANCY_ANALYSIS.md](./REDUNDANCY_ANALYSIS.md) |
| SCRIPT_RISOLUZIONE_CONFLITTI | [SCRIPT_RISOLUZIONE_CONFLITTI.md](./SCRIPT_RISOLUZIONE_CONFLITTI.md) |
| SPRINT_PLANNING | [SPRINT_PLANNING.md](./SPRINT_PLANNING.md) |
| TRANSLATION_STRUCTURE | [TRANSLATION_STRUCTURE.md](./TRANSLATION_STRUCTURE.md) |
| UNDERSCORE_DOCS_RULE | [UNDERSCORE_DOCS_RULE.md](./UNDERSCORE_DOCS_RULE.md) |
| USER_RESEARCH | [USER_RESEARCH.md](./USER_RESEARCH.md) |
| WIDGET_IMPLEMENTATION_RULES | [WIDGET_IMPLEMENTATION_RULES.md](./WIDGET_IMPLEMENTATION_RULES.md) |
| XOTBASE_ARCHITECTURE_PHILOSOPHY | [XOTBASE_ARCHITECTURE_PHILOSOPHY.md](./XOTBASE_ARCHITECTURE_PHILOSOPHY.md) |
| about | [about.md](./about.md) |
| access-level-parameter-fix | [access-level-parameter-fix.md](./access-level-parameter-fix.md) |

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
