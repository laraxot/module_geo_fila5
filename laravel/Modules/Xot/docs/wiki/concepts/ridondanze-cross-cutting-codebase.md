---
title: "Ridondanze cross-cutting codebase e dove documentarle"
type: concept
tags: [dry, redundancy, xot, documentation]
created: "2026-05-21"
updated: "2026-05-21"
related:
  - ../../redundancy-report.md
  - ../../filament/redundancy-rules.md
  - ../../../../../Themes/Sixteen/docs/wiki/concepts/ridondanze-documentazione-wizard.md
  - ../../../../../Themes/TwentyOne/docs/wiki/concepts/ridondanze-hub-twentyone-xot.md
  - ../../../../User/docs/wiki/concepts/ridondanze-docs-legacy-cluster.md
---

# Ridondanze cross-cutting (codice + documentazione)

## Scopo

Un solo punto di lettura che **aggrega tipi di ripetizioni** osservati nel monorepo (moduli Laraxot + temi Sixteen/TwentyOne) senza ricopiare lunghi estratti tecnici già pubblicati altrove.

## Inventario tecnico modulo Xot

Analisi strutturata con classi/File duplicati o path paralleli: **[redundancy-report.md](../../redundancy-report.md)** (ColumnBuilder gemello, AutoLabel vs Lang, ArticleData/BaseRating ospitati nel modulo sbagliato, doppioni `XotBaseRelationManager`/`XotBaseManageRelatedRecords`, note su `HasXotTable`/PHPStan).

Regole anti-ridondanza Filament progetto (non sostituire il report tecnico):

- **[redundancy-rules.md](../../filament/redundancy-rules.md)**

Wizard Filament dopo refactor storico (`HasWizard` vs logica manual): evitare triple doc — scegliere **una** delle due come SSoT contenutistico:

- **[filament-wizard-refactoring.md](../filament-wizard-refactoring.md)** (titolo sintetico)
- **[XotBaseWizardWidget-HasWizard-refactor.md](../XotBaseWizardWidget-HasWizard-refactor.md)** (~stesso testo storico — **candidate merge**)

Argomento concettuale senza duplicare il refactor:
- **[filament-haswizard-vs-xotbasewizard.md](./filament-haswizard-vs-xotbasewizard.md)**

## Documentazione scaffold LLM‑wiki ripetuta (byte-identiche)

Circa **10** copie uguali (stesso checksum) di **`docs/wiki/concepts/second-brain-local-discipline.md`** sotto **`laravel/Modules/*/docs/wiki/concepts/`**.

**Politica suggerita (DRY):** una sola pagina vivente nella wiki **del modulo più “core” (Xot)** o nel **wiki root**; negli altri moduli puntare con link relativo o stub di 5 righe. Modificare un solo master evita derive silenziose.

Moduli dove il file è oggi replicato (indicativo, lista da `find …/second-brain-local-discipline.md`): Activity, **Geo** (alternativa più specifica: `second-brain-geo-module-discipline.md`), Gdpr, Job, Media, Notify, Rating, Tenant, UI, User, **Xot** (master suggerito per policy generica).

## Report `redundancy-report.md` quasi ovunque

Molti moduli ospitano un file **`docs/redundancy-report.md`** con contenuto **diverso** per modulo — il nome suggerisce un template batch. Non è errore sintattico ma **ambiguità di naming**: in ricerca (“apri redundancy-report”) bisogna qualificare il modulo.

## Temi Sixteen / TwentyOne

- **Sixteen:** molte slice su wizard/parity/UI (vedi **`ridondanze-documentazione-wizard.md`** nel wiki tema Sixteen — link incrociato sopra nei `related`).
- **TwentyOne:** analisi quantitativa più vecchia (**`analisi-metodi-duplicati.md`** + **`dry-kiss-analysis.md`**) più hub breve (**`ridondanze-hub-twentyone-xot.md`**) verso questo documento e verso **`redundancy-report.md`** modulo Xot.

## Modulo User — cluster legacy Markdown

Molte revisioni quasi identiche su “redundancy fixes”/`phpstan dry kiss` dentro **`docs/`** e **`docs/legacy/`** (underscore vs hyphen nel nomefile, duplicazioni `redundancy-fixes*.md`): inventario sintetico in **[ridondanze-docs-legacy-cluster.md](../../../../User/docs/wiki/concepts/ridondanze-docs-legacy-cluster.md)**.

## Collegamenti utili progetto root

- [Trigger map](../../../../../../docs/wiki/rules/00-TRIGGER_MAP.md) — non copiare regole lungo qui.
