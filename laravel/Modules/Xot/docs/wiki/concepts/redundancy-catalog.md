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
  - ../../duplicate-methods.md
  - ../../duplicate-files-cleanup.md
  - ../../filament/redundancy-rules.md
sources: []
---

# Catalogo ridondanza (entrata modulo Xot)

## Scopo

Il modulo **Xot** è dove vivono classi base e pattern Filament riusati ovunque. Questa pagina è **solo un indice**: evita duplicare tabelle e inventari mantenuti altrove.

## Inventario tecnico trasversale (codice PHP / Filament)

- **Somma esecutiva e priorità**: [`Modules/docs/redundancy-report.md`](../../../../Modules/docs/redundancy-report.md) (`laravel/Modules/docs/`).

## Ridondanza *nel design* delle classi Xot (trait / provider)

Regole da applicare mentre si scrive codice (non copi-incollare trait già sulla base):

- [`filament/redundancy-rules.md`](../../filament/redundancy-rules.md)

## Wizard Filament vs XotBaseWizard — documentazione sovrapposta

Varie pagine affrontano lo stesso confronto storico/evolutivo da angolazioni diverse; uso consigliato:

1. **Decisione architettonica unica**: [`filament-haswizard-vs-xotbasewizard.md`](filament-haswizard-vs-xotbasewizard.md)
2. **Analisi trait**: [`filament-haswizard-traits-analysis.md`](filament-haswizard-traits-analysis.md)
3. **Studio approfondito**: [`filament-haswizard-study.md`](filament-haswizard-study.md)
4. Varianti filosofiche/widget: [`xotbasewizard-widget-vs-filament-haswizard.md`](xotbasewizard-widget-vs-filament-haswizard.md), [`filament-wizard-architecture-right-way.md`](filament-wizard-architecture-right-way.md), [`xotbase-wizard-architecture.md`](xotbase-wizard-architecture.md).

Prima di aprire un nuovo file su questo tema estendere **uno** degli esistenti e aggiungere link incrociato.

## Metodi/file duplicati (checklist refactoring Xot locale)

- [`duplicate-methods.md`](../../duplicate-methods.md)
- [`duplicate-methods-analysis.md`](../../duplicate-methods-analysis.md)
- [`duplicate-files-cleanup.md`](../../duplicate-files-cleanup.md)

## Tema pubblico (Sixteen) — parity wizard

Suddivisione intentionalmente granular dei documenti **`segnalazione-*`**; per orientarsi:

- [`wizard-parity-documentation-map.md`](../../../../Themes/Sixteen/docs/wiki/concepts/wizard-parity-documentation-map.md)

