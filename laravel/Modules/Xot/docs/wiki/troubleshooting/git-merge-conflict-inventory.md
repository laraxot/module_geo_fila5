# Git Conflict Inventory

- Date: 2026-07-01 (sweep completato)
- Owner: Modules/Xot
- Files with conflict markers (storico 2026-04-28): 66
- Stato sweep `base_ptvx_fila5`: **0 marker** in tree (verificato `grep -rl '^<<<<<<< '`)

## Sweep 2026-07-01

| Area | File | Risoluzione |
|------|------|-------------|
| SVG | 56× `public_html/images/*.svg` | Pointer Git LFS (incoming) |
| PHP test | `FixStructureTest.pest.php`, `GenerateDbDocumentationCommandTest.pest.php` | HEAD valido, rimossa duplicazione corrotta |
| Lang | `lang/it/test.php` | Struttura espansa + campi `alpha`/`beta` |
| Provider | `XotServiceProvider`, `PanelMixin`, `PanelModuleResolver` | Mixin registrato, delega resolver |
| Config | `bmad/config.yaml`, `.gitignore` | Merge manuale |
| Docs | `docs/git/logs/conflict-resolution-*.md`, `bashscripts/docs/architecture-rules.md` | Marker rimossi, link relativi |

Canon procedura: [`../../../../docs/wiki/how-to/git-merge-marker-sweep.md`](../../../../docs/wiki/how-to/git-merge-marker-sweep.md)

## Files (inventario storico 2026-04-28)

- docs/ai-prompt-fundamental.md
- docs/base-model.md
- docs/chartjs-datalabels-xot-integration.md
- docs/code-quality-improvements-summary-.md
- docs/common-filament-trait-conflicts-2-1.md
- docs/comprehensive-chart-pdf-guide.md
- docs/comprehensive-code.md
- docs/comprehensive-improvement-recommendations.md
- docs/consolidated/code-quality-2-1.md
- docs/consolidated/testing-best-practices-uppercase-1.md
- docs/contracts-and-interfaces.md
- docs/documentation-rules-1-1.md
- docs/dry-kiss-model-refactoring-.md
- docs/filament-4-laraxot-e5a872.md
- docs/filament-4-laraxot-rules-conflict-e5a872.md
- docs/filament-best-practices-1-1.md
- docs/filament-charts.md
- docs/filament-class-extension-rules-violations-sumy.md
- docs/filament-class-extension-rules.md
- docs/filament-installation-and-charts.md
- docs/filament-nesting-best-practices.md
- docs/filament/infinite-loop-getstepbyname-fix-1.md
- docs/filament/infinite-loop-getstepbyname-fix-2.md
- docs/file-structure-philosophy.md
- docs/file-structure.md
- docs/final-code-quality-summary.md
- docs/fixes/relationx-sqlite-cross-database-fix.md
- docs/gap-missings.md
- docs/hasxtable-visibility.md
- docs/laraxot-architecture.md
- docs/laraxot.md
- docs/lessons-learned-1-1.md
- docs/lessons-learnedmerge-conflicts-1.md
- docs/limesurveyatabase-commands.md
- docs/limesurveyatabaseeepive.md
- docs/magic-properties-summary-.md
- docs/mcp-claude-code-configuration.md
- docs/mcp-database-tools.md
- docs/mcp-for-architecture.md
- docs/mcpatabase-tools.md
- docs/merge-conflict-resolution-1-1.md
- docs/missing-traits-and-improvements-2-1.md
- docs/missing-traits-and-improvements.md
- docs/model-inheritance-audit-2-1.md
- docs/model-inheritance-audit.md
- docs/models/dry-kiss-analysis.md
- docs/models/model-architecture.md
- docs/module-architecture-analysis.md
- docs/moduleocumentation-standard.md
- docs/package-discovery-philosophy.md
- docs/performance/large-dataset-import-guidelines.md
- docs/phpstan-analysis-.md
- docs/phpstan-batch-nov.md
- docs/phpstan-final.md
- docs/phpstan-fixes-summary-2-1.md
- docs/phpstan-january-final-summary.md
- docs/phpstan-level-10-dry-kiss-analysis-.md
- docs/phpstan-sumy.md
- docs/project-best-practices-2.md
- docs/property-exists-elimination-philosophy.md
- docs/property-exists-elimination-report.md
- docs/property-exists-elimination.md
- docs/super-mucca-optimization.md
- docs/theme-vestito.md
- docs/widget-implementation-rules-2-1.md
- docs/widget-implementation-rules.md

## Notes

- Inventory generated from `rg -l "^(<<<<<<<|=======|>>>>>>>)"`.
- Use this list as a volatile coordination map; re-open each file before editing because other agents may resolve items in parallel.