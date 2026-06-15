---
title: "Reflective Notes"
type: reflection-log
status: active
created: "2026-06-15"
updated: "2026-06-15"
tags: [reflection, phpstan, xot, quality-gate]
related:
  - "./patterns/xotbase-resource-table-configure.md"
  - "./memories/phpstan-modules-inventory.md"
---

# Reflective Notes

## 2026-06-15 — PHPStan Xot `new static()`

**Perche e successo:** `XotBaseResourceTable::configure()` era un metodo statico su classe astratta che istanziava `new static()`. PHPStan segnala correttamente due rischi: chiamata diretta sulla classe astratta e costruttori non coerenti nelle sottoclassi.

**Come evitarlo:** nelle basi astratte Xot non usare `new static()` per costruire classi concrete. Risolvere la classe concreta via container, proteggere la chiamata diretta alla base e validare il tipo con `Webmozart\Assert`.

**Prova:** `cd laravel && ./vendor/bin/phpstan analyse Modules` -> 0 errori su 892 file con `phpstan.neon` corrente.

**Insight collegato:** durante il rilancio una classe nuova (`GdprConsentForm`) ha richiesto `XotBaseSchemaWidget`, gia referenziata anche da Lang ma assente in Xot. La base vuota sopra `XotBaseWidget` mantiene DRY il contratto per widget schema-based.
