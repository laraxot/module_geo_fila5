---
title: "catalogo ridondanza e documentazione correlata"
module: Xot
type: concept
confidence: high
created: 2026-05-21
updated: 2026-05-21
tags: [redundancy, dry, filament, laraxot, documentation]
related:
  - ../../../../Modules/docs/redundancy-report.md
updated: 2026-05-26
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/89"
  - "https://github.com/laraxot/base_fixcity_fila5/issues/90"
tags: [redundancy, dry, filament, laraxot, documentation]
related:
  - ../../../../docs/redundancy-report.md
  - ../../duplicate-methods.md
  - ../../duplicate-files-cleanup.md
  - ../../filament/redundancy-rules.md
sources: []
---

# Catalogo ridondanza (entrata modulo Xot)

## Scopo

Il modulo **Xot** è dove vivono classi base e pattern Filament riusati ovunque. Questa pagina è **solo un indice**: evita duplicare tabelle e inventari mantenuti altrove.

**Audit PTVX 2026-05-26:** [code-redundancy-philosophy.md](code-redundancy-philosophy.md) (scopo, zen, politica, dubbi) · [redundancy-audit-2026-05-26.md](../redundancy-audit-2026-05-26.md) (P0/P1/P2).

## Inventario tecnico trasversale (codice PHP / Filament)

- **Somma esecutiva e priorità**: [`Modules/docs/redundancy-report.md`](../../../../Modules/docs/redundancy-report.md) (`laravel/Modules/docs/`).
- **Somma esecutiva e priorità**: [`Modules/docs/redundancy-report.md`](../../../../docs/redundancy-report.md) (`laravel/Modules/docs/`).
- **Scan byte-identical (2026-05-23)**: [`../redundancy/byte-identical-files-static-scan.md`](../redundancy/byte-identical-files-static-scan.md).

## Schede atomiche `wiki/redundancy/` (owner)

| Owner | File | Topic |
|-------|------|--------|
| Xot | [`duplicated-basemodel.md`](../redundancy/duplicated-basemodel.md) | BaseModel ×16 |
| Xot | [`duplicated-create-user-action.md`](../redundancy/duplicated-create-user-action.md) | CreateUserAction ×4 |
| Xot | [`duplicated-data-objects-cross-module.md`](../redundancy/duplicated-data-objects-cross-module.md) | ArticleData, MetatagData, … |
| Xot | [`xotbase-pattern-abuse.md`](../redundancy/xotbase-pattern-abuse.md) | Copy XotBase* |
| User | [`oauth-dual-resource-trees.md`](../../../../User/docs/wiki/redundancy/oauth-dual-resource-trees.md) | Passport/Socialite |
| User | [`duplicated-auth-widgets.md`](../../../../User/docs/wiki/redundancy/duplicated-auth-widgets.md) | Login/Logout widget |
| User | [`duplicated-users-relation-manager.md`](../../../../User/docs/wiki/redundancy/duplicated-users-relation-manager.md) | ×6 |
| User | [`duplicated-profile-form.md`](../../../../User/docs/wiki/redundancy/duplicated-profile-form.md) | Profile/OAuth forms |
| Media | [`duplicated-media-relation-manager.md`](../../../../Media/docs/wiki/redundancy/duplicated-media-relation-manager.md) | ×3 |
| Media | [`has-media-form-duplication.md`](../../../../Media/docs/wiki/redundancy/has-media-form-duplication.md) | HasMediaForm |
| Rating | [`duplicate-ratings-table-migrations.md`](../../../../Rating/docs/wiki/redundancy/duplicate-ratings-table-migrations.md) | Table + migration |
| Fixcity | [`duplicated-comments-relation-manager.md`](../../../../Fixcity/docs/wiki/redundancy/duplicated-comments-relation-manager.md) | Comments RM ×2 |
| Sixteen | [`duplicated-blade-blocks.md`](../../../../../Themes/Sixteen/docs/wiki/redundancy/duplicated-blade-blocks.md) | Blade blocks |
| Notify | [`code-redundancy-notify.md`](../../../../Notify/docs/wiki/concepts/code-redundancy-notify.md) | `.php.up`, template doppi |
| User | [`code-redundancy-user.md`](../../../../User/docs/wiki/concepts/code-redundancy-user.md) | LoginWidget, Passport |
| UI | [`code-redundancy-ui.md`](../../../../UI/docs/wiki/concepts/code-redundancy-ui.md) | TableLayoutTrait |
| Theme One | [`code-redundancy-theme.md`](../../../../../Themes/One/docs/wiki/concepts/code-redundancy-theme.md) | Blade login |
| Theme Zero | [`code-redundancy-theme.md`](../../../../../Themes/Zero/docs/wiki/concepts/code-redundancy-theme.md) | Blade login |

## Tracker GitHub (esecuzione)

Epic [#90](https://github.com/laraxot/base_fixcity_fila5/issues/90) · P0 [#100](https://github.com/laraxot/base_fixcity_fila5/issues/100) User · P1 [#101](https://github.com/laraxot/base_fixcity_fila5/issues/101) · Docs [#102](https://github.com/laraxot/base_fixcity_fila5/issues/102)–[#104](https://github.com/laraxot/base_fixcity_fila5/issues/104) · Refactor [#105](https://github.com/laraxot/base_fixcity_fila5/issues/105) [#106](https://github.com/laraxot/base_fixcity_fila5/issues/106) · Cluster [#95](https://github.com/laraxot/base_fixcity_fila5/issues/95)–[#99](https://github.com/laraxot/base_fixcity_fila5/issues/99).

## Ridondanza *nel design* delle classi Xot (trait / provider)

Regole da applicare mentre si scrive codice (non copi-incollare trait già sulla base):

- [`filament/redundancy-rules.md`](../../filament/redundancy-rules.md)

## Wizard Filament vs XotBaseWizard — documentazione sovrapposta

Varie pagine affrontano lo stesso confronto storico/evolutivo da angolazioni diverse; uso consigliato:

1. **Decisione architettonica unica**: [`filament-haswizard-vs-xotbasewizard.md`](filament-haswizard-vs-xotbasewizard.md)
2. **Analisi trait**: [`filament-haswizard-traits-analysis.md`](filament-haswizard-traits-analysis.md)
3. **Studio approfondito**: [`filament-haswizard-study.md`](filament-haswizard-study.md)
4. Varianti filosofiche/widget: [`xotbasewizard-widget-vs-filament-haswizard.md`](xotbasewizard-widget-vs-filament-haswizard.md), [`filament-wizard-architecture-right-way.md`](filament-wizard-architecture-right-way.md), [`xotbase-wizard-architecture.md`](xotbase-wizard-architecture.md).
4. Varianti filosofiche/widget: [`xotbasewizardwidget-vs-filament-haswizard.md`](xotbasewizardwidget-vs-filament-haswizard.md), [`filament-wizard-architecture-right-way.md`](filament-wizard-architecture-right-way.md), [`xotbase-wizard-architecture.md`](xotbase-wizard-architecture.md).

Prima di aprire un nuovo file su questo tema estendere **uno** degli esistenti e aggiungere link incrociato.

## Metodi/file duplicati (checklist refactoring Xot locale)

- [`duplicate-methods.md`](../../duplicate-methods.md)
- [`duplicate-methods-analysis.md`](../../duplicate-methods-analysis.md)
- [`duplicate-files-cleanup.md`](../../duplicate-files-cleanup.md)

## Tema pubblico (Sixteen) — parity wizard

Suddivisione intentionalmente granular dei documenti **`segnalazione-*`**; per orientarsi:

- [`wizard-parity-documentation-map.md`](../../../../Themes/Sixteen/docs/wiki/concepts/wizard-parity-documentation-map.md)
- [`wizard-parity-documentation-map.md`](../../../../../Themes/Sixteen/docs/wiki/concepts/wizard-parity-documentation-map.md)

