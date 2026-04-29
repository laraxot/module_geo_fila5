---
title: "Activity Log"
module: "Xot"
---

# Activity Log — Xot

> **Purpose:** Append-only chronological activity record tracking ingests, queries, and lint passes.

## Log Entries

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
