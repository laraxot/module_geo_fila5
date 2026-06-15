---
title: "XotBaseResourceTable Configure Pattern"
type: pattern
status: approved
created: "2026-06-15"
updated: "2026-06-15"
tags: [xot, filament, phpstan, table, new-static]
related:
  - "../reflective.md"
  - "../../../laravel/Modules/Xot/docs/wiki/concepts/filament-v5-hybrid-pattern.md"
---

# XotBaseResourceTable Configure Pattern

## Regola

Nelle classi base astratte Xot evitare `new static()` dentro metodi statici.

## Pattern corretto

Usare:

- guard esplicita contro chiamata diretta della classe astratta;
- `app(static::class)` per risolvere la classe concreta;
- `Assert::isInstanceOf($instance, self::class)` per mantenere type safety.

## Motivazione

PHPStan `new.static` segnala che `new static()` in una classe non finale puo rompersi se una sottoclasse cambia costruttore. Su una classe astratta aggiunge anche il rischio di chiamata diretta alla base.

## Nota widget schema-based

Quando moduli diversi referenziano `XotBaseSchemaWidget`, la classe deve esistere in Xot come base comune sopra `XotBaseWidget`. Non duplicare basi locali nei moduli dominio.
