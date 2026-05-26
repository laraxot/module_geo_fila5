---
title: "Ridondanze cross-cutting codebase e dove documentarle"
type: concept
tags: [dry, redundancy, xot, documentation]
created: "2026-05-21"
updated: "2026-05-21"
related:
  - ../../redundancy-report.md
  - ../../filament/redundancy-rules.md
updated: "2026-05-22"
related:
  - ../../redundancy-report.md
  - ../../filament/redundancy-rules.md
  - ../redundancy/byte-identical-files-static-scan.md
  - ../../../../../Themes/docs/ridondanze-documentazione-temi.md
  - ../../../../../Themes/Sixteen/docs/wiki/concepts/ridondanze-documentazione-wizard.md
  - ../../../../../Themes/TwentyOne/docs/wiki/concepts/ridondanze-hub-twentyone-xot.md
  - ../../../../User/docs/wiki/concepts/ridondanze-docs-legacy-cluster.md
---

# Ridondanze cross-cutting (codice + documentazione)

## Scopo

Un solo punto di lettura che **aggrega tipi di ripetizioni** osservati nel monorepo (moduli Laraxot + temi Sixteen/TwentyOne) senza ricopiare lunghi estratti tecnici già pubblicati altrove.

**Audit documentazione:** 2026-05-21–22. **Audit statico file identici:** 2026-05-23. **Schede atomiche** (OAuth, widget auth, DTO, Rating, Fixcity, scaffold temi): indice in [`redundancy-catalog.md`](./redundancy-catalog.md).

## Ridondanza byte-identica (checksum), moduli + temi

Pass SHA256 senza interprete AST: **`431`** gruppi di file **`.php`** duplicati, di cui **`72`** con **copie in più owner** (moduli/temi distinti); **`179`** gruppi **`.blade.php`**, **`53`** cross-owner. Sintesi tecnica + pattern (route stub, dashboard Filament, doppioni view in Xot, clock widget): **[byte-identical-files-static-scan.md](../redundancy/byte-identical-files-static-scan.md)**. Tracker issue [#89](https://github.com/laraxot/base_fixcity_fila5/issues/89) / [#90](https://github.com/laraxot/base_fixcity_fila5/issues/90).

## Volumi documentazione moduli (indicativo)

| Modulo | `.md` in `docs/` circa | Cluster principale |
|--------|------------------------|-------------------|
| Xot | 3263 | wizard Filament wiki, scaffold |
| User | 3071 | **`legacy/` ~723**, logout, phpstan |
| Notify | 1821 | scaffold + notify |
| Lang, Geo, Cms, UI | 784–947 | scaffold batch |
| Fixcity | 202 | dominio prodotto |

~**57%** dei `.md` modulo è in Xot + User + Notify. Dettaglio temi: **[ridondanze-documentazione-temi.md](../../../../../Themes/docs/ridondanze-documentazione-temi.md)**.

## Ridondanze codice critiche (migrazioni e Filament)

Oltre a BaseModel/Filament già in [redundancy-report.md](../../redundancy-report.md):

| Tabella / area | Moduli | Problema |
|----------------|--------|----------|
| `users` | User | 6+ migration `create_users_table`; mirror `Database/Migrations/` vs `database/migrations/` |
| `profiles` | User + Blog | due moduli creano `profiles` |
| `mail_templates` | Notify | 7 migration stesso scopo |
| `consents` | Gdpr | 3 migration |
| `activity` | Activity | 5 migration |
| `cache` | Xot | 2 migration identiche |
| `notification_logs` | Notify | 2 migration |
| OAuth / Profile / Consent | User, Gdpr | resource cluster **e** standalone |
| Filament Tables typo | Geo, Activity, Media | `AddresssTable`, `ActivitysTable`, `MediasTable` |
| `lang/it/actions.php` | 9 moduli | chiavi Filament duplicate |
| Media UI | UI blocks + Media | `ImageSpatie`/`VideoSpatie` copy-paste; `HasMediaResource/` orfano |

**Azione:** una migration canonica per tabella; owner modulo unico per `profiles`; eliminare path migration legacy duplicati dopo backup.

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
Wizard widget Laraxot: SSoT **[filament-wizard-refactoring.md](../filament-wizard-refactoring.md)** — **`Filament\Resources\Pages\Concerns\HasWizard`** su `XotBaseWizardWidget`, normalizzazione stato su **`XotBaseWizardWidget`**, più eventualmente **`DelegatesFilamentWizardSchemaMethods`**. **[XotBaseWizardWidget-HasWizard-refactor.md](../XotBaseWizardWidget-HasWizard-refactor.md)** resta stub puntatore storico.

Argomento concettuale (studio vendor / paragone contesti — filtrare con SSoT sopra):

- **[filament-haswizard-vs-xotbasewizard.md](./filament-haswizard-vs-xotbasewizard.md)** (note esplorative, possono contenere roadmap non implementata)

## Documentazione scaffold LLM‑wiki ripetuta (byte-identiche)

**Stato:** `second-brain-local-discipline.md` era replicato in molti moduli con lo stesso checksum.

**Politica applicata:** corpo lungo solo in modulo **Xot** — **`[second-brain-local-discipline.md](./second-brain-local-discipline.md)`** (canonica); negli altri moduli (**Activity, Gdpr, Job, Media, Notify, Rating, Tenant, UI, User**) il file omonimo è **stub** breve verso la pagina canonica (**Geo** aveva anche variante tema-specifica quando presente nel modulo).

Variare sempre **solo il master Xot**, poi eventualmente aggiornare questo paragrafo se si aggiungono nuovi moduli scaffold.

## Report `redundancy-report.md` quasi ovunque

Molti moduli ospitano un file **`docs/redundancy-report.md`** con contenuto **diverso** per modulo — il nome suggerisce un template batch. Non è errore sintattico ma **ambiguità di naming**: in ricerca (“apri redundancy-report”) bisogna qualificare il modulo.

## Temi Sixteen / TwentyOne

- **Sixteen:** molte slice su wizard/parity/UI (vedi **`ridondanze-documentazione-wizard.md`** nel wiki tema Sixteen — link incrociato sopra nei `related`).
- **TwentyOne:** analisi quantitativa più vecchia (**`analisi-metodi-duplicati.md`** + **`dry-kiss-analysis.md`**) più hub breve (**`ridondanze-hub-twentyone-xot.md`**) verso questo documento e verso **`redundancy-report.md`** modulo Xot.

## Modulo User — cluster legacy Markdown

Molte revisioni quasi identiche su “redundancy fixes”/`phpstan dry kiss` dentro **`docs/`** e **`docs/legacy/`** (underscore vs hyphen nel nomefile, duplicazioni `redundancy-fixes*.md`): inventario sintetico in **[ridondanze-docs-legacy-cluster.md](../../../../User/docs/wiki/concepts/ridondanze-docs-legacy-cluster.md)**.

## Collegamenti utili progetto root

- [Trigger map](../../../../../../docs/wiki/rules/00-TRIGGER_MAP.md) — non copiare regole lungo qui.
