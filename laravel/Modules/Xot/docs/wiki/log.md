---
title: "Activity Log"
module: "Xot"
---

# Activity Log — Xot

> **Purpose:** Append-only chronological activity record tracking ingests, queries, and lint passes.

## Log Entries

## [2026-05-25] docs | audit profondo ridondanze — second brain ripulito da merge-marker

- **Obiettivo**: consolidare osservabilità delle ripetizioni (codice + documentazione) senza toccare applicativo.
- **Deliverable**: [`redundancy/audit-profondo-ridondanze-holistic.md`](redundancy/audit-profondo-ridondanze-holistic.md); aggiornato [`byte-identical-files-static-scan.md`](redundancy/byte-identical-files-static-scan.md) (riesame numeri SHA256 rigorosi `.php` vs `.blade.php`); sistemati hub [`concepts/ridondanze-cross-cutting-codebase.md`](concepts/ridondanze-cross-cutting-codebase.md) e [`concepts/redundancy-catalog.md`](concepts/redundancy-catalog.md) (prima gravemente corrotti da `<<<<<<<`).
- **Nota modulo Fixcity tema**: superfici duplicate cross-modulo in [`fixcity-cross-module-duplicate-surfaces.md`](../../../Fixcity/docs/wiki/redundancy/fixcity-cross-module-duplicate-surfaces.md).

## [2026-05-24] refactor | wizard — normalizzazione stato **rimossa dalla base**

- **Motivo progetto**: il submit deve usare **`$this->form->getState()`** così come lo espone Filament/schema, senza helper PHP che appiattiscono wrapper (`wizard`) nel widget base.
- **Codice**: `XotBaseWizardWidget` contiene solo costruzione `Wizard` + policy `?step=` + vista tema; **nessun** `normalizeWizardFormState()` / `getWizardSchemaWrapperKey()` sulla classe.
- **Fixcity**: `CreateTicketWizardWidget::submit()` legge `getState()` e fa merge opzionale `owner_id` se auth; vedi [`CreateTicketWizardWidget.php`](../../Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php).

## [2026-05-24] refactor | wizard — normalizzazione stato dentro `XotBaseWizardWidget` (niente trait file) — **superata**

- **Nota storica**: per un breve periodo i metodi `normalizeWizardFormState` erano stati spostati sulla base al posto del trait file; **da 2026-05-24 (direzione corrente)** quei metodi non esistono più: vedi voce sopra.

- **Problema (storicamente)**: `CreateTicketWizardWidget` poteva ancora referenziare `NormalizesWizardFormState` mentre il file `.php` mancava → fatal Composer su molte working tree (`include … No such file`).
- **Soluzione intermedia (superata)**: metodi `protected` su `XotBaseWizardWidget` al posto del trait.
- **Soluzione attuale**: nessuna normalizzazione post-`getState()` nella base; schema/dehydrate definiscono la forma.

## [2026-05-23] fix | wizard — riferimento storico errato a trait `NormalizesWizardFormState` (fatal autoload)

- **Canonico oggi**: non creare **`NormalizesWizardFormState.php`**; non usare **`use Modules\Xot\Filament\Traits\NormalizesWizardFormState`**.
- **Nota storica / superata**: questa voce descriveva un tentativo di ripristino del trait; il trait **non** è parte dell'architettura.

- **Symptomo**: `/it/tests/segnalazione-crea` → errore fetale `Failed to open stream ... NormalizesWizardFormState.php` durante load di `CreateTicketWizardWidget`; niente markup wizard.
- **Fix (storico)**: rimuovere `use` trait fantasma / allineare al codice corrente; dopo pull eseguire `composer dump-autoload`.

## [2026-05-23] refactor | wizard widget — `HasWizard` sul widget Xot + trait satellite

- **Motivo UX**: ripristinare parità tipo bozza progetto storica (**alias `getParentWizardComponent`**, cancel SPA-aware, vista `pub_theme::components.wizard`).
- **File**: [`XotBaseWizardWidget.php`](../../app/Filament/Widgets/XotBaseWizardWidget.php); normalizzazione stato submit: metodi `protected` sulla stessa classe (2026-05-24), non più trait dedicato. Verificare eventualmente `DelegatesFilamentWizardSchemaMethods` se ancora presente in tree.

## [2026-05-23] audit | ridondanze codice — scan SHA256 cross-moduli/temi (#89/#90)

- Gruppi byte-identical (SHA256; cross-owner senza `/tests/`): **431** `.php` (**72** cross-owner), **179** Blade (**53** cross-owner). [`redundancy/byte-identical-files-static-scan.md`](redundancy/byte-identical-files-static-scan.md). Hub [`concepts/ridondanze-cross-cutting-codebase.md`](concepts/ridondanze-cross-cutting-codebase.md). Indice wiki root [`code-redundancy-audit.md`](../../../../../docs/wiki/concepts/code-redundancy-audit.md). Commenti `#89`, `#90`, `#80`.


## [2026-05-22] docs | DRY second brain + merge doc wizard HasWizard

- **`second-brain-local-discipline`:** solo [`concepts/second-brain-local-discipline.md`](concepts/second-brain-local-discipline.md) mantiene il corpo; negli altri nove moduli stesso basename → stub puntatore canonica.
- **Wizard refactor:** contenuto consolidato in [`filament-wizard-refactoring.md`](filament-wizard-refactoring.md); [`XotBaseWizardWidget-HasWizard-refactor.md`](XotBaseWizardWidget-HasWizard-refactor.md) ridotto a stub (permalink storici).
- Hub aggiornato: [`concepts/ridondanze-cross-cutting-codebase.md`](concepts/ridondanze-cross-cutting-codebase.md).

## [2026-05-21] docs | inventario ridondanze codebase + scaffold docs

- Nuovo hub concettuale [`concepts/ridondanze-cross-cutting-codebase.md`](concepts/ridondanze-cross-cutting-codebase.md): incrocia **`docs/redundancy-report.md`**, duplicazioni `second-brain-local-discipline`, doc wizard quasi gemelle nel tema Sixteen e cluster legacy modulo User; puntatori verso **`filament/redundancy-rules.md`**.

## [2026-05-21] docs | LAMP — `docs/lamp/install.txt` riscritto

- Guida strutturata: Sury PHP 8.4, pacchetti deduplicati, `pdo-dblib`/odbc, sezioni opzionali (imagick/swoole/redis), Xdebug solo dev, Apache `libapache2-mod-php8.4`, `update-alternatives`, link incrociati verso [`wiki/concepts/php84-upgrade-extension-checklist.md`](wiki/concepts/php84-upgrade-extension-checklist.md) e [`docs/README.md`](../README.md).

## [2026-05-21] dependency | model-states installato — PHP 8.4 — #87

- `spatie/laravel-model-states` **2.14.1** in `vendor/`; PHPStan `Modules/Xot/app/States` OK dopo `clear-result-cache`.
- Comandi reali: `php8.4 … composer update -W` da `laravel/`; **non** `composer run go` (migrations wipe). Lock root generato ma **`.gitignore` `*.lock`**.
- [`phpstan-fixes-log.md`](concepts/phpstan-fixes-log.md), [checklist PHP 8.4](concepts/php84-upgrade-extension-checklist.md).

## [2026-05-21] docs | checklist PHP 8.4 — prima bozza `composer run go`

- Correzioni intermedie in [`concepts/php84-upgrade-extension-checklist.md`](concepts/php84-upgrade-extension-checklist.md). **Revisione finale** stesso giorno: snippet con `php8.4 … composer update -W` + avviso su `composer run go` distruttivo.

## [2026-04-28] dependency | matrice compatibilita' pacchetti Laravel 13 in Xot

- verificata compatibilita' reale dei pacchetti rimossi nel passaggio a Laravel 13 con focus su runtime `php 8.3`.
- confermato che `fruitcake/laravel-debugbar` (`v4.2.8`) e' gia' dichiarato in `Modules/Xot/composer.json` (`require-dev`) e risolto nel lock root.
- confermato owner runtime Xot per `fast-paginate` e `morph-to-one`; entrambi oggi bloccati per assenza di supporto stable a `Laravel 13`.
- chiarito che `model-states` ha owner condiviso `UI` + `Xot`, mentre `responsecache` non ha integrazione runtime forte verificata nel codice corrente.
- nuova pagina: `docs/wiki/concepts/laravel13-modular-package-compatibility-matrix.md`.

## [2026-04-27] governance | policy module matrix

- aggiunta matrice modulo-per-modulo con base policy consigliata (`XotBasePolicy` vs `UserBasePolicy`).
- inserite priorita' di allineamento per ridurre drift nei moduli ibridi.
- nuova pagina: `docs/wiki/concepts/policy-module-matrix.md`.

## [2026-04-27] governance | policy base strategy across modules

- documentata strategia di base per scegliere tra `XotBasePolicy` e `UserBasePolicy`.
- mantenuta separazione: `XotBasePolicy` come base tecnica cross-modulo, `UserBasePolicy` come specializzazione identity-domain.
- nuovo decision tree operativo in `docs/wiki/concepts/policy-base-strategy.md`.

## [2026-04-23] quality | PHPStan cluster map and false friends

- Documentati i cluster statici ricorrenti emersi da `phpstan analyse Modules` con focus su Xot: `implode`, `array_fill_keys`, `mixed`, funzioni unsafe e mismatch con API Filament.
- Nuova pagina: `docs/wiki/concepts/phpstan-cluster-map-and-false-friends.md`.

## [2026-04-23] governance | XotBaseField calculated view rule

- Formalizzata la regola corretta per i componenti che estendono `XotBaseField`: niente `protected string $view` nei singoli field, ma risoluzione centralizzata via `getDefaultView()` nel base class.
- Verifica runtime eseguita sulla URL reale `tests/segnalazione-crea`: dopo il fix `CoordinatePicker` torna a renderizzare correttamente.

## [2026-04-22] ops | context-mode + QMD per story BMAD

- **regola root**: `docs/wiki/concepts/context-compression-discipline.md`
- **scope Xot**: base classes e documentazione framework vanno recuperate tramite QMD/context-mode con snippet minimi quando uno skill BMAD rischia il limite `131072 tokens`.
- **verifica**: context-mode plugin/MCP connessi; QMD indicizza moduli/temi/root/bashscripts.

## [2026-05-12] ops | opencode compaction overflow hardening

- installato `@tarquinen/opencode-dcp@latest` nel config globale OpenCode.
- creato `opencode.json` al git root con `compaction.auto=true`, `compaction.prune=true`, `compaction.reserved=40000`.
- chiarito che il punto operativo corretto e' il git root, non `laravel/opencode.json`.
- aggiornata la source wiki `sources/context-compression-and-retrieval.md` per riflettere il nuovo setup stabile.

## [2026-04-22] governance | Filament wizard summary via Infolists

- **regola root**: `docs/wiki/concepts/filament-summary-infolist-rule.md`
- **scope Xot**: quando wrapper, trait o base widget espongono/validano `getSummarySchema()`, il summary read-only deve essere modellato con `Filament\Infolists\Components\*`, non con `SchemaView`.
- **fonte ufficiale**: https://filamentphp.com/docs/5.x/infolists/overview

## [2026-04-20] pattern | UnitTestCase senza MySQL per test puri

- **motivo**: `Modules\Geo\Tests\TestCase` richiedeva MySQL anche per 17 test puramente PHP → `PDOException` su ambienti senza DB configurato
- **soluzione**: creato `UnitTestCase` in Geo che usa `CreatesApplication` (Xot) senza `DatabaseTransactions`
- **pages**:
  - `docs/wiki/concepts/unit-test-case-pattern.md` (**NUOVA**): template riutilizzabile per ogni modulo
  - `docs/wiki/index.md`: aggiornato sezione Testing Patterns
- **applicabilità**: pattern replicabile in qualsiasi modulo per test Pest/PHPUnit senza DB

---

_No activity yet. Start by ingesting raw documents._

### Format

```
[YYYY-MM-DD HH:MM:SS UTC] [OPERATION] Description
```

**Operations:**
- `INGEST` — Added raw document to wiki
- `QUERY` — Answered question from wiki
- `LINT` — Maintained wiki quality
- `UPDATE` — Modified existing wiki page

---

**Last Activity:** None  
**Total Operations:** 0

## [2026-04-27] cross-reference | Policy Decision
- Linked: ../User/docs/wiki/concepts/policy-inheritance-boundary.md
- Decision: Mantenere separazione XotBasePolicy (foundation) vs UserBasePolicy (application)
- XotBasePolicy: zero dipendenze, system processes, API token
- UserBasePolicy: Spatie Permission, user-authenticated, RBAC
- Commit: docs: add cross-reference to policy boundary decision
