---
title: "Reflective Notes"
type: reflection-log
status: active
created: "2026-06-15"
updated: "2026-06-15"
tags: [reflection, phpstan, xot, quality-gate]
related:
  - "./patterns/xotbase-resource-table-configure.md"
  - "./patterns/phpstan-optional-contracts.md"
  - "./memories/phpstan-modules-inventory.md"
---

# Reflective Notes

## 2026-06-15 — Ingresso Ptv in scope PHPStan

**Perche e successo:** `Ptv` e uscito da `excludePaths` nel neon. Le action Scheda usavano `class-string` dinamiche senza narrowing, contratti scheda senza `@property` Eloquent, e riferimenti a classi Performance/Activitylog non allineati al vendor reale.

**Come evitarlo:** per action batch su modelli generici introdurre un resolver tipizzato (`EloquentModelResolver`). I contratti dominio che espongono relazioni devono `@phpstan-require-extends Model`. Non dichiarare metodi di pacchetti disabilitati (activity log).

**Prova:** `phpstan analyse Modules` → 0 errori (701 file in scope).

**Pattern:** [`phpstan-scheda-actions.md`](../../laravel/Modules/Ptv/docs/wiki/concepts/phpstan-scheda-actions.md), [`block-rendering-and-optional-services.md`](../../laravel/Modules/UI/docs/wiki/concepts/block-rendering-and-optional-services.md).

## 2026-06-15 — PHPStan dipendenze opzionali e generic Eloquent

**Perche e successo:** il full scan analizzava solo i moduli non esclusi, ma `UI` e `User` importavano contratti di moduli assenti (`Geo`, `Cms`, `Comment`) o dichiaravano relazioni Eloquent con generic non allineati alla non-covarianza Larastan.

**Come evitarlo:** il modulo consumer deve esporre contratti locali o action-bridge verso moduli opzionali. I contratti Eloquent cross-modulo devono usare il declaring model `$this`, non `Model` generico, quando la relazione nasce da `$this->hasOne()` o `$this->belongsToManyX()`.

**Prova:** `cd laravel && ./vendor/bin/phpstan analyse Modules` -> 0 errori su 701 file con `phpstan.neon` corrente.

**Pattern collegato:** [`phpstan-optional-contracts.md`](patterns/phpstan-optional-contracts.md).

## 2026-06-15 — Collection Eloquent vs Support in action polimorfiche

**Perche e successo:** `Check::execute()` accetta `Illuminate\Support\Collection<int, Model>`. Passare `Eloquent\Collection<int, CriteriEsclusione>` fallisce per covarianza del template `TValue`.

**Come evitarlo:** usare `iterable<int, Model>` nella signature delle action che consumano relazioni Eloquent eterogenee; oppure bridge `Collection::make($eloquent->all())` solo se serve API Collection. Per attributi dinamici su modello transiente usare `setAttribute()` non property magic.

**Prova:** `phpstan analyse Modules/Ptv` -> 0 errori dopo allineamento `BaseSchedaResource`, `TrovaEsclusiBy*`.

## 2026-06-15 — Mai bypassare relazioni Eloquent per PHPStan

**Perché è successo:** `ListaAszTipCodEsclusoSubito` era stato “fixato” sostituendo `$scheda->asz()->ofRangeDate()` con `Asz00k1::query()` + filtri `matr`/`ente`/`aszann` duplicati — shortcut statico al posto del contratto relazione.

**Regola:** le relazioni sono DRY contract; PHPStan si risolve su contratto/generics (`HasMany<Asz00k1, Model>`), non re-query manuale.

**Come evitarlo:** TRIGGER_MAP riga cardinale → [eloquent-relationship-encapsulation.md](rules/eloquent-relationship-encapsulation.md); audit `bashscripts/tools/audit-eloquent-relationship-duplication.sh`.

**Prova:** revert + `phpstan analyse Modules` → 0 errori.

## 2026-06-15 — PHPStan Xot `new static()`

**Perche e successo:** `XotBaseResourceTable::configure()` era un metodo statico su classe astratta che istanziava `new static()`. PHPStan segnala correttamente due rischi: chiamata diretta sulla classe astratta e costruttori non coerenti nelle sottoclassi.

**Come evitarlo:** nelle basi astratte Xot non usare `new static()` per costruire classi concrete. Risolvere la classe concreta via container, proteggere la chiamata diretta alla base e validare il tipo con `Webmozart\Assert`.

**Prova:** `cd laravel && ./vendor/bin/phpstan analyse Modules` -> 0 errori su 892 file con `phpstan.neon` corrente.

**Insight collegato:** durante il rilancio una classe nuova (`GdprConsentForm`) ha richiesto `XotBaseSchemaWidget`, gia referenziata anche da Lang ma assente in Xot. La base vuota sopra `XotBaseWidget` mantiene DRY il contratto per widget schema-based.
